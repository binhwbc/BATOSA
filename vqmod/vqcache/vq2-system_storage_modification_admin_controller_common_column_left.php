<?php
class ControllerCommonColumnLeft extends Controller {

	            public function get_custom_menu_links() {
						$menu_title = $this->config->get('addlinksmenurename');
						$children = array();

						$sess_token = $_REQUEST['token']; 

						if (empty($menu_title)) $menu_title = 'Links';

							$query2 = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "imiw_categories' ");
							$imiw_categories_exist = count($query2->rows);

							if ($imiw_categories_exist==0) {
								$this->db->query(" CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "imiw_categories (id int(11) AUTO_INCREMENT, category_title varchar(255), sort_order int(11), PRIMARY KEY (id) ) ");	
							}

							$query1 = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "imiw_links' ");
							$imiw_links_exist = count($query1->rows);

							if ($imiw_links_exist==0) {
								$this->db->query(" CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "imiw_links (id int(11) AUTO_INCREMENT, link_title varchar(255), link_href varchar(255), new_window int(3), category_id int(11), sort_order int(11), PRIMARY KEY (id) ) ");	
							}

							$result3 = $this->db->query("SELECT * FROM " . DB_PREFIX . "imiw_categories order by sort_order asc");
				
							if (!empty($result3)) {
								$categories = $result3->rows;
										
								if (count($categories)>0) {
									foreach ($categories as $one_category) {

										$cat_link = array();
										$result5 = $this->db->query("SELECT * FROM " . DB_PREFIX . "imiw_links where category_id=".$one_category['id']." order by sort_order asc");

										$category_links = $result5->rows;

										if (!empty($category_links)) {
															foreach ($category_links as $category_link) {

											$temp_href = $category_link['link_href'];
											$custom_linkz_pos = strpos($temp_href, 'token=');

											if ($custom_linkz_pos === false) {	
												$final_href = $temp_href;
											} else {
												$final_href = trim($temp_href).'&token='.$sess_token;
											}

											if ($category_link['new_window']==1) {
												$cat_link[] = array(
																		'name'	   => $category_link['link_title'],
																		'href'     => $final_href.'" target="_blank',
																		'children' => array()		
												);
											} else {
												$cat_link[] = array(
													'name'	   => $category_link['link_title'],
													'href'     => $final_href,
													'children' => array()		
												);
											}
																	
										}															
									}
													
									$children[] = array(
										'name'	   => $one_category['category_title'],
										'href'     => '',
										'children' => $cat_link
									);
								}
							}
						}

						$result6 = $this->db->query("SELECT * FROM " . DB_PREFIX . "imiw_links where category_id<1 order by sort_order asc");
						$single_links = $result6->rows;


									if (!empty($single_links)) {
										foreach ($single_links as $one_link) {

											$temp_href = $one_link['link_href'];
											$custom_linkz_pos = strpos($temp_href, 'token=');

											if ($custom_linkz_pos === false) {	
												$final_href = $temp_href;
											} else {
												$final_href = trim($temp_href).'&token='.$sess_token;
											}

											if ($one_link['new_window']==1) {
												$children[] = array(
													'name'	   => $one_link['link_title'],
													'href'     => $final_href.'" target="_blank',
													'children' => array()		
												);
											} else {
												$children[] = array(
													'name'	   => $one_link['link_title'],
													'href'     => $final_href,
													'children' => array()		
												);
											}
										}
									}

									$menu = array(
										'id'       => 'menu-links',
										'icon'	   => 'fa-link',
										'name'	   => $menu_title,
										'href'     => '',
										'children' => $children
									);

									return $menu;									
								}
	            
	public function index() {
		if (isset($this->request->get['token']) && isset($this->session->data['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$this->load->language('common/column_left');

			$this->load->model('user/user');

			$this->load->model('tool/image');

			$user_info = $this->model_user_user->getUser($this->user->getId());

			if ($user_info) {
				$data['firstname'] = $user_info['firstname'];
				$data['lastname'] = $user_info['lastname'];

				$data['user_group'] = $user_info['user_group'];

				if (is_file(DIR_IMAGE . $user_info['image'])) {
					$data['image'] = $this->model_tool_image->resize($user_info['image'], 45, 45);
				} else {
					$data['image'] = '';
				}
			} else {
				$data['firstname'] = '';
				$data['lastname'] = '';
				$data['user_group'] = '';
				$data['image'] = '';
			}

			// Create a 3 level menu array
			// Level 2 can not have children

			// Menu
			$data['menus'][] = array(
				'id'       => 'menu-dashboard',
				'icon'	   => 'fa-dashboard',
				'name'	   => $this->language->get('text_dashboard'),
				'href'     => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
				'children' => array()
			);

			// Catalog

	            $result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension` WHERE `code` = 'addLinksToAdminMenu'");
					if($result->num_rows) {
						$custom_menu_links = $this->get_custom_menu_links();
						if (!empty($custom_menu_links)) {
							$data['menus'][] = $custom_menu_links;
						}																			
					}
	            
			$catalog = array();

			if ($this->user->hasPermission('access', 'catalog/category')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_category'),
					'href'     => $this->url->link('catalog/category', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/product')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_product'),
					'href'     => $this->url->link('catalog/product', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/recurring')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_recurring'),
					'href'     => $this->url->link('catalog/recurring', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/filter')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_filter'),
					'href'     => $this->url->link('catalog/filter', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			// Attributes
			$attribute = array();

			if ($this->user->hasPermission('access', 'catalog/attribute')) {
				$attribute[] = array(
					'name'     => $this->language->get('text_attribute'),
					'href'     => $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/attribute_group')) {
				$attribute[] = array(
					'name'	   => $this->language->get('text_attribute_group'),
					'href'     => $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($attribute) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_attribute'),
					'href'     => '',
					'children' => $attribute
				);
			}

			if ($this->user->hasPermission('access', 'catalog/option')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_option'),
					'href'     => $this->url->link('catalog/option', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/manufacturer')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_manufacturer'),
					'href'     => $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/download')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_download'),
					'href'     => $this->url->link('catalog/download', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/review')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_review'),
					'href'     => $this->url->link('catalog/review', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/information')) {
				$catalog[] = array(
					'name'	   => $this->language->get('text_information'),
					'href'     => $this->url->link('catalog/information', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}


			if ($this->config->get('pim_status')) {		
				$catalog[] = array(
					'name'	   => $this->language->get('text_pim'),
					'href'     => $this->url->link('common/filemanager/pim', 'token=' . $this->session->data['token'], true, 'SSL'),
					'children' => array()		
				);					
			}			
    
      
			if ($catalog) {
				$data['menus'][] = array(
					'id'       => 'menu-catalog',
					'icon'	   => 'fa-tags',
					'name'	   => $this->language->get('text_catalog'),
					'href'     => '',
					'children' => $catalog
				);
			}


			//SEO

			$seo = array();

			if ($this->user->hasPermission('access', 'catalog/seopack')) {
				$seo[] = array(
					'name'     => 'SEO Pack',
					'href'     => $this->url->link('catalog/seopack', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'catalog/seoimages')) {
				$seo[] = array(
					'name'	   => 'SEO Images',
					'href'     => $this->url->link('catalog/seoimages', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/autolinks')) {
				$seo[] = array(
					'name'	   => 'Auto Links',
					'href'     => $this->url->link('catalog/autolinks', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/canonicals')) {
				$seo[] = array(
					'name'	   => 'Canonical Links',
					'href'     => $this->url->link('catalog/canonicals', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/mlseo')) {
				$seo[] = array(
					'name'	   => 'Multi-Language SEO',
					'href'     => $this->url->link('catalog/mlseo', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/richsnippets')) {
				$seo[] = array(
					'name'	   => 'Rich Snippets',
					'href'     => $this->url->link('catalog/richsnippets', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/seopagination')) {
				$seo[] = array(
					'name'	   => 'SEO Pagination',
					'href'     => $this->url->link('catalog/seopagination', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/redirect')) {
				$seo[] = array(
					'name'	   => 'SEO Redirector',
					'href'     => $this->url->link('catalog/redirect', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/not_found_report')) {
				$seo[] = array(
					'name'	   => '404s (Not found) Report',
					'href'     => $this->url->link('catalog/not_found_report', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/seoreplacer')) {
				$seo[] = array(
					'name'	   => 'SEO Replacer Tool',
					'href'     => $this->url->link('catalog/seoreplacer', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/extendedseo')) {
				$seo[] = array(
					'name'	   => 'Extended SEO',
					'href'     => $this->url->link('catalog/extendedseo', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/seoeditor')) {
				$seo[] = array(
					'name'	   => 'Advanced SEO Editor',
					'href'     => $this->url->link('catalog/seoeditor', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/seoreport')) {
				$seo[] = array(
					'name'	   => 'SEO Report',
					'href'     => $this->url->link('catalog/seoreport', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			if ($this->user->hasPermission('access', 'catalog/l')) {
				$seo[] = array(
					'name'	   => 'About & License',
					'href'     => $this->url->link('catalog/l', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}
			


			

			if ($seo) {
				$catalog[] = array(
					'name'	   => 'SEO',
					'href'     => '',
					'children' => $seo
				);
			}

			
			//Blog

			$blog = array();
			if ($this->user->hasPermission('access', 'blog/blog_setting')) {
				$blog[] = array(
					'name'	   => $this->language->get('text_blog_setting'),
					'href'     => $this->url->link('blog/blog_setting', 'token=' . $this->session->data['token'], true),
					'children' => array()
			);}
			if ($this->user->hasPermission('access', 'blog/blog_category')) {
				$blog[] = array(
					'name'	   => $this->language->get('text_blog_category'),
					'href'     => $this->url->link('blog/blog_category', 'token=' . $this->session->data['token'], true),
					'children' => array()
			);}
			if ($this->user->hasPermission('access', 'blog/blog')) {
				$blog[] = array(
					'name'	   => $this->language->get('text_blog_post'),
					'href'     => $this->url->link('blog/blog', 'token=' . $this->session->data['token'], true),
					'children' => array()
			);}
			if ($this->user->hasPermission('access', 'blog/blog_comment')) {
				$blog[] = array(
					'name'	   => $this->language->get('text_blog_comment'),
					'href'     => $this->url->link('blog/blog_comment', 'token=' . $this->session->data['token'], true),
					'children' => array()
			);}
			if ($blog) {
				$data['menus'][] = array(
					'id'       => 'menu-blogleft',
					'icon'	   => 'fa-newspaper-o',
					'name'	   => $this->language->get('text_blog'),
					'href'     => '',
					'children' => $blog
			);}


			// Extension
			$extension = array();

			if ($this->user->hasPermission('access', 'extension/store')) {
				$extension[] = array(
					'name'	   => $this->language->get('text_store'),
					'href'     => $this->url->link('extension/store', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'extension/installer')) {
				$extension[] = array(
					'name'	   => $this->language->get('text_installer'),
					'href'     => $this->url->link('extension/installer', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'extension/extension')) {
				$extension[] = array(
					'name'	   => $this->language->get('text_extension'),
					'href'     => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'extension/modification')) {
				$extension[] = array(
					'name'	   => $this->language->get('text_modification'),
					'href'     => $this->url->link('extension/modification', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'extension/event')) {
				$extension[] = array(
					'name'	   => $this->language->get('text_event'),
					'href'     => $this->url->link('extension/event', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($extension) {
				$data['menus'][] = array(
					'id'       => 'menu-extension',
					'icon'	   => 'fa-puzzle-piece',
					'name'	   => $this->language->get('text_extension'),
					'href'     => '',
					'children' => $extension
				);
			}

			// Design
			$design = array();

			if ($this->user->hasPermission('access', 'design/layout')) {
				$design[] = array(
					'name'	   => $this->language->get('text_layout'),
					'href'     => $this->url->link('design/layout', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'design/menu')) {
				$design[] = array(
					'name'	   => $this->language->get('text_menu'),
					'href'     => $this->url->link('design/menu', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'design/theme')) {
				$design[] = array(
					'name'	   => $this->language->get('text_theme'),
					'href'     => $this->url->link('design/theme', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'design/language')) {
				$design[] = array(
					'name'	   => $this->language->get('text_translation'),
					'href'     => $this->url->link('design/language', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'design/banner')) {
				$design[] = array(
					'name'	   => $this->language->get('text_banner'),
					'href'     => $this->url->link('design/banner', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($design) {
				$data['menus'][] = array(
					'id'       => 'menu-design',
					'icon'	   => 'fa-television',
					'name'	   => $this->language->get('text_design'),
					'href'     => '',
					'children' => $design
				);
			}

			// Sales
			$sale = array();

			if ($this->user->hasPermission('access', 'sale/order')) {
				$sale[] = array(
					'name'	   => $this->language->get('text_order'),
					'href'     => $this->url->link('sale/order', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'sale/recurring')) {
				$sale[] = array(
					'name'	   => $this->language->get('text_recurring'),
					'href'     => $this->url->link('sale/recurring', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'sale/return')) {
				$sale[] = array(
					'name'	   => $this->language->get('text_return'),
					'href'     => $this->url->link('sale/return', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			// Voucher
			$voucher = array();

			if ($this->user->hasPermission('access', 'sale/voucher')) {
				$voucher[] = array(
					'name'	   => $this->language->get('text_voucher'),
					'href'     => $this->url->link('sale/voucher', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'sale/voucher_theme')) {
				$voucher[] = array(
					'name'	   => $this->language->get('text_voucher_theme'),
					'href'     => $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($voucher) {
				$sale[] = array(
					'name'	   => $this->language->get('text_voucher'),
					'href'     => '',
					'children' => $voucher
				);
			}

			if ($sale) {
				$data['menus'][] = array(
					'id'       => 'menu-sale',
					'icon'	   => 'fa-shopping-cart',
					'name'	   => $this->language->get('text_sale'),
					'href'     => '',
					'children' => $sale
				);
			}

			// Customer
			$customer = array();

			if ($this->user->hasPermission('access', 'customer/customer')) {
				$customer[] = array(
					'name'	   => $this->language->get('text_customer'),
					'href'     => $this->url->link('customer/customer', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'customer/customer_group')) {
				$customer[] = array(
					'name'	   => $this->language->get('text_customer_group'),
					'href'     => $this->url->link('customer/customer_group', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'customer/custom_field')) {
				$customer[] = array(
					'name'	   => $this->language->get('text_custom_field'),
					'href'     => $this->url->link('customer/custom_field', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($customer) {
				$data['menus'][] = array(
					'id'       => 'menu-customer',
					'icon'	   => 'fa-user',
					'name'	   => $this->language->get('text_customer'),
					'href'     => '',
					'children' => $customer
				);
			}

			// Marketing
			$marketing = array();

			if ($this->user->hasPermission('access', 'marketing/marketing')) {
				$marketing[] = array(
					'name'	   => $this->language->get('text_marketing'),
					'href'     => $this->url->link('marketing/marketing', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'marketing/affiliate')) {
				$marketing[] = array(
					'name'	   => $this->language->get('text_affiliate'),
					'href'     => $this->url->link('marketing/affiliate', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'marketing/coupon')) {
				$marketing[] = array(
					'name'	   => $this->language->get('text_coupon'),
					'href'     => $this->url->link('marketing/coupon', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'marketing/contact')) {
				$marketing[] = array(
					'name'	   => $this->language->get('text_contact'),
					'href'     => $this->url->link('marketing/contact', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($marketing) {
				$data['menus'][] = array(
					'id'       => 'menu-marketing',
					'icon'	   => 'fa-share-alt',
					'name'	   => $this->language->get('text_marketing'),
					'href'     => '',
					'children' => $marketing
				);
			}

			// System
			$system = array();

			if ($this->user->hasPermission('access', 'setting/setting')) {
				$system[] = array(
					'name'	   => $this->language->get('text_setting'),
					'href'     => $this->url->link('setting/store', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			// Users
			$user = array();

			if ($this->user->hasPermission('access', 'user/user')) {
				$user[] = array(
					'name'	   => $this->language->get('text_users'),
					'href'     => $this->url->link('user/user', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'user/user_permission')) {
				$user[] = array(
					'name'	   => $this->language->get('text_user_group'),
					'href'     => $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'user/api')) {
				$user[] = array(
					'name'	   => $this->language->get('text_api'),
					'href'     => $this->url->link('user/api', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($user) {
				$system[] = array(
					'name'	   => $this->language->get('text_users'),
					'href'     => '',
					'children' => $user
				);
			}

			// Localisation
			$localisation = array();

			if ($this->user->hasPermission('access', 'localisation/location')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_location'),
					'href'     => $this->url->link('localisation/location', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/language')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_language'),
					'href'     => $this->url->link('localisation/language', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/currency')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_currency'),
					'href'     => $this->url->link('localisation/currency', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/stock_status')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_stock_status'),
					'href'     => $this->url->link('localisation/stock_status', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/order_status')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_order_status'),
					'href'     => $this->url->link('localisation/order_status', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			// Returns
			$return = array();

			if ($this->user->hasPermission('access', 'localisation/return_status')) {
				$return[] = array(
					'name'	   => $this->language->get('text_return_status'),
					'href'     => $this->url->link('localisation/return_status', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/return_action')) {
				$return[] = array(
					'name'	   => $this->language->get('text_return_action'),
					'href'     => $this->url->link('localisation/return_action', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/return_reason')) {
				$return[] = array(
					'name'	   => $this->language->get('text_return_reason'),
					'href'     => $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($return) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_return'),
					'href'     => '',
					'children' => $return
				);
			}

			if ($this->user->hasPermission('access', 'localisation/country')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_country'),
					'href'     => $this->url->link('localisation/country', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/zone')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_zone'),
					'href'     => $this->url->link('localisation/zone', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/geo_zone')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_geo_zone'),
					'href'     => $this->url->link('localisation/geo_zone', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			// Tax
			$tax = array();

			if ($this->user->hasPermission('access', 'localisation/tax_class')) {
				$tax[] = array(
					'name'	   => $this->language->get('text_tax_class'),
					'href'     => $this->url->link('localisation/tax_class', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/tax_rate')) {
				$tax[] = array(
					'name'	   => $this->language->get('text_tax_rate'),
					'href'     => $this->url->link('localisation/tax_rate', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($tax) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_tax'),
					'href'     => '',
					'children' => $tax
				);
			}

			if ($this->user->hasPermission('access', 'localisation/length_class')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_length_class'),
					'href'     => $this->url->link('localisation/length_class', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/weight_class')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_weight_class'),
					'href'     => $this->url->link('localisation/weight_class', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($localisation) {
				$system[] = array(
					'name'	   => $this->language->get('text_localisation'),
					'href'     => '',
					'children' => $localisation
				);
			}

			// Tools
			$tool = array();

			if ($this->user->hasPermission('access', 'tool/upload')) {
				$tool[] = array(
					'name'	   => $this->language->get('text_upload'),
					'href'     => $this->url->link('tool/upload', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'tool/backup')) {
				$tool[] = array(
					'name'	   => $this->language->get('text_backup'),
					'href'     => $this->url->link('tool/backup', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'tool/log')) {
				$tool[] = array(
					'name'	   => $this->language->get('text_log'),
					'href'     => $this->url->link('tool/log', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($tool) {
				$system[] = array(
					'name'	   => $this->language->get('text_tools'),
					'href'     => '',
					'children' => $tool
				);
			}

			if ($system) {
				$data['menus'][] = array(
					'id'       => 'menu-system',
					'icon'	   => 'fa-cog',
					'name'	   => $this->language->get('text_system'),
					'href'     => '',
					'children' => $system
				);
			}

			// Report
			$report = array();

			// Report Sales
			$report_sale = array();

			if ($this->user->hasPermission('access', 'report/sale_order')) {
				$report_sale[] = array(
					'name'	   => $this->language->get('text_report_sale_order'),
					'href'     => $this->url->link('report/sale_order', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/sale_tax')) {
				$report_sale[] = array(
					'name'	   => $this->language->get('text_report_sale_tax'),
					'href'     => $this->url->link('report/sale_tax', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/sale_shipping')) {
				$report_sale[] = array(
					'name'	   => $this->language->get('text_report_sale_shipping'),
					'href'     => $this->url->link('report/sale_shipping', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/sale_return')) {
				$report_sale[] = array(
					'name'	   => $this->language->get('text_report_sale_return'),
					'href'     => $this->url->link('report/sale_return', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/sale_coupon')) {
				$report_sale[] = array(
					'name'	   => $this->language->get('text_report_sale_coupon'),
					'href'     => $this->url->link('report/sale_coupon', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($report_sale) {
				$report[] = array(
					'name'	   => $this->language->get('text_report_sale'),
					'href'     => '',
					'children' => $report_sale
				);
			}

			// Report Products
			$report_product = array();

			if ($this->user->hasPermission('access', 'report/product_viewed')) {
				$report_product[] = array(
					'name'	   => $this->language->get('text_report_product_viewed'),
					'href'     => $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/product_purchased')) {
				$report_product[] = array(
					'name'	   => $this->language->get('text_report_product_purchased'),
					'href'     => $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($report_product) {
				$report[] = array(
					'name'	   => $this->language->get('text_report_product'),
					'href'     => '',
					'children' => $report_product
				);
			}

			// Report Customers
			$report_customer = array();

			if ($this->user->hasPermission('access', 'report/customer_online')) {
				$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_online'),
					'href'     => $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/customer_activity')) {
				$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_activity'),
					'href'     => $this->url->link('report/customer_activity', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/customer_search')) {
				$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_search'),
					'href'     => $this->url->link('report/customer_search', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/customer_order')) {
				$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_order'),
					'href'     => $this->url->link('report/customer_order', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/customer_reward')) {
				$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_reward'),
					'href'     => $this->url->link('report/customer_reward', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/customer_credit')) {
				$report_customer[] = array(
					'name'	   => $this->language->get('text_report_customer_credit'),
					'href'     => $this->url->link('report/customer_credit', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($report_customer) {
				$report[] = array(
					'name'	   => $this->language->get('text_report_customer'),
					'href'     => '',
					'children' => $report_customer
				);
			}

			// Report Marketing
			$report_marketing = array();

			if ($this->user->hasPermission('access', 'report/marketing')) {
				$report_marketing[] = array(
					'name'	   => $this->language->get('text_report_marketing'),
					'href'     => $this->url->link('report/marketing', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/affiliate')) {
				$report_marketing[] = array(
					'name'	   => $this->language->get('text_report_affiliate'),
					'href'     => $this->url->link('report/affiliate', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'report/affiliate_activity')) {
				$report_marketing[] = array(
					'name'	   => $this->language->get('text_report_affiliate_activity'),
					'href'     => $this->url->link('report/affiliate_activity', 'token=' . $this->session->data['token'], true),
					'children' => array()
				);
			}

			if ($report_marketing) {
				$report[] = array(
					'name'	   => $this->language->get('text_report_marketing'),
					'href'     => '',
					'children' => $report_marketing
				);
			}

			if ($report) {
				$data['menus'][] = array(
					'id'       => 'menu-report',
					'icon'	   => 'fa-bar-chart-o',
					'name'	   => $this->language->get('text_reports'),
					'href'     => '',
					'children' => $report
				);
			}

			// Stats
			$data['text_complete_status'] = $this->language->get('text_complete_status');
			$data['text_processing_status'] = $this->language->get('text_processing_status');
			$data['text_other_status'] = $this->language->get('text_other_status');

			$this->load->model('sale/order');

			$order_total = $this->model_sale_order->getTotalOrders();

			$complete_total = $this->model_sale_order->getTotalOrders(array('filter_order_status' => implode(',', $this->config->get('config_complete_status'))));

			if ($complete_total) {
				$data['complete_status'] = round(($complete_total / $order_total) * 100);
			} else {
				$data['complete_status'] = 0;
			}

			$processing_total = $this->model_sale_order->getTotalOrders(array('filter_order_status' => implode(',', $this->config->get('config_processing_status'))));

			if ($processing_total) {
				$data['processing_status'] = round(($processing_total / $order_total) * 100);
			} else {
				$data['processing_status'] = 0;
			}

			$this->load->model('localisation/order_status');

			$order_status_data = array();

			$results = $this->model_localisation_order_status->getOrderStatuses();

			foreach ($results as $result) {
				if (!in_array($result['order_status_id'], array_merge($this->config->get('config_complete_status'), $this->config->get('config_processing_status')))) {
					$order_status_data[] = $result['order_status_id'];
				}
			}

			$other_total = $this->model_sale_order->getTotalOrders(array('filter_order_status' => implode(',', $order_status_data)));

			if ($other_total) {
				$data['other_status'] = round(($other_total / $order_total) * 100);
			} else {
				$data['other_status'] = 0;
			}

			return $this->load->view('common/column_left', $data);
		}
	}
}
