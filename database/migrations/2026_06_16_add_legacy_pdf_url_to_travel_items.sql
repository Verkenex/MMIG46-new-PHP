ALTER TABLE travel_items
  ADD COLUMN legacy_pdf_url VARCHAR(500) NULL AFTER cta_label;