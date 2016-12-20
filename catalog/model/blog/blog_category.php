<?php
class ModelBlogBlogCategory extends Model {
	public function getBlogCategory($blog_category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blog_category c LEFT JOIN " . DB_PREFIX . "blog_category_description cd ON (c.blog_category_id = cd.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category_to_store c2s ON (c.blog_category_id = c2s.blog_category_id) WHERE c.blog_category_id = '" . (int)$blog_category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
		return $query->row;
	}
	
	public function getBlogCategories($parent_id = 0) {

		$blog_category_data = $this->cache->get('blog_category.' . $parent_id . '.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));

		if (!$blog_category_data && !is_array($blog_category_data)) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category c LEFT JOIN " . DB_PREFIX . "blog_category_description cd ON (c.blog_category_id = cd.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category_to_store c2s ON (c.blog_category_id = c2s.blog_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' AND c.sort_order <> '-1' ORDER BY c.sort_order, LCASE(cd.name)");

			$blog_category_data = $query->rows;

			$this->cache->set('blog_category.' . $parent_id . '.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $blog_category_data);
		}

		return $blog_category_data;
	}
				
	public function getTotalBlogCategoriesByBlogCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category c LEFT JOIN " . DB_PREFIX . "blog_category_to_store c2s ON (c.blog_category_id = c2s.blog_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1' AND c.sort_order <> '-1'");
		
		return $query->row['total'];
	}
	
	public function getBlogCategoriesByParentId($blog_category_id) {
		$blog_category_data = array();
		
		$blog_category_data[] = $blog_category_id;
		
		$blog_category_query = $this->db->query("SELECT blog_category_id FROM " . DB_PREFIX . "blog_category WHERE parent_id = '" . (int)$blog_category_id . "'");
		
		foreach ($blog_category_query->rows as $blog_category) {
			$children = $this->getBlogCategoriesByParentId($blog_category['blog_category_id']);
			
			if ($children) {
				$blog_category_data = array_merge($children, $blog_category_data);
			}			
		}
		
		return $blog_category_data;
	}
}