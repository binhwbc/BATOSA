<?php
class ControllerExtensionModuleBlogLatest extends Controller {
	public function index($setting) {
		
		$this->document->addStyle('catalog/view/theme/shopme/stylesheet/blog.css');
		
		static $module = 0;
		
		$this->load->language('blog/blog');
		$this->load->model('blog/blog');
		$this->load->model('tool/image');
		
		$data = array(
			'start' => 0,
			'limit' => $setting['limit']
		);
		
		$data['characters'] = $setting['characters'];
		$data['carousel'] = $setting['carousel'];
		$data['columns'] = $setting['columns'];
		$data['thumb'] = $setting['thumb'];
		
		foreach ($this->model_blog_blog->getLatestBlogs($data) as $result) {
      		$data['posts'][] = array(
        		'title' => $result['title'],
				'author' => $result['author'],
				'comment_total' => $this->model_blog_blog->getTotalCommentsByBlogId($result['blog_id']),
				'date_added_full' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'description' => substr(html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8'), 0, $setting['characters']) . "...",
				'count_read' => $result['count_read'],
				'image'   		=> $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
	    		'href'  => $this->url->link('blog/blog', 'blog_id=' . $result['blog_id'])
      		);
    	}
		
		$data['blog_show_all'] = $this->url->link('blog/home');
		
		$data['text_show_all'] = $this->language->get('text_show_all');
		$data['text_posted_on'] = $this->language->get('text_posted_on');
		$data['text_posted_by'] = $this->language->get('text_posted_by');
		$data['text_read'] = $this->language->get('text_read');
		$data['text_comments'] = $this->language->get('text_comments');
		$data['text_not_found'] = $this->language->get('text_not_found');
		$data['heading_title_latest'] = $this->language->get('heading_title_latest');
		$data['text_read_more'] = $this->language->get('text_read_more');

		$data['date_added_status'] = $this->config->get('blogsetting_date_added');
		$data['comments_count_status'] = $this->config->get('blogsetting_comments_count');
		$data['page_view_status'] = $this->config->get('blogsetting_page_view');
		$data['author_status'] = $this->config->get('blogsetting_author');
		
		$data['module'] = $module++;

		return $this->load->view('extension/module/blog_latest', $data);
	}
}