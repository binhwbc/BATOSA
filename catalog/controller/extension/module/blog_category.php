<?php
class ControllerExtensionModuleBlogCategory extends Controller {
	public function index() {
		
		$this->load->language('blog/blog');
		
		$this->load->model('blog/blog_category');

		$this->load->model('blog/blog');
		
		$data['heading_title_category'] = $this->language->get('heading_title_category');


		if (isset($this->request->get['blogpath'])) {
			$parts = explode('_', (string)$this->request->get['blogpath']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$data['category_1_id'] = $parts[0];
		} else {
			$data['category_1_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$data['category_2_id'] = $parts[1];
		} else {
			$data['category_2_id'] = 0;
		}
		
		$categories_1 = $this->model_blog_blog_category->getBlogCategories(0);
		
		$data['categories_1'] = array();
		
		foreach ($categories_1 as $category_1) {
		
			$level_2_data = array();
			
			$categories_2 = $this->model_blog_blog_category->getBlogCategories($category_1['blog_category_id']);
			
			foreach ($categories_2 as $category_2) {
				$level_3_data = array();

		// Second level
		$categories_2 = $this->model_blog_blog_category->getBlogCategories(0);
						
		$level_2_data[] = array(
			'category_2_id' => $category_2['blog_category_id'],
			'name'    	=> $category_2['name'],
			'children'	=> $level_3_data,
			'href'    	=> $this->url->link('blog/category', 'blogpath=' . $category_1['blog_category_id'] . '_' . $category_2['blog_category_id'])
			);					
		}
			
			// First level
			$data['categories'][] = array(
				'category_1_id' => $category_1['blog_category_id'],
				'name'     => $category_1['name'],				
				'children' => $level_2_data,
				'href'     => $this->url->link('blog/category', 'blogpath=' . $category_1['blog_category_id'])
			);
		}
		
		return $this->load->view('extension/module/blog_category', $data);
	}
}