<?php
class ControllerCommonHeader extends Controller {
	public function index() {
         
            $ad_config = $this->config->get('AutoDetect');

            $this->config->load('isenselabs/autodetect');
            $ad_modulePath = $this->config->get('autodetect_path');
            $ad_callModel = $this->config->get('autodetect_model_call');
            $ad_moduleModel = $this->{$this->callModel};

            if(!empty($ad_config['DetectMethod']) && $ad_config['DetectMethod'] == 'sync') {                
                
                if (empty($_SESSION['detectedlanguage']) || empty($_SESSION['detectedredirectto']) || empty($_SESSION['detectedcurrency'])) {
                    
                    $detect_res = $ad_moduleModel->detect();

                    $redirectToBePerformed = (!empty($detect_res['redirectto'])  && empty($_SESSION['detectedredirectto']));
                    
                    if(isset($detect_res['manual_redirect']) && !isset($_COOKIE['redirectto'])){
                        $data['text_stripe'] =  $detect_res['stripe_text'];
                        $data['button_stripe'] = $detect_res['button_text'];
                        $data['href_stripe'] = $detect_res['redirectto'];

                    } else {

                      if ($redirectToBePerformed) {
                          $request_uri = $_SERVER['REQUEST_URI'];

                          $detect_res['redirectto'] = str_replace('{REQUEST_URI}',ltrim($request_uri,"/"),$detect_res['redirectto']);
                          $detect_res['redirectto'] = str_replace('&amp;','&',$detect_res['redirectto']);

                          $_SESSION['detectedredirectto'] = $detect_res['redirectto'];

                          header('Location: '.$detect_res['redirectto']);
                      }
                    }
  
                }

            }
        
		// Analytics
		$this->load->model('extension/extension');

		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();


				$data['alternate'] = '';
				$mlseo = $this->config->get('mlseo');
				if (isset($mlseo['hreflang'])) {	
					$this->load->model('localisation/language');
					$languages = $this->model_localisation_language->getLanguages();
					
					if (isset($this->request->get['route'])) {
						if ($this->request->get['route'] == 'product/product') {
							foreach($languages as $xlanguage) {
																
								
								$squery = $this->db->query("SELECT `value` FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_language'");
								if (isset($xlanguage['code']) && ($xlanguage['code'] != $squery->row['value'])) {$url = $xlanguage['code'].'/';}
									else {$url = '';} 
									
								$query = $this->db->query("select * from " . DB_PREFIX . "url_alias where CONCAT('product_id=', CAST(".$this->request->get['product_id']." as CHAR)) = query and language_id = ".  $xlanguage['language_id']);
								if ($query->num_rows) {
									$url .= $query->row['keyword'];
								}
								
								$data['alternate'] .='<link rel="alternate" hreflang="'.$xlanguage['code'].'" href="'.HTTP_SERVER.$url.'" />';
								 
								
							}
						}
						
						if ($this->request->get['route'] == 'product/category') {
							$xcats = explode('_', $this->request->get['path']); $xcat = end($xcats);
							foreach($languages as $xlanguage) {
															
								
								$squery = $this->db->query("SELECT `value` FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_language'");
								if (isset($xlanguage['code']) && ($xlanguage['code'] != $squery->row['value'])) {$url = $xlanguage['code'].'/';}
									else {$url = '';} 
									
								$query = $this->db->query("select * from " . DB_PREFIX . "url_alias where CONCAT('category_id=', CAST(".$xcat." as CHAR)) = query and language_id = ".  $xlanguage['language_id']);
								if ($query->num_rows) {
									$url .= $query->row['keyword'];
								}
								
								$data['alternate'] .='<link rel="alternate" hreflang="'.$xlanguage['code'].'" href="'.HTTP_SERVER.$url.'" />';
								 
								
							}
						}
						
						if ($this->request->get['route'] == 'product/manufacturer/info') {
							foreach($languages as $xlanguage) {
																
								
								$squery = $this->db->query("SELECT `value` FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_language'");
								if (isset($xlanguage['code']) && ($xlanguage['code'] != $squery->row['value'])) {$url = $xlanguage['code'].'/';}
									else {$url = '';} 
									
								$query = $this->db->query("select * from " . DB_PREFIX . "url_alias where CONCAT('manufacturer_id=', CAST(".$this->request->get['manufacturer_id']." as CHAR)) = query and language_id = ".  $xlanguage['language_id']);
								if ($query->num_rows) {
									$url .= $query->row['keyword'];
								}
								
								$data['alternate'] .='<link rel="alternate" hreflang="'.$xlanguage['code'].'" href="'.HTTP_SERVER.$url.'" />';
								 
								
							}
						}
						
						if ($this->request->get['route'] == 'information/information') {
							foreach($languages as $xlanguage) {
															
								
								$squery = $this->db->query("SELECT `value` FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_language'");
								if (isset($xlanguage['code']) && ($xlanguage['code'] != $squery->row['value'])) {$url = $xlanguage['code'].'/';}
									else {$url = '';} 
									
								$query = $this->db->query("select * from " . DB_PREFIX . "url_alias where CONCAT('information_id=', CAST(".$this->request->get['information_id']." as CHAR)) = query and language_id = ".  $xlanguage['language_id']);
								if ($query->num_rows) {
									$url .= $query->row['keyword'];
								}
								
								$data['alternate'] .='<link rel="alternate" hreflang="'.$xlanguage['code'].'" href="'.HTTP_SERVER.$url.'" />';
								 
								
							}
						}
						
						
					
					}
				}
				
				
		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();

				
				foreach ($data['links'] as $link) { 
					if ($link['rel']=='canonical') {$hasCanonical = true;} 
					} 
				$data['canonical_link'] = '';
				$canonicals = $this->config->get('canonicals'); 
				if (!isset($hasCanonical) && isset($this->request->get['route']) && (isset($canonicals['canonicals_extended']))) {
					$data['canonical_link'] = $this->url->link($this->request->get['route']);					
					}
				
				
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} elseif (isset($this->request->get['information_id'])) {
				$class = '-' . $this->request->get['information_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		return $this->load->view('common/header', $data);
	}
}
