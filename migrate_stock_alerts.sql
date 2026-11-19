USE leader_app;
-- Run once on an existing Madar database. The default keeps current stock records valid.
ALTER TABLE products ADD COLUMN min_quantity DECIMAL(12,2) NOT NULL DEFAULT 0 AFTER quantity;

