ALTER TABLE content_pages
    ADD COLUMN lang CHAR(2) NOT NULL DEFAULT 'de' AFTER id,
    DROP INDEX slug,
    DROP INDEX idx_content_slug,
    ADD UNIQUE KEY uq_content_lang_slug (lang, slug),
    ADD INDEX idx_content_lang_published (lang, is_published);

ALTER TABLE news_items
    ADD COLUMN lang CHAR(2) NOT NULL DEFAULT 'de' AFTER id,
    DROP INDEX slug,
    DROP INDEX idx_news_slug,
    ADD UNIQUE KEY uq_news_lang_slug (lang, slug),
    ADD INDEX idx_news_lang_published (lang, is_published, published_at);

ALTER TABLE travel_items
    ADD COLUMN lang CHAR(2) NOT NULL DEFAULT 'de' AFTER id,
    DROP INDEX slug,
    DROP INDEX idx_travel_slug,
    ADD UNIQUE KEY uq_travel_lang_slug (lang, slug),
    ADD INDEX idx_travel_lang_published (lang, is_published, starts_on);

ALTER TABLE forum_posts
    ADD FULLTEXT KEY ft_forum_search (title, body);

ALTER TABLE content_pages
    ADD FULLTEXT KEY ft_content_search (title, teaser, body);

ALTER TABLE news_items
    ADD FULLTEXT KEY ft_news_search (title, teaser, body);

ALTER TABLE travel_items
    ADD FULLTEXT KEY ft_travel_search (title, teaser, body);