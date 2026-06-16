ALTER TABLE travel_items
  ADD COLUMN IF NOT EXISTS legacy_pdf_path VARCHAR(255) NULL AFTER cta_label;