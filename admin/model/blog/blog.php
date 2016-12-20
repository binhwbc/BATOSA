<?php
class ModelBlogBlog extends Model {
	public function addBlog($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog SET
		sort_order = '" . (int)$this->request->post['sort_order'] . "',
		image = '" . $this->db->escape($data['image']) . "',
		status = '" . (int)$data['status'] . "',
		author = '" . $this->db->escape($data['author']) . "',
		allow_comment = '" . (int)$data['allow_comment'] . "',
		date_added = NOW()");

		$blog_id = $this->db->getLastId();

		foreach ($data['blog_description'] as $language_id => $value) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_description SET
		blog_id = '" . (int)$blog_id . "',
		language_id = '" . (int)$language_id . "',
		title = '" . $this->db->escape($value['title']) . "',
		page_title = '" . $this->db->escape($value['page_title']) . "',
		short_description = '" . $this->db->escape($value['short_description']) . "',
		meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "',
		meta_description = '" . $this->db->escape($value['meta_description']) . "',
		description = '" . $this->db->escape($value['description']) . "',
		tags = '" . $this->db->escape($value['tags']) . "'
		")
		;}

		if (isset($data['blog_store'])) {
			foreach ($data['blog_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_store SET
				blog_id = '" . (int)$blog_id . "',
				store_id = '" . (int)$store_id . "'
				");
			}
		}

		if (isset($data['blog_layout'])) {
			foreach ($data['blog_layout'] as $store_id => $layout) {
				if ($layout) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_layout SET
					blog_id = '" . (int)$blog_id . "',
					store_id = '" . (int)$store_id . "',
					layout_id = '" . (int)$layout['layout_id'] . "'
					");
				}
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog_id=" . (int)$blog_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['this_blog_category'])) {
			foreach ($data['this_blog_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_category SET
				blog_id = '" . (int)$blog_id . "',
				blog_category_id = '" . (int)$blog_category_id . "'
				");
			}
		}

		if (isset($data['related_blog'])) {
			foreach ($data['related_blog'] as $child_blog_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_related SET
				parent_blog_id = '" . (int)$blog_id . "',
				child_blog_id = '" . (int)$child_blog_id . "'
				");
			}
		}

		$this->cache->delete('blog');
	}

	public function editBlog($blog_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET
		sort_order = '" . (int)$data['sort_order'] . "',
		image = '" . $this->db->escape($data['image']) . "',
		allow_comment = '" . (int)$data['allow_comment'] . "' ,
		author = '" . $this->db->escape($data['author']) . "',
		status = '" . (int)$data['status'] . "'
		WHERE blog_id = '" . (int)$blog_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_description WHERE blog_id = '" . (int)$blog_id . "'");

		foreach ($data['blog_description'] as $language_id => $value) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_description SET
		blog_id = '" . (int)$blog_id . "',
		language_id = '" . (int)$language_id . "',
		title = '" . $this->db->escape($value['title']) . "',
		page_title = '" . $this->db->escape($value['page_title']) . "',
		short_description = '" . $this->db->escape($value['short_description']) . "',
		meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "',
		meta_description = '" . $this->db->escape($value['meta_description']) . "',
		description = '" . $this->db->escape($value['description']) . "',
		tags = '" . $this->db->escape($value['tags']) . "'
		");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_store WHERE blog_id = '" . (int)$blog_id . "'");

		if (isset($data['blog_store'])) {
			foreach ($data['blog_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_store SET
				blog_id = '" . (int)$blog_id . "',
				store_id = '" . (int)$store_id . "'
				");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_layout WHERE blog_id = '" . (int)$blog_id . "'");

		if (isset($data['blog_layout'])) {
			foreach ($data['blog_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_layout SET
					blog_id = '" . (int)$blog_id . "',
					store_id = '" . (int)$store_id . "',
					layout_id = '" . (int)$layout['layout_id'] . "'
					");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_id=" . (int)$blog_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog_id=" . (int)$blog_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_category WHERE blog_id = '" . (int)$blog_id . "'");

		if (isset($data['this_blog_category'])) {
			foreach ($data['this_blog_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_category SET
				blog_id = '" . (int)$blog_id . "',
				blog_category_id = '" . (int)$blog_category_id . "'
				");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related WHERE parent_blog_id = '" . (int)$blog_id . "'");

		if (isset($data['related_blog'])) {
			foreach ($data['related_blog'] as $child_blog_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_related SET
				parent_blog_id = '" . (int)$blog_id . "',
				child_blog_id = '" . (int)$child_blog_id . "'
				");
			}
		}

		$this->cache->delete('blog');
	}

	public function deleteBlog($blog_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog WHERE blog_id = '" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_description WHERE blog_id = '" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_store WHERE blog_id = '" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_layout WHERE blog_id = '" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_id=" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related WHERE parent_blog_id = '" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_category WHERE blog_id = '" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_comment WHERE blog_id = '" . (int)$blog_id . "'");

		$this->cache->delete('blog');
	}

	public function getBlog($blog_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_id=" . (int)$blog_id . "') AS keyword FROM " . DB_PREFIX . "blog WHERE blog_id = '" . (int)$blog_id . "'");

		return $query->row;
	}

	public function getBlogs($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "blog i LEFT JOIN " . DB_PREFIX . "blog_description id ON (i.blog_id = id.blog_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'id.title',
				'i.date_added',
				'i.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY i.blog_id";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$blog_data = $this->cache->get('blog.' . $this->config->get('config_language_id'));

			if (!$blog_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog i LEFT JOIN " . DB_PREFIX . "blog_description id ON (i.blog_id = id.blog_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$blog_data = $query->rows;

				$this->cache->set('blog.' . $this->config->get('config_language_id'), $blog_data);
			}

			return $blog_data;
		}
	}

	public function getBlogDescriptions($blog_id) {
		$blog_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_description WHERE blog_id = '" . (int)$blog_id . "'");

		foreach ($query->rows as $result) {
			$blog_description_data[$result['language_id']] = array(
				'title'       => $result['title'],
				'page_title'       => $result['page_title'],
				'meta_keyword'       => $result['meta_keyword'],
				'meta_description'       => $result['meta_description'],
				'tags'       => $result['tags'],
				'short_description'       => $result['short_description'],
				'description' => $result['description']
			);
		}

		return $blog_description_data;
	}

	public function getBlogStores($blog_id) {
		$blog_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_to_store WHERE blog_id = '" . (int)$blog_id . "'");

		foreach ($query->rows as $result) {
			$blog_store_data[] = $result['store_id'];
		}

		return $blog_store_data;
	}

	public function getBlogCategories($blog_id) {
		$blog_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_to_category WHERE blog_id = '" . (int)$blog_id . "'");

		foreach ($query->rows as $result) {
			$blog_category_data[] = $result['blog_category_id'];
		}

		return $blog_category_data;
	}



	public function getTotalBlogs() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog");

		return $query->row['total'];
	}

	public function getRelatedBlog($blog_id) {
		$related_blog_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_related WHERE parent_blog_id = '" . (int)$blog_id . "'");

		foreach ($query->rows as $result) {
			$related_blog_data[] = $result['child_blog_id'];
		}

		return $related_blog_data;
	}

	public function getCommentsByBlogId($blog_id, $start = 0, $limit = 40) {
		$query = $this->db->query("SELECT nc.blog_comment_id, nc.blog_id, nc.name, nc.email, nc.comment, nc.status, n.blog_id, nd.title, n.image, nc.date_added FROM " . DB_PREFIX . "blog_comment nc LEFT JOIN " . DB_PREFIX . "blog n ON (nc.blog_id = n.blog_id) LEFT JOIN " . DB_PREFIX . "blog_description nd ON (n.blog_id = nd.blog_id) WHERE n.blog_id = '" . (int)$blog_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY nc.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalCommentsByBlogId($blog_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment nc LEFT JOIN " . DB_PREFIX . "blog n ON (nc.blog_id = n.blog_id) LEFT JOIN " . DB_PREFIX . "blog_description nd ON (n.blog_id = nd.blog_id) WHERE n.blog_id = '" . (int)$blog_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}

	public function getBlogLayouts($blog_id) {
		$blog_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_to_layout WHERE blog_id = '" . (int)$blog_id . "'");

		foreach ($query->rows as $result) {
			$blog_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $blog_layout_data;
	}
}
