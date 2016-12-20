<?php 
class ControllerBlogBlog extends Controller {
	
	private $error = array();
	
	public function index() { 
	
		$this->document->addStyle('catalog/view/theme/shopme/stylesheet/blog.css');
	 
		$this->language->load('blog/blog');
		
		$this->load->model('blog/blog');

		$this->load->model('tool/image');
		
		$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home')
      	);

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_blog'),
			'href'      => $this->url->link('blog/home')
      	);
				
		$this->load->model('blog/blog_category');

		if (isset($this->request->get['blogpath'])) {
			$path = '';

			$parts = explode('_', (string)$this->request->get['blogpath']);

			$blog_category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

				$category_info = $this->model_blog_blog_category->getBlogCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('blog/category', 'blogpath=' . $path)
					);
				}
			}

			// Set the last category breadcrumb
			$category_info = $this->model_blog_blog_category->getBlogCategory($blog_category_id);

			if ($category_info) {
				$url = '';

				$data['breadcrumbs'][] = array(
					'text' => $category_info['name'],
					'href' => $this->url->link('blog/category', 'blogpath=' . $this->request->get['blogpath'] . $url)
				);
			}
		}		
		
		if (isset($this->request->get['blog_id'])) {
			$blog_id = $this->request->get['blog_id'];
		} else {
			$blog_id = 0;
		}

		$blog_info = $this->model_blog_blog->getBlog($blog_id);
   		
		if ($blog_info) {
			$url = '';
			
			if (isset($this->request->get['blogpath'])) {
				$url .= '&blogpath=' . $this->request->get['blogpath'];
			}
			
			$data['breadcrumbs'][] = array(
			'text'      => $blog_info['title'],
			'href' => $this->url->link('blog/blog', $url . '&blog_id=' . $this->request->get['blog_id'])
			);
			
			$data['new_read_counter_value'] = $blog_info['count_read']+1;
			$this->model_blog_blog->updateBlogReadCounter($this->request->get['blog_id'], $data['new_read_counter_value']);
			$data['comment_total'] = $this->model_blog_blog->getTotalCommentsByBlogId($this->request->get['blog_id']);

			if (isset($this->request->get['blog_id'])) {
				
			$data['post_date_added_status'] = $this->config->get('blogsetting_post_date_added');
			$data['post_comments_count_status'] = $this->config->get('blogsetting_post_comments_count');
			$data['post_page_view_status'] = $this->config->get('blogsetting_post_page_view');
			$data['post_author_status'] = $this->config->get('blogsetting_post_author');
			$data['share_status'] = $this->config->get('blogsetting_share');
			$data['main_thumb'] = $this->config->get('blogsetting_post_thumb');
			
			// Related posts
			$data['date_added_status'] = $this->config->get('blogsetting_date_added');
			$data['comments_count_status'] = $this->config->get('blogsetting_comments_count');
			$data['page_view_status'] = $this->config->get('blogsetting_page_view');
			$data['author_status'] = $this->config->get('blogsetting_author');
			$data['rel_thumb_status'] = $this->config->get('blogsetting_rel_thumb');
			$data['rel_per_row'] = $this->config->get('blogsetting_rel_blog_per_row');
			
			
			$data['related_blogs'] = array();
			
			$related_blogs = $this->model_blog_blog->getRelatedBlog($this->request->get['blog_id']);
		
			foreach ($related_blogs as $result) {
      			$data['related_blogs'][] = array(
        		'title' => $result['title'],
				'count_read' => $result['count_read'],
				'short_description' => utf8_substr(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('blogsetting_rel_characters')) . '..',
				'author' => $result['author'],
				'comment_total' => $this->model_blog_blog->getTotalCommentsByBlogId($result['blog_id']),
        		'date_added_full' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_added' => $result['date_added'],
        		'image' => $this->model_tool_image->resize($result['image'], $this->config->get('blogsetting_rel_thumbs_w'), $this->config->get('blogsetting_rel_thumbs_h')),
	    		'href'  => $this->url->link('blog/blog', 'blog_id=' . $result['blog_id'])
      			);
    		  }
    		}
			
		
			if ($blog_info['page_title']) {
			$this->document->setTitle($blog_info['page_title']);
			} else {
			$this->document->setTitle($blog_info['title']);
			}
			
			$this->document->setDescription($blog_info['meta_description']);
			$this->document->setKeywords($blog_info['meta_keyword']);
			
			$this->document->addLink($this->url->link('blog/blog', 'blog_id=' . $this->request->get['blog_id']), 'canonical');
										
      		$data['heading_title'] = $blog_info['title'];
			
			$data['description'] = html_entity_decode($blog_info['description'], ENT_QUOTES, 'UTF-8');
      		
			$data['blogsetting_post_thumb'] = $this->model_tool_image->resize($blog_info['image'], $this->config->get('blogsetting_post_thumbs_w'), $this->config->get('blogsetting_post_thumbs_h'));
			
			$data['tags'] = array();

			if ($blog_info['tags']) {
				$tags = explode(',', $blog_info['tags']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('blog/home', 'tag=' . trim($tag))
					);
				}
			}
			
			$data['text_tags'] = $this->language->get('text_tags');
			$data['text_posted_on'] = $this->language->get('text_posted_on');
			$data['text_posted_by'] = $this->language->get('text_posted_by');
			$data['text_read'] = $this->language->get('text_read');
			$data['text_share_this'] = $this->language->get('text_share_this');

      		$data['text_related_blog'] = $this->language->get('text_related_blog');
      		$data['text_read_more'] = $this->language->get('text_read_more');
      		
      		$data['text_write_comment'] = $this->language->get('text_write_comment');

      		$data['entry_name'] = $this->language->get('entry_name');
      		$data['entry_email'] = $this->language->get('entry_email');
			$data['entry_comment'] = $this->language->get('entry_comment');
      		$data['text_comments'] = $this->language->get('text_comments');
			$data['text_write_comment'] = $this->language->get('text_write_comment');
			
      		$data['entry_captcha'] = $this->language->get('entry_captcha');
      		$data['button_send'] = $this->language->get('button_send');
			
			$data['post_date_added_status'] = $this->config->get('blogsetting_post_date_added');
			$data['post_comments_count_status'] = $this->config->get('blogsetting_post_comments_count');
			$data['post_page_view_status'] = $this->config->get('blogsetting_post_page_view');
			$data['post_author_status'] = $this->config->get('blogsetting_post_author');			
			
			$data['date_added_full'] = date($this->language->get('date_format_short'), strtotime($blog_info['date_added']));
			$data['date_added'] = $blog_info['date_added'];
			
			$data['author'] = $blog_info['author'];
			
			$data['allow_comment'] = $blog_info['allow_comment'];
			
			$data['continue'] = $this->url->link('common/home');
			
			$data['blog_id'] = (int)$this->request->get['blog_id'];
			

	  		$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			$this->response->setOutput($this->load->view('blog/blog', $data));
			
    	} else {
			
			$url = '';
			
      		$data['breadcrumbs'] [] = array(
        		'href'      => $this->url->link('blog/blog', $url . '&blog_id=' . $this->request->get['blog_id']),
        		'text'      => $this->language->get('text_error')
      		);
				
	  		$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
    	}
	}
	
		
		public function comment() {
			
		$this->load->language('blog/blog');

		$this->load->model('blog/blog');
		
		$data['text_comments'] = $this->language->get('text_comments');

		$data['text_no_comment'] = $this->language->get('text_no_comment');

		if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}

		$data['comments'] = array();

		$comment_total = $this->model_blog_blog->getTotalCommentsByBlogId($this->request->get['blog_id']);
		
		$limit = $this->config->get('blogsetting_comment_per_page');

		$results = $this->model_blog_blog->getCommentsByBlogId($this->request->get['blog_id'], ($page - 1) * $limit, $limit);

		foreach ($results as $result) {
        		$data['comments'][] = array(
        			'name'     => $result['name'],
					'email'     => $result['email'],
					'comment'       => strip_tags($result['comment']),
        			'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        		);
      		}	

        
        $pagination = new Pagination();
			$pagination->total = $comment_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('blogsetting_comment_per_page'); 
			$pagination->url = $this->url->link('blog/blog/comment', 'blog_id=' . $this->request->get['blog_id'] . '&page={page}');
			
			$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($comment_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($comment_total - $limit)) ? $comment_total : ((($page - 1) * $limit) + $limit), $comment_total, ceil($comment_total / $limit));
			
			
		$this->response->setOutput($this->load->view('blog/comment', $data));
		
}
	
	
	
		
		public function write() {
		$this->load->language('blog/blog');
		
		$data['entry_comment'] = $this->language->get('entry_comment');
		
		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			
			if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 100)) {
				$json['error'] = $this->language->get('error_name');
			}
			
			if ((utf8_strlen($this->request->post['email']) < 1) || (utf8_strlen($this->request->post['email']) > 100)) {
				$json['error'] = $this->language->get('error_email');
			}

			if ((utf8_strlen($this->request->post['comment']) < 5) || (utf8_strlen($this->request->post['comment']) > 3000)) {
				$json['error'] = $this->language->get('error_comment');
			}

			
			if (empty($this->session->data['captcha_comment']) || ($this->session->data['captcha_comment'] != $this->request->post['captcha_comment'])) {
				$json['error'] = $this->language->get('error_captcha');
			}

			unset($this->session->data['captcha_comment']);
			

			if (!isset($json['error'])) {
				$this->load->model('blog/blog');

				$this->model_blog_blog->addComment($this->request->get['blog_id'], $this->request->post);
				
				if($this->config->get('blogsetting_comment_approve')){
				$json['success'] = $this->language->get('text_success_approve');
				}else{
				$json['success'] = $this->language->get('text_success');
				}
				
				if($this->config->get('blogsetting_comment_notification')){
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_host');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
				
				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->request->post['name']);
				$mail->setSubject(sprintf($this->language->get('email_notification'), $this->request->post['name']));
				$mail->setText(strip_tags($this->request->post['comment']));
				$mail->send();
				}
				
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	
	public function captcha() {
		$num1=rand(2,6); //Generate First number between 1 and 9  
		$num2=rand(2,6); //Generate Second number between 1 and 9  
		$this->session->data['captcha_comment'] = $num1+$num2;
		$image = imagecreatetruecolor(58, 22);
		$width = imagesx($image);
		$height = imagesy($image);
		$black = imagecolorallocate($image, 50, 50, 50);
		$white = imagecolorallocate($image, 255, 255, 255);
		imagefilledrectangle($image, 0, 0, $width, $height, $white);
		imagestring($image, 4, 0, 3, "$num1"." + "."$num2"." =", $black);
		header('Content-type: image/png');
		imagepng($image);
		imagedestroy($image);
	}
	
	
}
