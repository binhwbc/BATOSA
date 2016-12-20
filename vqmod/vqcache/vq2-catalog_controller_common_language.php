<?php
class ControllerCommonLanguage extends Controller {
	public function index() {
		$this->load->language('common/language');

		$data['text_language'] = $this->language->get('text_language');

		$data['action'] = $this->url->link('common/language/language', '', $this->request->server['HTTPS']);

		$data['code'] = $this->session->data['language'];

		$this->load->model('localisation/language');

		$data['languages'] = array();

		$results = $this->model_localisation_language->getLanguages();

		foreach ($results as $result) {
			if ($result['status']) {
				$data['languages'][] = array(
					'name' => $result['name'],
					'code' => $result['code']
				);
			}
		}

		if (!isset($this->request->get['route'])) {
			$data['redirect'] = $this->url->link('common/home');
		} else {
			$url_data = $this->request->get;

			$route = $url_data['route'];

			unset($url_data['route']);

			$url = '';

			if ($url_data) {
				$url = '&' . urldecode(http_build_query($url_data, '', '&'));
			}

			$data['redirect'] = $this->url->link($route, $url, $this->request->server['HTTPS']);
		}

		return $this->load->view('common/language', $data);
	}

	public function language() {
		if (isset($this->request->post['code'])) {
			$this->session->data['language'] = $this->request->post['code'];
		}

		if (isset($this->request->post['redirect'])) {
						
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
			foreach ($query->rows as $language)
				{	
					$this->request->post['redirect'] = str_replace('/'.$language['code'].'/', '/'.$this->request->post['code'].'/', $this->request->post['redirect']);
				}
			$query = $this->db->query("SELECT language_id FROM " . DB_PREFIX . "language WHERE code = '" . $this->request->post['code'] . "'");
			$this->config->set('config_language_id', $query->row['language_id']);
						
			if ((isset($this->session->data['proute']))&&($this->session->data['proute'] == 'product/product')) {$this->response->redirect($this->url->link('product/product', 'product_id=' . $this->session->data['product_id']));}
			elseif ((isset($this->session->data['proute']))&&($this->session->data['proute'] == 'product/category')) {$this->response->redirect($this->url->link('product/category', 'path=' . $this->session->data['path']));}
			elseif ((isset($this->session->data['proute']))&&($this->session->data['proute'] == 'product/manufacturer/info')) {$this->response->redirect($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->session->data['manufacturer_id']));}
			elseif ((isset($this->session->data['proute']))&&($this->session->data['proute'] == 'information/information')) {$this->response->redirect($this->url->link('information/information', 'information_id=' . $this->session->data['information_id']));}
			elseif (isset($this->session->data['proute'])) {$this->response->redirect($this->url->link($this->session->data['proute']));}
			else {$this->response->redirect($this->request->post['redirect']);}						
			
		} else {
			$this->response->redirect($this->url->link('common/home'));
		}
	}
}