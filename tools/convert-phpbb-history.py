#!/usr/bin/env python3
"""Convert the approved phpBB history into a private MMIG46 import package.

The generated SQL and copied attachments contain real forum content and must
never be committed. The converter deliberately ignores users' credentials,
email addresses, IP addresses, private messages, drafts and profile data.
"""

from __future__ import annotations

import argparse
import hashlib
import html
import json
import re
import shutil
from collections import Counter
from datetime import datetime, timezone
from pathlib import Path


INCLUDED_FORUMS = {
    4: ("Gäste · Allgemeines / Guests · Discussion", "public", 10),
    5: ("Gäste · Suche / Guests · Search", "public", 20),
    6: ("Gäste · Biete / Guests · Offer", "public", 30),
    8: ("Mitglieder · Allgemeines / Members · Discussion", "member", 40),
    9: ("Mitglieder · Verein / Members · Club", "member", 50),
    10: ("Mitglieder · Technik / Members · Technics", "member", 60),
    19: ("Mitglieder · Treffpunkt / Members · Meeting", "member", 70),
}


def mysql_unescape(value: str) -> str:
    replacements = {
        "0": "\0", "b": "\b", "n": "\n", "r": "\r",
        "t": "\t", "Z": "\x1a", "\\": "\\", "'": "'", '"': '"',
    }
    output: list[str] = []
    escaped = False
    for char in value:
        if escaped:
            output.append(replacements.get(char, char))
            escaped = False
        elif char == "\\":
            escaped = True
        else:
            output.append(char)
    if escaped:
        output.append("\\")
    return "".join(output)


def decode_value(raw: str):
    raw = raw.strip()
    if raw.upper() == "NULL":
        return None
    if re.fullmatch(r"0x[0-9a-fA-F]*", raw):
        data = bytes.fromhex(raw[2:])
        try:
            return data.decode("utf-8")
        except UnicodeDecodeError:
            return data.decode("latin-1")
    if len(raw) >= 2 and raw[0] == raw[-1] == "'":
        return mysql_unescape(raw[1:-1])
    return raw


def parse_rows(values: str) -> list[list[object]]:
    rows: list[list[object]] = []
    row: list[object] = []
    value: list[str] = []
    depth = 0
    quoted = False
    escaped = False

    for char in values:
        if quoted:
            value.append(char)
            if escaped:
                escaped = False
            elif char == "\\":
                escaped = True
            elif char == "'":
                quoted = False
            continue

        if char == "'":
            quoted = True
            value.append(char)
        elif char == "(" and depth == 0:
            depth = 1
            row = []
            value = []
        elif char == ")" and depth == 1:
            row.append(decode_value("".join(value)))
            rows.append(row)
            depth = 0
            value = []
        elif char == "," and depth == 1:
            row.append(decode_value("".join(value)))
            value = []
        elif depth == 1:
            value.append(char)

    if quoted or depth != 0:
        raise ValueError("Unvollstaendiger INSERT-Datensatz im phpBB-Dump")
    return rows


def load_table(dump: str, table: str) -> list[dict[str, object]]:
    pattern = re.compile(
        rf"INSERT INTO `{re.escape(table)}` \((.*?)\) VALUES\s*(.*?);\s*(?=(?:INSERT|ALTER|CREATE|DROP|--|$))",
        re.DOTALL,
    )
    records: list[dict[str, object]] = []
    for match in pattern.finditer(dump):
        columns = [part.strip(" `\n\r\t") for part in match.group(1).split(",")]
        for row in parse_rows(match.group(2)):
            if len(row) != len(columns):
                raise ValueError(f"Spaltenzahl passt nicht in {table}")
            records.append(dict(zip(columns, row)))
    if not records:
        raise ValueError(f"Keine Daten fuer {table} gefunden")
    return records


def integer(value: object) -> int:
    try:
        return int(str(value or 0))
    except ValueError:
        return 0


def clean_text(value: object) -> str:
    text = str(value or "").replace("\r\n", "\n").replace("\r", "\n")
    text = re.sub(r"<br\s*/?>", "\n", text, flags=re.IGNORECASE)
    text = re.sub(r"<s>.*?</s>|<e>.*?</e>", "", text, flags=re.IGNORECASE | re.DOTALL)
    text = re.sub(r"<LINK_TEXT[^>]*>|</LINK_TEXT>", "", text, flags=re.IGNORECASE)
    text = re.sub(r"<URL\s+url=\"([^\"]+)\">(.*?)</URL>", r"\2 (\1)", text, flags=re.IGNORECASE | re.DOTALL)
    text = re.sub(r"<EMAIL\s+email=\"([^\"]+)\">(.*?)</EMAIL>", r"\2 (\1)", text, flags=re.IGNORECASE | re.DOTALL)
    text = re.sub(r"<IMG\s+src=\"([^\"]+)\">.*?</IMG>", r"Bild: \1", text, flags=re.IGNORECASE | re.DOTALL)
    text = re.sub(r"<[^>]+>", "", text)
    text = html.unescape(text)
    text = re.sub(
        r"(?i)\b(?:mailto:)?[a-z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-z0-9-]+(?:\.[a-z0-9-]+)+\b",
        "[E-Mail-Adresse entfernt]",
        text,
    )
    text = re.sub(r"\[attachment(?:=\d+)?(?::[a-z0-9]+)?\].*?\[/attachment(?::[a-z0-9]+)?\]", "", text, flags=re.IGNORECASE | re.DOTALL)
    text = re.sub(r"\[/?(?:b|i|u|s|size|color|font|quote|code|list|\*|img|url|email)(?:=[^\]]*)?(?::[a-z0-9]+)?\]", "", text, flags=re.IGNORECASE)
    text = re.sub(r"\n[ \t]+", "\n", text)
    text = re.sub(r"\n{3,}", "\n\n", text)
    return text.strip()


def slugify(value: str, legacy_id: int) -> str:
    value = value.lower()
    value = value.translate(str.maketrans("äöüß", "aous"))
    value = re.sub(r"[^a-z0-9]+", "-", value).strip("-")[:170]
    return f"archiv-{legacy_id}-{value or 'thema'}"


def sql_string(value: object) -> str:
    if value is None:
        return "NULL"
    text = str(value).replace("\\", "\\\\").replace("'", "''").replace("\0", "")
    return "'" + text + "'"


def sql_datetime(timestamp: object) -> str:
    value = integer(timestamp)
    if value <= 0:
        return "NULL"
    return sql_string(datetime.fromtimestamp(value, tz=timezone.utc).strftime("%Y-%m-%d %H:%M:%S"))


def author_for(post: dict[str, object], users: dict[int, str]) -> str:
    guest_name = clean_text(post.get("post_username"))
    if guest_name:
        return guest_name[:255]
    return users.get(integer(post.get("poster_id")), "Unbekannt")[:255]


def build_package(dump_path: Path, source_files: Path, output_sql: Path, output_files: Path) -> dict[str, object]:
    dump = dump_path.read_text(encoding="utf-8-sig")
    users = {integer(row["user_id"]): clean_text(row["username"]) for row in load_table(dump, "phpbb_users")}
    topics = load_table(dump, "phpbb_topics")
    posts = load_table(dump, "phpbb_posts")
    attachments = load_table(dump, "phpbb_attachments")

    included_topics = {
        integer(row["topic_id"]): row for row in topics
        if integer(row["forum_id"]) in INCLUDED_FORUMS
        and integer(row.get("topic_visibility")) == 1
        and integer(row.get("topic_moved_id")) == 0
    }
    included_posts = [
        row for row in posts
        if integer(row["topic_id"]) in included_topics
        and integer(row.get("post_visibility")) == 1
    ]
    included_post_ids = {integer(row["post_id"]) for row in included_posts}

    output_files.mkdir(parents=True, exist_ok=True)
    lines = [
        "-- Private, generated phpBB history import. Do not commit.",
        "SET NAMES utf8mb4;",
        "START TRANSACTION;",
        "",
    ]

    for forum_id, (name, visibility, order) in INCLUDED_FORUMS.items():
        lines.append(
            "INSERT INTO forum_sections (name, visibility, sort_order, legacy_phpbb_forum_id) "
            f"SELECT {sql_string(name)}, {sql_string(visibility)}, {order}, {forum_id} "
            f"WHERE NOT EXISTS (SELECT 1 FROM forum_sections WHERE legacy_phpbb_forum_id={forum_id});"
        )

    lines.append("")
    for legacy_id, topic in sorted(included_topics.items()):
        forum_id = integer(topic["forum_id"])
        title = clean_text(topic.get("topic_title")) or "Historisches Thema"
        author = clean_text(topic.get("topic_first_poster_name")) or users.get(integer(topic.get("topic_poster")), "Unbekannt")
        created = sql_datetime(topic.get("topic_time"))
        updated = sql_datetime(topic.get("topic_last_post_time"))
        pinned = 1 if integer(topic.get("topic_type")) > 0 else 0
        locked = 1 if integer(topic.get("topic_status")) == 1 else 0
        lines.append(
            "INSERT INTO forum_topics (user_id, section_id, legacy_author_name, legacy_phpbb_topic_id, title, slug, "
            "is_pinned, is_locked, is_public, created_at, updated_at) "
            f"SELECT NULL, s.id, {sql_string(author)}, {legacy_id}, {sql_string(title)}, {sql_string(slugify(title, legacy_id))}, "
            f"{pinned}, {locked}, 0, {created}, {updated} FROM forum_sections s "
            f"WHERE s.legacy_phpbb_forum_id={forum_id} AND NOT EXISTS "
            f"(SELECT 1 FROM forum_topics WHERE legacy_phpbb_topic_id={legacy_id});"
        )

    lines.append("")
    for post in sorted(included_posts, key=lambda row: integer(row["post_id"])):
        legacy_id = integer(post["post_id"])
        topic_id = integer(post["topic_id"])
        body = clean_text(post.get("post_text")) or "[Leerer historischer Beitrag]"
        created = sql_datetime(post.get("post_time"))
        updated = sql_datetime(post.get("post_edit_time")) if integer(post.get("post_edit_time")) else "NULL"
        lines.append(
            "INSERT INTO forum_posts (topic_id, user_id, legacy_author_name, legacy_phpbb_post_id, body, is_deleted, created_at, updated_at) "
            f"SELECT t.id, NULL, {sql_string(author_for(post, users))}, {legacy_id}, {sql_string(body)}, 0, {created}, {updated} "
            f"FROM forum_topics t WHERE t.legacy_phpbb_topic_id={topic_id} AND NOT EXISTS "
            f"(SELECT 1 FROM forum_posts WHERE legacy_phpbb_post_id={legacy_id});"
        )

    copied = 0
    missing: list[str] = []
    lines.append("")
    for attachment in sorted(attachments, key=lambda row: integer(row["attach_id"])):
        attach_id = integer(attachment["attach_id"])
        post_id = integer(attachment["post_msg_id"])
        if post_id not in included_post_ids or integer(attachment.get("in_message")) or integer(attachment.get("is_orphan")):
            continue
        physical_name = Path(str(attachment.get("physical_filename") or "")).name
        source = source_files / physical_name
        if not source.is_file():
            missing.append(physical_name)
            continue
        stored_name = hashlib.sha256(f"{attach_id}:{physical_name}".encode()).hexdigest()
        shutil.copyfile(source, output_files / stored_name)
        copied += 1
        lines.append(
            "INSERT INTO forum_attachments (post_id, original_name, stored_name, mime_type, file_size, download_count, legacy_phpbb_attach_id, created_at) "
            f"SELECT p.id, {sql_string(clean_text(attachment.get('real_filename')) or 'Anhang')}, {sql_string(stored_name)}, "
            f"{sql_string(clean_text(attachment.get('mimetype')) or 'application/octet-stream')}, {integer(attachment.get('filesize'))}, "
            f"{integer(attachment.get('download_count'))}, {attach_id}, {sql_datetime(attachment.get('filetime'))} "
            f"FROM forum_posts p WHERE p.legacy_phpbb_post_id={post_id} AND NOT EXISTS "
            f"(SELECT 1 FROM forum_attachments WHERE legacy_phpbb_attach_id={attach_id});"
        )

    lines.extend(["", "COMMIT;", ""])
    output_sql.parent.mkdir(parents=True, exist_ok=True)
    output_sql.write_text("\n".join(lines), encoding="utf-8")

    report = {
        "sections": len(INCLUDED_FORUMS),
        "topics": len(included_topics),
        "posts": len(included_posts),
        "attachments": copied,
        "missing_attachments": missing,
        "topics_by_forum": dict(sorted(Counter(integer(row["forum_id"]) for row in included_topics.values()).items())),
        "excluded": {
            "admin_topics": sum(integer(row["forum_id"]) == 12 for row in topics),
            "private_messages": "not read",
            "drafts": "not read",
            "user_accounts": "not imported",
        },
    }
    output_sql.with_suffix(".report.json").write_text(json.dumps(report, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
    return report


def main() -> None:
    parser = argparse.ArgumentParser()
    parser.add_argument("--dump", required=True, type=Path)
    parser.add_argument("--files", required=True, type=Path)
    parser.add_argument("--output-sql", required=True, type=Path)
    parser.add_argument("--output-files", required=True, type=Path)
    args = parser.parse_args()
    report = build_package(args.dump, args.files, args.output_sql, args.output_files)
    print(json.dumps(report, ensure_ascii=False, indent=2))


if __name__ == "__main__":
    main()
