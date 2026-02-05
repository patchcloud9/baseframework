-- Remove homepage icon columns (idempotent)
ALTER TABLE homepage_settings
  DROP COLUMN IF EXISTS card1_icon,
  DROP COLUMN IF EXISTS card2_icon,
  DROP COLUMN IF EXISTS card3_icon;