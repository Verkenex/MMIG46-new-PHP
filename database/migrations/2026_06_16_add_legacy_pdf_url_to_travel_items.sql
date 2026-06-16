ALTER TABLE travel_items
  ADD COLUMN IF NOT EXISTS legacy_pdf_url VARCHAR(500) NULL AFTER cta_label;