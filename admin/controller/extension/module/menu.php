<?php
class ControllerExtensionModuleMenu extends Controller {

	private $error = array();
	
	public function index() {
	
		$this->load->language('extension/module/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('extension/module');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('menu', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_menu'] = $this->language->get('entry_menu');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_size'] = $this->language->get('entry_size');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['entry_name_lang'] = $this->language->get('entry_name_lang');
		
		if (isset($this->error['warning'])) { $data['error_warning'] = $this->error['warning']; } else { $data['error_warning'] = ''; }
		if (isset($this->error['name'])) { $data['error_name'] = $this->error['name']; } else { $data['error_name'] = ''; }
		if (isset($this->error['width'])) { $data['error_width'] = $this->error['width']; } else { $data['error_width'] = ''; }
		if (isset($this->error['height'])) { $data['error_height'] = $this->error['height']; } else { $data['error_height'] = ''; }
		if (isset($this->error['size'])) { $data['error_size'] = $this->error['size']; } else { $data['error_size'] = ''; }
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL')
		);
		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/menu', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/menu', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/menu', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('extension/module/menu', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL');
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
                $this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		if (isset($this->request->post['name'])) { $data['name'] = $this->request->post['name']; } elseif (!empty($module_info)) { $data['name'] = $module_info['name']; } else { $data['name'] = ''; }
		if (isset($this->request->post['menu_id'])) { $data['menu_id'] = $this->request->post['menu_id']; } elseif (!empty($module_info)) { $data['menu_id'] = $module_info['menu_id']; } else { $data['menu_id'] = ''; }
		if (isset($this->request->post['width'])) { $data['width'] = $this->request->post['width']; } elseif (!empty($module_info)) { $data['width'] = $module_info['width']; } else { $data['width'] = ''; }
		if (isset($this->request->post['height'])) { $data['height'] = $this->request->post['height']; } elseif (!empty($module_info)) { $data['height'] = $module_info['height']; } else { $data['height'] = ''; }
		if (isset($this->request->post['size'])) { $data['size'] = $this->request->post['size']; } elseif (!empty($module_info)) { $data['size'] = $module_info['size']; } else { $data['size'] = ''; }
		if (isset($this->request->post['status'])) { $data['status'] = $this->request->post['status']; } elseif (!empty($module_info)) { $data['status'] = $module_info['status']; } else { $data['status'] = ''; }
                if (isset($this->request->post['name'])) 
                    { $data['name_lang'] = $this->request->post['name_lang']; }
                elseif (!empty($module_info))
                    { $data['name_lang'] = $module_info['name_lang']; }
                else 
                    { $data['name_lang'] = array(); }
		
                
		$this->load->model('design/menu');
		$data['menus'] = $this->model_design_menu->getMenus();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('extension/module/menu', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/menu')) { $this->error['warning'] = $this->language->get('error_permission'); }
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) { $this->error['name'] = $this->language->get('error_name'); }
		if ((utf8_strlen($this->request->post['width']) < 1) || (utf8_strlen($this->request->post['width']) > 64)) { $this->error['width'] = $this->language->get('error_width'); }
		if ((utf8_strlen($this->request->post['height']) < 1) || (utf8_strlen($this->request->post['height']) > 64)) { $this->error['height'] = $this->language->get('error_height'); }
		if ((utf8_strlen($this->request->post['size']) < 1) || (utf8_strlen($this->request->post['size']) > 64)) { $this->error['size'] = $this->language->get('error_size'); }
		return !$this->error;
	}

}