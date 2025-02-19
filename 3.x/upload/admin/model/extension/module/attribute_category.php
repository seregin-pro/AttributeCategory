<?php
class ModelExtensionModuleAttributeCategory extends Model {
	public function createColumns() {
		$query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_attribute");
		$attribute_status = false;

		if ($query->rows) {	
			foreach ($query->rows as $row) {
				if ($row['Field'] == 'attribute_status') {
					$attribute_status = true;
				}
			}
			
			if (!$attribute_status) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_attribute`  ADD `attribute_status` INT NOT NULL");
			}
		}
	}
}