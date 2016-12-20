<?php
class ModelBlogBlogComment extends Model { 

	public function getBlogComments ($data = array()){
		$sql = 'SELECT c.*,bd.title FROM '.DB_PREFIX.'blog_comment c LEFT JOIN '
				. DB_PREFIX.'blog b ON b.blog_id=c.blog_id LEFT JOIN '
				. DB_PREFIX.'blog_description bd ON bd.blog_id=b.blog_id AND language_id='.(int)$this->config->get('config_language_id')
				;

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
	}
	
	public function getTotalBlogComments() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_comment");
		
		return $query->row['total'];
	}

	
	public function enableBlogComment($id) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_comment SET status = '1' WHERE blog_comment_id = '" . (int)$id . "'");
	}
	
	public function disableBlogComment($id) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_comment SET status = '0' WHERE blog_comment_id = '" . (int)$id . "'");
	}
	
	public function deleteBlogComment($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_comment WHERE blog_comment_id = '" . (int)$id . "'");
		
	} 

}