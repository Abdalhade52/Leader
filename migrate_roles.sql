USE leader_app;
-- Back up first. Run exactly once against the previous schema.
ALTER TABLE branches ADD UNIQUE KEY uq_branch_scope(id,shop_id);
ALTER TABLE products ADD UNIQUE KEY uq_product_scope(id,shop_id);
ALTER TABLE users MODIFY role ENUM('owner','staff','employee','branch_manager','company_manager') NOT NULL DEFAULT 'employee';
ALTER TABLE users ADD COLUMN branch_id BIGINT UNSIGNED NULL AFTER shop_id;
UPDATE users SET role='employee' WHERE role='staff';
ALTER TABLE users ADD CONSTRAINT fk_user_branch_scope FOREIGN KEY(branch_id,shop_id) REFERENCES branches(id,shop_id) ON DELETE RESTRICT;
ALTER TABLE exports DROP FOREIGN KEY exports_ibfk_2, DROP FOREIGN KEY exports_ibfk_3;
ALTER TABLE exports ADD CONSTRAINT fk_export_branch_scope FOREIGN KEY(branch_id,shop_id) REFERENCES branches(id,shop_id);
ALTER TABLE exports ADD CONSTRAINT fk_export_product_scope FOREIGN KEY(product_id,shop_id) REFERENCES products(id,shop_id);
-- Assign branch_id to every employee and branch_manager before letting them sign in.

