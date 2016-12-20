<?php
class ModelBlogBlogCategory extends Model {

	public function addBlogCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category SET
		parent_id = '" . (int)$data['parent_id'] . "',
		sort_order = '" . (int)$data['sort_order'] . "',
		status = '" . (int)$data['status'] . "',
		date_added = NOW()
		");

		$blog_category_id = $this->db->getLastId();

		foreach ($data['blog_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_description SET
			blog_category_id = '" . (int)$blog_category_id . "',
			language_id = '" . (int)$language_id . "',
			name = '" . $this->db->escape($value['name']) . "',
			page_title = '" . $this->db->escape($value['page_title']) . "',
			meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "',
			meta_description = '" . $this->db->escape($value['meta_description']) . "',
			description = '" . $this->db->escape($value['description']) . "'");
		}

		if (isset($data['blog_category_store'])) {
			foreach ($data['blog_category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_store SET
				blog_category_id = '" . (int)$blog_category_id . "',
				store_id = '" . (int)$store_id . "'
			");
			}
		}

		if (isset($data['blog_category_layout'])) {
			foreach ($data['blog_category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_layout SET
					blog_category_id = '" . (int)$blog_category_id . "',
					store_id = '" . (int)$store_id . "',
					layout_id = '" . (int)$layout['layout_id'] . "'
				");
				}
			}
		}

		if ($data['keyword']) {
			
    foreach ($data['keyword'] as $language_id => $keyword) {
      if ($keyword) {$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog_category_id=" . (int)$blog_category_id . "', keyword = '" . $this->db->escape($keyword) . "', language_id = " . $language_id);}
    }
    
		}



      require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
      $seo = new ControllerCatalogSeoPack($this->registry);

      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` like 'seopack%'");

      foreach ($query->rows as $result) {
          if (!$result['serialized']) {
            $data[$result['key']] = $result['value'];
          } else {
            if ($result['value'][0] == '{') {$data[$result['key']] = json_decode($result['value'], true);} else {$data[$result['key']] = unserialize($result['value']);}
          }
        }

      if (isset($data)) {$seopack_parameters = $data['seopack_parameters'];}

      if ((isset($seopack_parameters['autourls'])) && ($seopack_parameters['autourls']))
        {
          require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
          $seo = new ControllerCatalogSeoPack($this->registry);

          $query = $this->db->query("SELECT cd.blog_category_id, cd.name, cd.language_id, l.code FROM ".DB_PREFIX."blog_category c
              inner join ".DB_PREFIX."blog_category_description cd on c.blog_category_id = cd.blog_category_id
              inner join ".DB_PREFIX."language l on l.language_id = cd.language_id
              where c.blog_category_id = '" . (int)$blog_category_id . "'");


          foreach ($query->rows as $category_row){


            if( strlen($category_row['name']) > 1 ){

              $slug = $seo->generateSlug($category_row['name']);
              $exist_query =  $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'blog_category_id=" . $category_row['blog_category_id'] . "' and language_id=".$category_row['language_id']);

              if(!$exist_query->num_rows){

                $exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");
                if($exist_keyword->num_rows){
                  $exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'blog_category_id=" . $category_row['blog_category_id'] . "'");
                  if($exist_keyword_lang->num_rows){
                      $slug = $seo->generateSlug($category_row['name']).'-'.rand();
                    }
                    else
                    {
                      $slug = $seo->generateSlug($category_row['name']).'-'.$category_row['code'];
                    }
                  }



                $add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword,language_id) VALUES ('blog_category_id=" . $category_row['blog_category_id'] . "', '" . $slug . "', " . $category_row['language_id'] . ")";
                $this->db->query($add_query);

              }
            }
          }
        }
    
		$this->cache->delete('blog_category');
	}

	public function editBlogCategory($blog_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_category SET
		parent_id = '" . (int)$data['parent_id'] . "',
		sort_order = '" . (int)$data['sort_order'] . "',
		status = '" . (int)$data['status'] . "'
		WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_category SET
			image = '" . $this->db->escape($data['image']) . "'
			WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		foreach ($data['blog_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_description SET
			blog_category_id = '" . (int)$blog_category_id . "',
			language_id = '" . (int)$language_id . "',
			name = '" . $this->db->escape($value['name']) . "',
			page_title = '" . $this->db->escape($value['page_title']) . "',
			meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "',
			meta_description = '" . $this->db->escape($value['meta_description']) . "',
			description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		if (isset($data['blog_category_store'])) {
			foreach ($data['blog_category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_store SET
				blog_category_id = '" . (int)$blog_category_id . "',
				store_id = '" . (int)$store_id . "'
				");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		if (isset($data['blog_category_layout'])) {
			foreach ($data['blog_category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_layout SET
					blog_category_id = '" . (int)$blog_category_id . "',
					store_id = '" . (int)$store_id . "',
					layout_id = '" . (int)$layout['layout_id'] . "'
					");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_category_id=" . (int)$blog_category_id. "'");

		if ($data['keyword']) {
			
    foreach ($data['keyword'] as $language_id => $keyword) {
      if ($keyword) {$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog_category_id=" . (int)$blog_category_id . "', keyword = '" . $this->db->escape($keyword) . "', language_id = " . $language_id);}
    }
    
		}



      require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
      $seo = new ControllerCatalogSeoPack($this->registry);

      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` like 'seopack%'");

      foreach ($query->rows as $result) {
          if (!$result['serialized']) {
            $data[$result['key']] = $result['value'];
          } else {
            if ($result['value'][0] == '{') {$data[$result['key']] = json_decode($result['value'], true);} else {$data[$result['key']] = unserialize($result['value']);}
          }
        }

      if (isset($data)) {$seopack_parameters = $data['seopack_parameters'];}

      if ((isset($seopack_parameters['autourls'])) && ($seopack_parameters['autourls']))
        {
          require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
          $seo = new ControllerCatalogSeoPack($this->registry);

          $query = $this->db->query("SELECT cd.blog_category_id, cd.name, cd.language_id, l.code FROM ".DB_PREFIX."blog_category c
              inner join ".DB_PREFIX."blog_category_description cd on c.blog_category_id = cd.blog_category_id
              inner join ".DB_PREFIX."language l on l.language_id = cd.language_id
              where c.blog_category_id = '" . (int)$blog_category_id . "'");


          foreach ($query->rows as $category_row){


            if( strlen($category_row['name']) > 1 ){

              $slug = $seo->generateSlug($category_row['name']);
              $exist_query =  $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'blog_category_id=" . $category_row['blog_category_id'] . "' and language_id=".$category_row['language_id']);

              if(!$exist_query->num_rows){

                $exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");
                if($exist_keyword->num_rows){
                  $exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'blog_category_id=" . $category_row['blog_category_id'] . "'");
                  if($exist_keyword_lang->num_rows){
                      $slug = $seo->generateSlug($category_row['name']).'-'.rand();
                    }
                    else
                    {
                      $slug = $seo->generateSlug($category_row['name']).'-'.$category_row['code'];
                    }
                  }



                $add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword,language_id) VALUES ('blog_category_id=" . $category_row['blog_category_id'] . "', '" . $slug . "', " . $category_row['language_id'] . ")";
                $this->db->query($add_query);

              }
            }
          }
        }
    
		$this->cache->delete('blog_category');
	}

	public function deleteBlogCategory($blog_category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_category_id=" . (int)$blog_category_id . "'");

		$query = $this->db->query("SELECT blog_category_id FROM " . DB_PREFIX . "blog_category WHERE parent_id = '" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteBlogCategory($result['blog_category_id']);
		}



      require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
      $seo = new ControllerCatalogSeoPack($this->registry);

      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` like 'seopack%'");

      foreach ($query->rows as $result) {
          if (!$result['serialized']) {
            $data[$result['key']] = $result['value'];
          } else {
            if ($result['value'][0] == '{') {$data[$result['key']] = json_decode($result['value'], true);} else {$data[$result['key']] = unserialize($result['value']);}
          }
        }

      if (isset($data)) {$seopack_parameters = $data['seopack_parameters'];}

      if ((isset($seopack_parameters['autourls'])) && ($seopack_parameters['autourls']))
        {
          require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
          $seo = new ControllerCatalogSeoPack($this->registry);

          $query = $this->db->query("SELECT cd.blog_category_id, cd.name, cd.language_id, l.code FROM ".DB_PREFIX."blog_category c
              inner join ".DB_PREFIX."blog_category_description cd on c.blog_category_id = cd.blog_category_id
              inner join ".DB_PREFIX."language l on l.language_id = cd.language_id
              where c.blog_category_id = '" . (int)$blog_category_id . "'");


          foreach ($query->rows as $category_row){


            if( strlen($category_row['name']) > 1 ){

              $slug = $seo->generateSlug($category_row['name']);
              $exist_query =  $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.query = 'blog_category_id=" . $category_row['blog_category_id'] . "' and language_id=".$category_row['language_id']);

              if(!$exist_query->num_rows){

                $exist_keyword = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "'");
                if($exist_keyword->num_rows){
                  $exist_keyword_lang = $this->db->query("SELECT query FROM " . DB_PREFIX . "url_alias WHERE " . DB_PREFIX . "url_alias.keyword = '" . $slug . "' AND " . DB_PREFIX . "url_alias.query <> 'blog_category_id=" . $category_row['blog_category_id'] . "'");
                  if($exist_keyword_lang->num_rows){
                      $slug = $seo->generateSlug($category_row['name']).'-'.rand();
                    }
                    else
                    {
                      $slug = $seo->generateSlug($category_row['name']).'-'.$category_row['code'];
                    }
                  }



                $add_query = "INSERT INTO " . DB_PREFIX . "url_alias (query, keyword,language_id) VALUES ('blog_category_id=" . $category_row['blog_category_id'] . "', '" . $slug . "', " . $category_row['language_id'] . ")";
                $this->db->query($add_query);

              }
            }
          }
        }
    
		$this->cache->delete('blog_category');
	}


    public function getKeyWords($blog_category_id) {
      $keywords = array();

      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_category_id=" . (int)$blog_category_id . "'");

      foreach ($query->rows as $result) {
        $keywords[$result['language_id']] = $result['keyword'];
      }
      return $keywords;
    }
    
	public function getBlogCategory($blog_category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blog_category WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		return $query->row;
	}

	public function getBlogIdCategories($filter_id) {
		$query = $this->db->query("SELECT *, (SELECT name FROM " . DB_PREFIX . "blog_category_description fgd WHERE
		f.blog_category_id = fgd.blog_category_id AND
		fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS
		`blog_category_id` FROM " . DB_PREFIX . "blog_category f LEFT JOIN " . DB_PREFIX . "blog_category_description fd ON (f.blog_category_id = fd.blog_category_id) WHERE
		f.blog_category_id = '" . (int)$filter_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getBlogCategories($parent_id) {
		$blog_category_data = $this->cache->get('blog_category.' . $this->config->get('config_language_id') . '.' . $parent_id);

		if (!$blog_category_data) {
			$blog_category_data = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category c LEFT JOIN " . DB_PREFIX . "blog_category_description cd ON (c.blog_category_id = cd.blog_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");

			foreach ($query->rows as $result) {
				$blog_category_data[] = array(
					'blog_category_id' => $result['blog_category_id'],
					'name'        => $this->getPath($result['blog_category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);

				$blog_category_data = array_merge($blog_category_data, $this->getBlogCategories($result['blog_category_id']));
			}

			$this->cache->set('blog_category.' . $this->config->get('config_language_id') . '.' . $parent_id, $blog_category_data);
		}

		return $blog_category_data;
	}

	public function getPath($blog_category_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "blog_category c LEFT JOIN " . DB_PREFIX . "blog_category_description cd ON (c.blog_category_id = cd.blog_category_id) WHERE c.blog_category_id = '" . (int)$blog_category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");

		$blog_category_info = $query->row;

		if ($blog_category_info['parent_id']) {
			return $this->getPath($blog_category_info['parent_id'], $this->config->get('config_language_id')) . " > " . $blog_category_info['name'];
		} else {
			return $blog_category_info['name'];
		}
	}

	public function getBlogCategoryDescriptions($blog_category_id) {
		$blog_category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$blog_category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'page_title'        => $result['page_title'],
				'meta_keywords'     => $result['meta_keywords'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}

		return $blog_category_description_data;
	}

	public function getBlogCategoryStores($blog_category_id) {
		$blog_category_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_to_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$blog_category_store_data[] = $result['store_id'];
		}

		return $blog_category_store_data;
	}

	public function getBlogCategoryLayouts($blog_category_id) {
		$blog_category_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_to_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		foreach ($query->rows as $result) {
			$blog_category_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $blog_category_layout_data;
	}

	public function getTotalBlogCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category");

		return $query->row['total'];
	}

	public function getTotalBlogCategoriesByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category WHERE image_id = '" . (int)$image_id . "'");

		return $query->row['total'];
	}

	public function getTotalBlogCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}


}