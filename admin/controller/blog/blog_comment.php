<?php 
class ControllerBlogBlogComment extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('blog/blog_comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('blog/blog_comment');
		 
		$this->getList();
	}


	public function delete() {
		$this->load->language('blog/blog_comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('blog/blog_comment');
		
		if (isset($this->request->post['selected']) && $this->validateForm()) {
			foreach ($this->request->post['selected'] as $blog_comment_id) {
				$this->model_blog_blog_comment->deleteBlogComment($blog_comment_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('blog/blog_comment', 'token=' . $this->session->data['token'], true));
		}

		$this->getList();
	}
	
	public function enable() {
		$this->load->language('blog/blog_comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('blog/blog_comment');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $blog_comment_id) {
				$this->model_blog_blog_comment->enableBlogComment($blog_comment_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('blog/blog_comment', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
	
	public function disable() {
		$this->load->language('blog/blog_comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('blog/blog_comment');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $blog_comment_id) {
				$this->model_blog_blog_comment->disableBlogComment($blog_comment_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('blog/blog_comment', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
	
	

	private function getList() {
   				
		$url = "";
		
		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('blog/blog_comment', 'token=' . $this->session->data['token'], true)
   		);
									
		
		$data['delete'] = $this->url->link('blog/blog_comment/delete', 'token=' . $this->session->data['token'], true);
		
		$data['enable'] = $this->url->link('blog/blog_comment/enable', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['disable'] = $this->url->link('blog/blog_comment/disable', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}	
		
		$data['blog_comments'] = array();
		
		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$results = $this->model_blog_blog_comment->getBlogComments($filter_data);

		foreach ($results as $result) {

			$data['blog_comments'][] = array(
				'blog_comment_id' => $result['blog_comment_id'],
				'name'        => $result['name'],
				'email'        => $result['email'],
				'comment'        => $result['comment'],
				'date_added'        => $result['date_added'],
				'status'        => $result['status'],
				'title'        => $result['title'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['blog_comment_id'], $this->request->post['selected'])
			);
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date'] = $this->language->get('column_date');
		$data['column_comment'] = $this->language->get('column_comment');
		$data['column_post'] = $this->language->get('column_post');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['text_enable'] = $this->language->get('text_enable');
		$data['text_disable'] = $this->language->get('text_disable');
		$data['text_no_result'] = $this->language->get('text_no_result');
		
		$data['button_delete'] = $this->language->get('button_delete');
		
		$data['text_confirm'] = $this->language->get('text_confirm');
 
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		$total = $this->model_blog_blog_comment->getTotalBlogComments();
		
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('blog/blog_comment', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
					
		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($total - $this->config->get('config_limit_admin'))) ? $total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $total, ceil($total / $this->config->get('config_limit_admin')));
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('blog/blog_comment_list', $data)); 
	}
	
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'blog/blog_comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
		return !$this->error;
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'blog/blog_comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		return !$this->error;
	}
	
}