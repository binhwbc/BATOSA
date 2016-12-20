<?php
class ControllerBlogBlogSetting extends Controller { 
	private $error = array();

	public function index() {
		
		$this->load->language('blog/blog_setting');

		$this->document->setTitle($this->language->get('heading_title'));
		 
		$this->load->model('blog/blog_setting');
		
		$this->model_blog_blog_setting->install();
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_blog_blog_setting->editBlogSetting('blogsetting', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('blog/blog_setting', 'token=' . $this->session->data['token'], true));
		}
	
		$data['error_missing'] = $this->language->get('error_missing');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['heading_blog_home'] = $this->language->get('heading_blog_home');
		$data['heading_blog_listing'] = $this->language->get('heading_blog_listing');
		$data['heading_blog_listing_h'] = $this->language->get('heading_blog_listing_h');
		$data['heading_blog_post'] = $this->language->get('heading_blog_post');
		$data['heading_related'] = $this->language->get('heading_related');
		$data['heading_comments'] = $this->language->get('heading_comments');
		$data['heading_author'] = $this->language->get('heading_author');

		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		
		$data['entry_blogsetting_home_title'] = $this->language->get('entry_blogsetting_home_title');
		$data['entry_blogsetting_home_page_title'] = $this->language->get('entry_blogsetting_home_page_title');
		$data['entry_blogsetting_home_description'] = $this->language->get('entry_blogsetting_home_description');
		$data['entry_blogsetting_home_meta_description'] = $this->language->get('entry_blogsetting_home_meta_description');
		$data['entry_blogsetting_home_meta_keyword'] = $this->language->get('entry_blogsetting_home_meta_keyword');
		$data['entry_blogsetting_home_url'] = $this->language->get('entry_blogsetting_home_url');
		$data['entry_blogsetting_home_url_h'] = $this->language->get('entry_blogsetting_home_url_h');
		$data['entry_blogsetting_blogs_per_page'] = $this->language->get('entry_blogsetting_blogs_per_page');
		$data['entry_blogsetting_layout'] = $this->language->get('entry_blogsetting_layout');
		$data['entry_blogsetting_thumbs_w'] = $this->language->get('entry_blogsetting_thumbs_w');
		$data['entry_blogsetting_thumbs_h'] = $this->language->get('entry_blogsetting_thumbs_h');
		$data['entry_blogsetting_date_added'] = $this->language->get('entry_blogsetting_date_added');
		$data['entry_blogsetting_comments_count'] = $this->language->get('entry_blogsetting_comments_count');
		$data['entry_blogsetting_page_view'] = $this->language->get('entry_blogsetting_page_view');
		$data['entry_blogsetting_author'] = $this->language->get('entry_blogsetting_author');
		$data['entry_blogsetting_share'] = $this->language->get('entry_blogsetting_share');
		$data['entry_blogsetting_post_thumb'] = $this->language->get('entry_blogsetting_post_thumb');
		$data['entry_blogsetting_rel_characters'] = $this->language->get('entry_blogsetting_rel_characters');
		$data['entry_blogsetting_rel_blog_per_row'] = $this->language->get('entry_blogsetting_rel_blog_per_row');
		$data['entry_blogsetting_rel_thumb'] = $this->language->get('entry_blogsetting_rel_thumb');
		$data['entry_blogsetting_rel_thumbs_w'] = $this->language->get('entry_blogsetting_rel_thumbs_w');
		$data['entry_blogsetting_rel_thumbs_h'] = $this->language->get('entry_blogsetting_rel_thumbs_h');
		$data['entry_blogsetting_post_date_added'] = $this->language->get('entry_blogsetting_post_date_added');
		$data['entry_blogsetting_post_comments_count'] = $this->language->get('entry_blogsetting_post_comments_count');
		$data['entry_blogsetting_post_page_view'] = $this->language->get('entry_blogsetting_post_page_view');
		$data['entry_blogsetting_post_author'] = $this->language->get('entry_blogsetting_post_author');
		$data['entry_blogsetting_comment_per_page'] = $this->language->get('entry_blogsetting_comment_per_page');
		$data['entry_blogsetting_comment_approve'] = $this->language->get('entry_blogsetting_comment_approve');
		$data['entry_blogsetting_comment_approve_h'] = $this->language->get('entry_blogsetting_comment_approve_h');
		$data['entry_blogsetting_comment_notification'] = $this->language->get('entry_blogsetting_comment_notification');
		$data['entry_blogsetting_comment_notification_h'] = $this->language->get('entry_blogsetting_comment_notification_h');
		$data['entry_blogsetting_author_change'] = $this->language->get('entry_blogsetting_author_change');
		$data['entry_blogsetting_author_change_h'] = $this->language->get('entry_blogsetting_author_change_h');
		$data['entry_blogsetting_thumb_size'] = $this->language->get('entry_blogsetting_thumb_size');
		$data['entry_blogsetting_rel_thumbs'] = $this->language->get('entry_blogsetting_rel_thumbs');

		
		$data['button_save'] = $this->language->get('button_save');

		$data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		$url = '';
					
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true)
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('blog/blog_setting', 'token=' . $this->session->data['token'] . $url, true)
   		);
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
							
		$data['action'] = $this->url->link('blog/blog_setting', 'token=' . $this->session->data['token'], true);
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['blogsetting_home_title'])) {
			$data['blogsetting_home_title'] = $this->request->post['blogsetting_home_title'];
		} else {
			$data['blogsetting_home_title'] = $this->config->get('blogsetting_home_title');
		}
		
		if (isset($this->request->post['blogsetting_home_page_title'])) {
			$data['blogsetting_home_page_title'] = $this->request->post['blogsetting_home_page_title'];
		} else {
			$data['blogsetting_home_page_title'] = $this->config->get('blogsetting_home_page_title');
		}
		
		if (isset($this->request->post['blogsetting_home_description'])) {
			$data['blogsetting_home_description'] = $this->request->post['blogsetting_home_description'];
		} else {
			$data['blogsetting_home_description'] = $this->config->get('blogsetting_home_description');
		}
		
		if (isset($this->request->post['blogsetting_home_meta_description'])) {
			$data['blogsetting_home_meta_description'] = $this->request->post['blogsetting_home_meta_description'];
		} else {
			$data['blogsetting_home_meta_description'] = $this->config->get('blogsetting_home_meta_description');
		}
		
		if (isset($this->request->post['blogsetting_home_meta_keyword'])) {
			$data['blogsetting_home_meta_keyword'] = $this->request->post['blogsetting_home_meta_keyword'];
		} else {
			$data['blogsetting_home_meta_keyword'] = $this->config->get('blogsetting_home_meta_keyword');
		}
		
		$home_url = $this->model_blog_blog_setting->getHomeKeyword();
		
		if (isset($this->request->post['blog_home_url'])) {
			$data['blog_home_url'] = $this->request->post['blog_home_url'];
		} else if (isset($home_url['keyword'])) {
			$data['blog_home_url'] = $home_url['keyword'];
		} else {
			$data['blog_home_url'] = false;
		}
		
		
		
		if (isset($this->request->post['blogsetting_home_title'])) {
			$data['blogsetting_home_title'] = $this->request->post['blogsetting_home_title'];
		} else {
			$data['blogsetting_home_title'] = $this->config->get('blogsetting_home_title');
		}
		
		if (isset($this->request->post['blogsetting_home_page_title'])) {
			$data['blogsetting_home_page_title'] = $this->request->post['blogsetting_home_page_title'];
		} else {
			$data['blogsetting_home_page_title'] = $this->config->get('blogsetting_home_page_title');
		}
		
		if (isset($this->request->post['blogsetting_home_description'])) {
			$data['blogsetting_home_description'] = $this->request->post['blogsetting_home_description'];
		} else {
			$data['blogsetting_home_description'] = $this->config->get('blogsetting_home_description');
		}
		
		if (isset($this->request->post['blogsetting_home_meta_description'])) {
			$data['blogsetting_home_meta_description'] = $this->request->post['blogsetting_home_meta_description'];
		} else {
			$data['blogsetting_home_meta_description'] = $this->config->get('blogsetting_home_meta_description');
		}
		
		if (isset($this->request->post['blogsetting_home_meta_keyword'])) {
			$data['blogsetting_home_meta_keyword'] = $this->request->post['blogsetting_home_meta_keyword'];
		} else {
			$data['blogsetting_home_meta_keyword'] = $this->config->get('blogsetting_home_meta_keyword');
		}
		
		if (isset($this->request->post['blogsetting_home_url'])) {
			$data['blogsetting_home_url'] = $this->request->post['blogsetting_home_url'];
		} else {
			$data['blogsetting_home_url'] = $this->config->get('blogsetting_home_url');
		}
		
		if (isset($this->request->post['blogsetting_home_url'])) {
			$data['blogsetting_home_url'] = $this->request->post['blogsetting_home_url'];
		} else {
			$data['blogsetting_home_url'] = $this->config->get('blogsetting_home_url');
		}
		
		if (isset($this->request->post['blogsetting_blogs_per_page'])) {
			$data['blogsetting_blogs_per_page'] = $this->request->post['blogsetting_blogs_per_page'];
		} else {
			$data['blogsetting_blogs_per_page'] = $this->config->get('blogsetting_blogs_per_page');
		}
		
		if (isset($this->request->post['blogsetting_layout'])) {
			$data['blogsetting_layout'] = $this->request->post['blogsetting_layout'];
		} else {
			$data['blogsetting_layout'] = $this->config->get('blogsetting_layout');
		}
		
		if (isset($this->request->post['blogsetting_thumbs_w'])) {
			$data['blogsetting_thumbs_w'] = $this->request->post['blogsetting_thumbs_w'];
		} else {
			$data['blogsetting_thumbs_w'] = $this->config->get('blogsetting_thumbs_w');
		}
		
		if (isset($this->request->post['blogsetting_thumbs_h'])) {
			$data['blogsetting_thumbs_h'] = $this->request->post['blogsetting_thumbs_h'];
		} else {
			$data['blogsetting_thumbs_h'] = $this->config->get('blogsetting_thumbs_h');
		}
		
		if (isset($this->request->post['blogsetting_post_thumbs_w'])) {
			$data['blogsetting_post_thumbs_w'] = $this->request->post['blogsetting_post_thumbs_w'];
		} else {
			$data['blogsetting_post_thumbs_w'] = $this->config->get('blogsetting_post_thumbs_w');
		}
		
		if (isset($this->request->post['blogsetting_post_thumbs_h'])) {
			$data['blogsetting_post_thumbs_h'] = $this->request->post['blogsetting_post_thumbs_h'];
		} else {
			$data['blogsetting_post_thumbs_h'] = $this->config->get('blogsetting_post_thumbs_h');
		}
		
		if (isset($this->request->post['blogsetting_date_added'])) {
			$data['blogsetting_date_added'] = $this->request->post['blogsetting_date_added'];
		} else {
			$data['blogsetting_date_added'] = $this->config->get('blogsetting_date_added');
		}
		
		if (isset($this->request->post['blogsetting_comments_count'])) {
			$data['blogsetting_comments_count'] = $this->request->post['blogsetting_comments_count'];
		} else {
			$data['blogsetting_comments_count'] = $this->config->get('blogsetting_comments_count');
		}
		
		if (isset($this->request->post['blogsetting_page_view'])) {
			$data['blogsetting_page_view'] = $this->request->post['blogsetting_page_view'];
		} else {
			$data['blogsetting_page_view'] = $this->config->get('blogsetting_page_view');
		}
		
		if (isset($this->request->post['blogsetting_page_view'])) {
			$data['blogsetting_page_view'] = $this->request->post['blogsetting_page_view'];
		} else {
			$data['blogsetting_page_view'] = $this->config->get('blogsetting_page_view');
		}
		
		if (isset($this->request->post['blogsetting_author'])) {
			$data['blogsetting_author'] = $this->request->post['blogsetting_author'];
		} else {
			$data['blogsetting_author'] = $this->config->get('blogsetting_author');
		}
		
		if (isset($this->request->post['blogsetting_share'])) {
			$data['blogsetting_share'] = $this->request->post['blogsetting_share'];
		} else {
			$data['blogsetting_share'] = $this->config->get('blogsetting_share');
		}
		
		if (isset($this->request->post['blogsetting_post_thumb'])) {
			$data['blogsetting_post_thumb'] = $this->request->post['blogsetting_post_thumb'];
		} else {
			$data['blogsetting_post_thumb'] = $this->config->get('blogsetting_post_thumb');
		}
		
		if (isset($this->request->post['blogsetting_rel_characters'])) {
			$data['blogsetting_rel_characters'] = $this->request->post['blogsetting_rel_characters'];
		} else {
			$data['blogsetting_rel_characters'] = $this->config->get('blogsetting_rel_characters');
		}
		
		if (isset($this->request->post['blogsetting_rel_blog_per_row'])) {
			$data['blogsetting_rel_blog_per_row'] = $this->request->post['blogsetting_rel_blog_per_row'];
		} else {
			$data['blogsetting_rel_blog_per_row'] = $this->config->get('blogsetting_rel_blog_per_row');
		}
		
		if (isset($this->request->post['blogsetting_rel_thumb'])) {
			$data['blogsetting_rel_thumb'] = $this->request->post['blogsetting_rel_thumb'];
		} else {
			$data['blogsetting_rel_thumb'] = $this->config->get('blogsetting_rel_thumb');
		}
		
		if (isset($this->request->post['blogsetting_rel_thumbs_w'])) {
			$data['blogsetting_rel_thumbs_w'] = $this->request->post['blogsetting_rel_thumbs_w'];
		} else {
			$data['blogsetting_rel_thumbs_w'] = $this->config->get('blogsetting_rel_thumbs_w');
		}
		
		if (isset($this->request->post['blogsetting_rel_thumbs_h'])) {
			$data['blogsetting_rel_thumbs_h'] = $this->request->post['blogsetting_rel_thumbs_h'];
		} else {
			$data['blogsetting_rel_thumbs_h'] = $this->config->get('blogsetting_rel_thumbs_h');
		}
		
		if (isset($this->request->post['blogsetting_post_date_added'])) {
			$data['blogsetting_post_date_added'] = $this->request->post['blogsetting_post_date_added'];
		} else {
			$data['blogsetting_post_date_added'] = $this->config->get('blogsetting_post_date_added');
		}
		
		if (isset($this->request->post['blogsetting_post_comments_count'])) {
			$data['blogsetting_post_comments_count'] = $this->request->post['blogsetting_post_comments_count'];
		} else {
			$data['blogsetting_post_comments_count'] = $this->config->get('blogsetting_post_comments_count');
		}
		
		if (isset($this->request->post['blogsetting_post_page_view'])) {
			$data['blogsetting_post_page_view'] = $this->request->post['blogsetting_post_page_view'];
		} else {
			$data['blogsetting_post_page_view'] = $this->config->get('blogsetting_post_page_view');
		}
		
		if (isset($this->request->post['blogsetting_post_author'])) {
			$data['blogsetting_post_author'] = $this->request->post['blogsetting_post_author'];
		} else {
			$data['blogsetting_post_author'] = $this->config->get('blogsetting_post_author');
		}
		
		if (isset($this->request->post['blogsetting_comment_per_page'])) {
			$data['blogsetting_comment_per_page'] = $this->request->post['blogsetting_comment_per_page'];
		} else {
			$data['blogsetting_comment_per_page'] = $this->config->get('blogsetting_comment_per_page');
		}
		
		if (isset($this->request->post['blogsetting_comment_approve'])) {
			$data['blogsetting_comment_approve'] = $this->request->post['blogsetting_comment_approve'];
		} else {
			$data['blogsetting_comment_approve'] = $this->config->get('blogsetting_comment_approve');
		}
		
		if (isset($this->request->post['blogsetting_comment_notification'])) {
			$data['blogsetting_comment_notification'] = $this->request->post['blogsetting_comment_notification'];
		} else {
			$data['blogsetting_comment_notification'] = $this->config->get('blogsetting_comment_notification');
		}
		
		if (isset($this->request->post['blogsetting_author_change'])) {
			$data['blogsetting_author_change'] = $this->request->post['blogsetting_author_change'];
		} else {
			$data['blogsetting_author_change'] = $this->config->get('blogsetting_author_change');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('blog/blog_setting', $data)); 
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'blog/blog_setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

}