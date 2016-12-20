<?php
class ControllerCommonHome extends Controller {
	public function index() {
			
			$this->session->data['proute'] = 'common/home';
			$titles = $this->config->get('config_meta_title');
			$meta_descriptions = $this->config->get('config_meta_description');
			$meta_keywords = $this->config->get('config_meta_keyword');
			
		$this->document->setTitle($titles[$this->config->get('config_language_id')]);

				$canonicals = $this->config->get('canonicals');
				if (isset($canonicals['canonicals_home'])) {
					$this->document->addLink($this->config->get('config_url'), 'canonical');
					}
		$this->document->setDescription($meta_descriptions[$this->config->get('config_language_id')]);
		$this->document->setKeywords($meta_keywords[$this->config->get('config_language_id')]);

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}
