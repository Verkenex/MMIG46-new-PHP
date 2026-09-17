import importlib.util
import unittest
from pathlib import Path


MODULE_PATH = Path(__file__).parents[1] / "tools" / "convert-phpbb-history.py"
SPEC = importlib.util.spec_from_file_location("phpbb_history", MODULE_PATH)
MODULE = importlib.util.module_from_spec(SPEC)
assert SPEC.loader is not None
SPEC.loader.exec_module(MODULE)


class PhpbbHistoryConverterTest(unittest.TestCase):
    def test_parser_decodes_hex_and_escaped_strings(self):
        rows = MODULE.parse_rows("(1, 0x4dc3bc6e6368656e, 'O\\'Brien')")
        self.assertEqual(rows, [["1", "München", "O'Brien"]])

    def test_clean_text_removes_phpbb_rendering_markup(self):
        source = '<r><B><s>[b]</s>Hallo<e>[/b]</e></B><br/>Welt</r>'
        self.assertEqual(MODULE.clean_text(source), "Hallo\nWelt")

    def test_slug_contains_stable_legacy_id(self):
        self.assertEqual(MODULE.slugify("Grüße aus Köln", 42), "archiv-42-gruse-aus-koln")

    def test_embedded_email_addresses_are_redacted(self):
        self.assertEqual(
            MODULE.clean_text("Kontakt: pilot@example.com"),
            "Kontakt: [E-Mail-Adresse entfernt]",
        )

    def test_private_table_names_are_not_converter_inputs(self):
        source = MODULE_PATH.read_text(encoding="utf-8")
        self.assertNotIn('load_table(dump, "phpbb_privmsgs")', source)
        self.assertNotIn('load_table(dump, "phpbb_drafts")', source)


if __name__ == "__main__":
    unittest.main()
