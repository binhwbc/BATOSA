<?php
class ControllerDesignMenu extends Controller {

	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	private $error = array();


	public function position(){
		$this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_menu->addMenu($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
			if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
			if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
			$this->response->redirect($this->url->link('design/menu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('design/menu_position_list', $data));



	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function index() {
		$this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
		$this->getList();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function add() {
		$this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_menu->addMenu($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
			if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
			if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
			$this->response->redirect($this->url->link('design/menu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function edit() {
		$this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_menu->editMenu($this->request->get['menu_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
			if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
			if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
			$this->response->redirect($this->url->link('design/menu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function delete() {
		$this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $menu_id) {
				$this->model_design_menu->deleteMenu($menu_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
			if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
			if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
			$this->response->redirect($this->url->link('design/menu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getList();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function getList() {
		if (isset($this->request->get['sort'])) { $sort = $this->request->get['sort']; } else { $sort = 'name'; }
		if (isset($this->request->get['order'])) { $order = $this->request->get['order']; } else { $order = 'ASC'; }
		if (isset($this->request->get['page'])) { $page = $this->request->get['page']; } else { $page = 1; }
		$url = '';
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('design/menu', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['add'] = $this->url->link('design/menu/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('design/menu/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['menus'] = array();
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		$layout_total = $this->model_design_menu->getTotalMenus();
		$results = $this->model_design_menu->getMenus($filter_data);
		foreach ($results as $result) {
			if($result['type']=='horizontal'){ $types = $this->language->get('input_horizontal'); }
			if($result['type']=='vertical'){ $types = $this->language->get('input_vertical'); }
			if($result['type']=='list'){ $types = $this->language->get('input_list'); }
			if($result['type']=='mega'){ $types = $this->language->get('input_mega'); }
			$data['menus'][] = array(
				'menu_id' => $result['menu_id'],
				'name'      => $result['name'],
				'position'      => $result['position'],
				'type'      => $types,
				'edit'      => $this->url->link('design/menu/edit', 'token=' . $this->session->data['token'] . '&menu_id=' . $result['menu_id'] . $url, 'SSL'),
				'group'      => $this->url->link('design/menu/group', 'token=' . $this->session->data['token'] . '&menu_id=' . $result['menu_id'] . $url, 'SSL')
			);
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_type'] = $this->language->get('column_type');
		$data['column_action'] = $this->language->get('column_action');
		$data['button_group'] = $this->language->get('button_group');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		
		if (isset($this->error['warning'])) { $data['error_warning'] = $this->error['warning']; } else { $data['error_warning'] = ''; }
		if (isset($this->session->data['success'])) { $data['success'] = $this->session->data['success']; unset($this->session->data['success']); } else { $data['success'] = ''; }
		if (isset($this->request->post['selected'])) { $data['selected'] = (array)$this->request->post['selected']; } else { $data['selected'] = array(); }
		$url = '';
		if ($order == 'ASC') { $url .= '&order=DESC'; } else { $url .= '&order=ASC'; }
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		$data['sort_name'] = $this->url->link('design/menu', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$url = '';
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		
		$pagination = new Pagination();
		$pagination->total = $layout_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('design/menu', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($layout_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($layout_total - $this->config->get('config_limit_admin'))) ? $layout_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $layout_total, ceil($layout_total / $this->config->get('config_limit_admin')));
		
		$data['sort'] = $sort;
		$data['order'] = $order;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('design/menu_list.tpl', $data));
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_form'] = !isset($this->request->get['menu_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_picture'] = $this->language->get('entry_picture');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['input_horizontal'] = $this->language->get('input_horizontal');
		$data['input_list'] = $this->language->get('input_list');
		$data['input_vertical'] = $this->language->get('input_vertical');
		$data['input_style'] = $this->language->get('input_style');
		$data['input_style_tabbed'] = $this->language->get('input_style_tabbed');
		$data['input_style_dropdown'] = $this->language->get('input_style_dropdown');
		$data['input_style_lists'] = $this->language->get('input_style_lists');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_route_add'] = $this->language->get('button_route_add');
		$data['button_module_add'] = $this->language->get('button_module_add');
		$data['button_remove'] = $this->language->get('button_remove');
		
		if (isset($this->error['warning'])) { $data['error_warning'] = $this->error['warning']; } else { $data['error_warning'] = ''; }

		if (isset($this->error['position'])) { 
			$data['error_position'] = $this->error['position']; 
		} else { 
			$data['error_position'] = ''; 
		}

		if (isset($this->error['name'])) { $data['error_name'] = $this->error['name']; } else { $data['error_name'] = ''; }
		if (isset($this->error['code'])) { $data['error_code'] = $this->error['code']; } else { $data['error_code'] = ''; }
		$url = '';
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('design/menu', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		if (!isset($this->request->get['menu_id'])) {
			$data['action'] = $this->url->link('design/menu/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('design/menu/edit', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . $url, 'SSL');
		}
		
		$data['cancel'] = $this->url->link('design/menu', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['positions'] = $this->model_design_menu->getPositions();


		if (isset($this->request->get['menu_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$menu_info = $this->model_design_menu->getMenu($this->request->get['menu_id']);
		}
		
		if (isset($this->request->post['image'])) { $data['image'] = $this->request->post['image']; } elseif (!empty($menu_info)) { $data['image'] = $menu_info['image']; } else { $data['image'] = ''; }
		$this->load->model('tool/image');
		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($menu_info) && is_file(DIR_IMAGE . $menu_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($menu_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['name'])) { $data['name'] = $this->request->post['name']; } elseif (!empty($menu_info)) { $data['name'] = $menu_info['name']; } else { $data['name'] = ''; }
		if (isset($this->request->post['code'])) { $data['code'] = $this->request->post['code']; } elseif (!empty($menu_info)) { $data['code'] = $menu_info['code']; } else { $data['code'] = ''; }
		if (isset($this->request->post['type'])) { $data['type'] = $this->request->post['type']; } elseif (!empty($menu_info)) { $data['type'] = $menu_info['type']; } else { $data['type'] = ''; }
		if (isset($this->request->post['position'])) { $data['position'] = $this->request->post['position']; } elseif (!empty($menu_info)) { $data['position'] = $menu_info['position']; } else { $data['position'] = ''; }
		if (isset($this->request->post['picture'])) { $data['picture'] = $this->request->post['picture']; } elseif (!empty($menu_info)) { $data['picture'] = $menu_info['picture']; } else { $data['picture'] = ''; }
		if (isset($this->request->post['status'])) { $data['status'] = $this->request->post['status']; } elseif (!empty($menu_info)) { $data['status'] = $menu_info['status']; } else { $data['status'] = true; }
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('design/menu_form.tpl', $data));
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/menu')) { $this->error['warning'] = $this->language->get('error_permission'); }
		if(isset($this->request->post['code'])){
			if ((utf8_strlen($this->request->post['code']) < 1) || (utf8_strlen($this->request->post['code']) > 64)) { 
                            $this->error['code'] = $this->language->get('error_code'); }
		}
		if(isset($this->request->post['name'])){
			if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 64)) { 
                            $this->error['name'] = $this->language->get('error_name'); }
		}
		if(isset($this->request->post['menu_group_description'])){
			foreach ($this->request->post['menu_group_description'] as $language_id => $value) {
				if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) { 
                                    $this->error['name'][$language_id] = $this->language->get('error_name'); }
			}
		}
		if(isset($this->request->post['menu_group_languages'])){
			foreach ($this->request->post['menu_group_languages'] as $language_id => $value) {
				if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) { 
                                    $this->error['name'][$language_id] = $this->language->get('error_name'); }
			}
		}

		if(isset($this->request->post['position']) && $this->request->post['oldpotition']){
			$menus =  $this->db->query("SELECT DISTINCT position FROM " . DB_PREFIX . "menu WHERE position != " .$this->request->post['oldpotition']);
 
			foreach ($menus->rows as $menu) { 
			    if ($this->request->post['position'] == $menu['position']) {

			    	$this->error['position']= $this->language->get('error_position');

			    }

			}
		}

		if(isset($this->request->post['position']) && !isset($this->request->post['oldpotition'])){
			$menus =  $this->db->query("SELECT DISTINCT position FROM " . DB_PREFIX . "menu");
 
			foreach ($menus->rows as $menu) { 
			    if ($this->request->post['position'] == $menu['position']) {

			    	$this->error['position']= $this->language->get('error_position');

			    }

			}
		}



		return !$this->error;
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/menu')) { $this->error['warning'] = $this->language->get('error_permission'); }
		return !$this->error;
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function group() {
		$this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
		$this->getDesign();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupSingleAdd() {
		$this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_menu->groupSingleAdd($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->post['menu_id'])) { $url .= '&menu_id=' . $this->request->post['menu_id']; }
			$this->response->redirect($this->url->link('design/menu/group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->group();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupSingleEdit() {
		$this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_menu->groupSingleEdit($this->request->get['menu_group_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['menu_id'])) { $url .= '&menu_id=' . $this->request->get['menu_id']; }
			$this->response->redirect($this->url->link('design/menu/group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->group();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupMultipleAdd() {
		$this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_menu->groupMultipleAdd($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->post['menu_id'])) { $url .= '&menu_id=' . $this->request->post['menu_id']; }
			$this->response->redirect($this->url->link('design/menu/group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->group();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupCompose() {
		$this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_menu->groupCompose($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['menu_id'])) { $url .= '&menu_id=' . $this->request->get['menu_id']; }
			$this->response->redirect($this->url->link('design/menu/group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->groupLists();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupDelete() {
		$this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
		
		if (isset($this->request->get['menu_group_id'])) {
			$this->model_design_menu->groupDelete($this->request->get['menu_group_id']);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['menu_id'])) { $url .= '&menu_id=' . $this->request->get['menu_id']; }
			$this->response->redirect($this->url->link('design/menu/group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->group();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function getDesign() {
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_form'] = !isset($this->request->get['menu_id']) ? $this->language->get('text_add') : $this->language->get('text_design');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_links'] = $this->language->get('text_links');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_information'] = $this->language->get('text_information');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['input_collective'] = $this->language->get('input_collective');
		$data['input_type'] = $this->language->get('input_type');
		$data['input_species'] = $this->language->get('input_species');
		$data['input_module'] = $this->language->get('input_module');
		$data['input_url'] = $this->language->get('input_url');
		$data['input_keyword'] = $this->language->get('input_keyword');
		$data['input_font'] = $this->language->get('input_font');
		$data['input_image'] = $this->language->get('input_image');
		$data['input_window'] = $this->language->get('input_window');
		$data['input_fixed'] = $this->language->get('input_fixed');
		$data['input_popup'] = $this->language->get('input_popup');
		$data['input_style'] = $this->language->get('input_style');
		$data['input_style_tabbed'] = $this->language->get('input_style_tabbed');
		$data['input_style_dropdown'] = $this->language->get('input_style_dropdown');
		$data['input_style_lists'] = $this->language->get('input_style_lists');
		$data['button_finished'] = $this->language->get('button_finished');
		$data['button_expand'] = $this->language->get('button_expand');
		$data['button_collapse'] = $this->language->get('button_collapse');
		$data['button_finished'] = $this->language->get('button_finished');
		$data['button_menu_add'] = $this->language->get('button_menu_add');
		$data['button_menu'] = !isset($this->request->get['menu_group_id']) ? $this->language->get('button_menu_add') : $this->language->get('button_menu_save');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		
		if (isset($this->error['warning'])) { $data['error_warning'] = $this->error['warning']; } else { $data['error_warning'] = ''; }
		if (isset($this->session->data['success'])) { $data['success'] = $this->session->data['success']; unset($this->session->data['success']); } else { $data['success'] = ''; }
		
		if (isset($this->error['name'])) { $data['error_name'] = $this->error['name']; } else { $data['error_name'] = array(); }
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('design/menu', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['groupSingleAdd'] = $this->url->link('design/menu/groupSingleAdd', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'], 'SSL');
		$data['groupMultipleAdd'] = $this->url->link('design/menu/groupMultipleAdd', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'], 'SSL');
		$data['cancel'] = $this->url->link('design/menu', 'token=' . $this->session->data['token'], 'SSL');
		$data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['menu_id']) ) {
		
			$data['menu_info'] = $this->model_design_menu->getMenu($this->request->get['menu_id']);
			$data['group_compose'] = $this->url->link('design/menu/groupCompose', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'], 'SSL');
			$data['group_lists'] = $this->contentParentHtml($this->request->get['menu_id'], 0);
			
			if (isset($this->request->get['menu_group_id']) ) {
				$menu_group_info = $this->model_design_menu->getGroup($this->request->get['menu_group_id']);
				$data['menu_group']  = $this->model_design_menu->getGroup($this->request->get['menu_group_id']);
				
				
				if (isset($this->request->post['menu_group_languages'])) {
					$data['menu_group_languages'] = $this->request->post['menu_group_languages'];
				} elseif (isset($this->request->get['menu_group_id'])) {
					$data['menu_group_languages'] = $this->model_design_menu->getGroupDescriptions($this->request->get['menu_group_id']);
				} else {
					$data['menu_group_languages'] = array();
				}
				
				$data['groupSingleAdd'] = $this->url->link('design/menu/groupSingleEdit', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . '&menu_group_id=' . $this->request->get['menu_group_id'], 'SSL');
				$data['groupSingleCancel'] = $this->url->link('design/menu/group', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'], 'SSL');
			}else{
				$data['menu_group']  = '';
			}
			
			if (isset($this->request->post['url'])) { $data['url'] = $this->request->post['url']; } elseif (!empty($menu_group_info)) { $data['url'] = $menu_group_info['url']; } else { $data['url'] = ''; }
			if (isset($this->request->post['keyword'])) { $data['keyword'] = $this->request->post['keyword']; } elseif (!empty($menu_group_info)) { $data['keyword'] = $menu_group_info['keyword']; } else { $data['keyword'] = ''; }
			if (isset($this->request->post['font'])) { $data['font'] = $this->request->post['font']; } elseif (!empty($menu_group_info)) { $data['font'] = $menu_group_info['font']; } else { $data['font'] = ''; }
			if (isset($this->request->post['image'])) { $data['image'] = $this->request->post['image']; } elseif (!empty($menu_group_info)) { $data['image'] = $menu_group_info['image']; } else { $data['image'] = ''; }
			if (isset($this->request->post['class'])) { $data['class'] = $this->request->post['class']; } elseif (!empty($menu_group_info)) { $data['class'] = $menu_group_info['class']; } else { $data['class'] = ''; }
			if (isset($this->request->post['window'])) { $data['window'] = $this->request->post['window']; } elseif (!empty($menu_group_info)) { $data['window'] = $menu_group_info['window']; } else { $data['window'] = ''; }
			if (isset($this->request->post['style'])) { $data['style'] = $this->request->post['style']; } elseif (!empty($menu_group_info)) { $data['style'] = $menu_group_info['style']; } else { $data['style'] = ''; }
			if (isset($this->request->post['module_type'])) { $data['module_type'] = $this->request->post['module_type']; } elseif (!empty($menu_group_info)) { $data['module_type'] = $menu_group_info['module_type']; } else { $data['module_type'] = ''; }
			if (isset($this->request->post['module_id'])) { $data['module_id'] = $this->request->post['module_id']; } elseif (!empty($menu_group_info)) { $data['module_id'] = $menu_group_info['module_id']; } else { $data['module_id'] = ''; }
			
			$this->load->model('tool/image');
			
			if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
				$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
			} elseif (!empty($menu_group_info) && is_file(DIR_IMAGE . $menu_group_info['image'])) {
				$data['thumb'] = $this->model_tool_image->resize($menu_group_info['image'], 100, 100);
			} else {
				$data['thumb'] = $this->model_tool_image->resize('no_image.png', 50, 50);
			}
			$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 50, 50);
		
		}
		
		$this->document->addStyle('view/stylesheet/jquery-pg.nestable.css');
		$this->document->addStyle('view/stylesheet/jquery-pg.iconpicker.css');
		$this->document->addStyle('view/javascript/select2/css/select2.min.css');
		$this->document->addStyle('view/javascript/font-awesome/css/font-awesome.css');
		
		$this->document->addScript('view/javascript/select2/js/select2.full.min.js');
		$this->document->addScript('view/javascript/jquery-pg.nestable.js');
		$this->document->addScript('view/javascript/jquery-pg.iconpicker.js');
		
		/// Languages
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('design/menu_design.tpl', $data));
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function contentParentHtml($menu_id, $parent_id) {
		$outrun = "";
		$results = $this->model_design_menu->groupLists($menu_id, $parent_id);
		if( count($results) > 0 ){
			$outrun =array();
			$outrun ='<ol class="dd-list">';
			foreach ($results as $result) {
				$content_description= $this->contentDescriptions($result['module_type'], $result['menu_group_id']);
				$outrun .='<li class="dd-item dd3-item" data-id="'. $result['menu_group_id'] .'">';
				$outrun .='<div class="dd-handle dd3-handle"><i class="fa fa-bars"></i></div>';
				$outrun .='<div class="dd3-content">'. $content_description .'</div>';
				$outrun .='<div class="dd-edit"><a href="'. $this->url->link('design/menu/groupSingleEdit', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . '&menu_group_id=' . $result['menu_group_id'], 'SSL') .'"><i class="fa fa-pencil"></i></a></div>';
				$outrun .='<div class="dd-delete"><a href="'. $this->url->link('design/menu/groupDelete', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . '&menu_group_id=' . $result['menu_group_id'], 'SSL') .'"><i class="fa fa-trash-o"></i></a></div>';
				$outrun .= $this->contentParentHtml($menu_id, $result['menu_group_id'] );
				$outrun .='</li>';
			}
			$outrun .='</ol>';
		}
		return $outrun;
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function contentDescriptions($menu_content_type, $module_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_group_description WHERE menu_group_id = '" . (int)$module_id . "' AND language_id ='" . (int)$this->config->get('config_language_id') . "' ");
		foreach ($query->rows as $result) {
			$menu_content_description = $result['name'];
		}
		return $menu_content_description;
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function species() {
	
		if($this->request->get['module_type'] == "category"){
			$this->load->model('catalog/category');
			$results = $this->model_catalog_category->getCategories();
			$output='';
			foreach ($results as $result) {
				$output .= '<option value="' . $result['category_id'] . '"';
				if ($this->request->get['module_id'] == $result['category_id']) { $output .= ' selected="selected"'; }
				$output .= '>' . $result['name'] . '</option>';
			}
			$this->response->setOutput($output);
		}
		
		if($this->request->get['module_type'] == "product"){
			$this->load->model('catalog/product');
			$results = $this->model_catalog_product->getProducts();
			$output='';
			foreach ($results as $result) {
				$output .= '<option value="' . $result['product_id'] . '"';
				if ($this->request->get['module_id'] == $result['product_id']) { $output .= ' selected="selected"'; }
				$output .= '>' . $result['name'] . '</option>';
			}
			$this->response->setOutput($output);
		}
		
		if($this->request->get['module_type'] == "information"){
			$this->load->model('catalog/information');
			$results = $this->model_catalog_information->getInformations();
			$output='';
			foreach ($results as $result) {
				$output .= '<option value="' . $result['information_id'] . '"';
				if ($this->request->get['module_id'] == $result['information_id']) { $output .= ' selected="selected"'; }
				$output .= '>' . $result['title'] . '</option>';
			}
			$this->response->setOutput($output);
		}
		
		if($this->request->get['module_type'] == "manufacturer"){
			$this->load->model('catalog/manufacturer');
			$results = $this->model_catalog_manufacturer->getManufacturers();
			$output='';
			foreach ($results as $result) {
				$output .= '<option value="' . $result['manufacturer_id'] . '"';
				if ($this->request->get['module_id'] == $result['manufacturer_id']) { $output .= ' selected="selected"'; }
				$output .= '>' . $result['name'] . '</option>';
			}
			$this->response->setOutput($output);
		}	
		if($this->request->get['module_type'] == "blog"){
			$this->load->model('blog/blog');
			$results = $this->model_blog_blog->getBlogs();
			$output='';
			foreach ($results as $result) {
				$output .= '<option value="' . $result['blog_id'] . '"';
				if ($this->request->get['module_id'] == $result['blog_id']) { $output .= ' selected="selected"'; }
				$output .= '>' . $result['title'] . '</option>';
			}
			$this->response->setOutput($output);
		}
		if($this->request->get['module_type'] == "blog_category"){
			$this->load->model('blog/blog_category');
			$results = $this->model_blog_blog_category->getBlogCategories();
			$output='';
			foreach ($results as $result) {
				$output .= '<option value="' . $result['blog_category_id'] . '"';
				if ($this->request->get['module_id'] == $result['blog_category_id']) { $output .= ' selected="selected"'; }
				$output .= '>' . $result['name'] . '</option>';
			}
			$this->response->setOutput($output);
		}
	
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function moduleurl() {
	
		if($this->request->get['module_type'] == "category"){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$this->request->get['module_id'] . "' ");
			$this->response->setOutput('category_id=' . $query->row['category_id']);
		}
		if($this->request->get['module_type'] == "product"){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$this->request->get['module_id'] . "' ");
			$this->response->setOutput('product_id=' . $query->row['product_id']);
		}
		if($this->request->get['module_type'] == "information"){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information WHERE information_id = '" . (int)$this->request->get['module_id'] . "' ");
			$this->response->setOutput('information_id=' . $query->row['information_id']);
		}
		if($this->request->get['module_type'] == "manufacturer"){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$this->request->get['module_id'] . "' ");
			$this->response->setOutput('manufacturer_id=' . $query->row['manufacturer_id']);
		}

		if($this->request->get['module_type'] == "blog"){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog WHERE blog_id = '" . (int)$this->request->get['module_id'] . "' ");
			$this->response->setOutput('blog_id=' . $query->row['blog_id']);
		}

		if($this->request->get['module_type'] == "blog_category"){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category WHERE blog_category_id = '" . (int)$this->request->get['module_id'] . "' ");
			$this->response->setOutput('blog_category_id=' . $query->row['blog_category_id']);
		}
	
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function moduleseo() {
		// if(!empty($this->request->get['module_url'])){
		// 	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->request->get['module_url'] . "' ");
		// 	if($query->row){ $this->response->setOutput($query->row['keyword']); }
		// }
	}
	
	//////////////////// 
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function autocompleteinformation() {
		$json = array();
		if (isset($this->request->get['filter_title'])) {
			$this->load->model('catalog/information');
			$filter_data = array(
				'filter_title' => $this->request->get['filter_title'],
				'start' => 0,
				'limit' => 5
			);
			$results = $this->model_catalog_information->getInformations($filter_data);
			foreach ($results as $result) {
				$json[] = array(
					'information_id' => $result['information_id'],
					'title' => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}
		$sort_order = array();
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['title'];
		}
		array_multisort($sort_order, SORT_ASC, $json);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}