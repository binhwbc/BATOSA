<?php
class ModelDesignMenu extends Model {

	/////////////////// getMenu()
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getMenu($menu_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu WHERE menu_id = '" . (int)$menu_id . "' AND status='1'");
		return $query->row;
	}

	public function getMenuByPosition($position) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu WHERE position = '" . (int)$position . "' AND status='1'");
		return $query->row;
	}

	public function getPosition($position_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_position WHERE name = '" . $position_id . "'");
		return $query->row;
	}

}