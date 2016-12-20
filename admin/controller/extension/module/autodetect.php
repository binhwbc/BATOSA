<?php

class ControllerExtensionModuleAutoDetect extends Controller {

	private $moduleName;
	private $moduleNameSmall;
    private $modulePath;
    private $extensionsLink;
    private $callModel;
	private $moduleModel;
    private $moduleVersion;

    public function __construct($registry) {
        parent::__construct($registry);

        $this->config->load('isenselabs/autodetect');

        /* OC version-specific declarations - Begin */
        $this->moduleName           = $this->config->get('autodetect_name');
        $this->moduleNameSmall      = $this->config->get('autodetect_name_small');
        $this->extensionsLink       = $this->url->link($this->config->get('autodetect_extensions_link'), 'token=' . $this->session->data['token'] . $this->config->get('autodetect_extensions_link_params'), 'SSL');
        $this->modulePath           = $this->config->get('autodetect_path');
        /* OC version-specific declarations - End */

        /* Module-specific declarations - Begin */
        $this->load->language($this->modulePath);
        $this->load->model($this->modulePath);
        $this->callModel            = $this->config->get('autodetect_model_call');
        $this->moduleModel          = $this->{$this->callModel};
        $this->moduleVersion        = $this->config->get('autodetect_version');
        /* Module-specific declarations - End */

        /* Module-specific loaders - Begin */
        $this->load->model('setting/store');
        $this->load->model('setting/setting');
        $this->load->model('localisation/language');
        $this->load->model('localisation/currency');
        $this->load->model('localisation/country');
        $this->load->model('design/layout');
        /* Module-specific loaders - End */
    }

    public function index() {	     
        // Variables
        $data['moduleName']   = $this->moduleName;
        $data['moduleNameSmall'] = $this->moduleNameSmall;
        $data['modulePath']   = $this->modulePath;

        $catalogURL = $this->getCatalogURL(); 

        $this->document->addStyle('view/stylesheet/'.$this->moduleNameSmall.'/'.$this->moduleNameSmall.'.css');
		$this->document->addScript('view/javascript/'.$this->moduleNameSmall.'/nprogress.js');

        $this->document->setTitle($this->language->get('heading_title'));

        if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }	

        $store = $this->getCurrentStore($this->request->get['store_id']);		

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) { 
            if (!$this->user->hasPermission('modify', $this->modulePath)) {
                $this->redirect($this->extensionsLink);
            }

            if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
                $this->request->post[$this->moduleName]['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
            }

            if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
                $this->request->post[$this->moduleName]['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']), true);
            }

			if(!isset($this->request->post[$this->moduleData_module])) {
				$this->request->post[$this->moduleData_module] = array();
			}

            if(!empty($this->request->post[$this->moduleName]['RedirectTo'])) {
               foreach($this->request->post[$this->moduleName]['RedirectTo'] as $redirect_rule) {
                    if(!empty($redirect_rule["link"])) {
                        $redirect_rule["link"] = urldecode($redirect_rule["link"]);
                    }
               }
            }

            $this->model_setting_setting->editSetting($this->moduleName, $this->request->post, $this->request->post['store_id']);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link($this->modulePath, 'store_id='.$this->request->post['store_id'] . '&token=' . $this->session->data['token'], 'SSL'));
        }		

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}	

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

        if (isset($this->error['code'])) {
            $data['error_code'] = $this->error['code'];
        } else {
            $data['error_code'] = '';
        }

        $data['breadcrumbs']   = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->extensionsLink,
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link($this->modulePath, 'token=' . $this->session->data['token'], 'SSL'),
        );

        $languageVariables = array(
		    // Main
			'heading_title',
			'error_permission',
			'text_success',
			'text_enabled',
			'text_disabled',
			'button_cancel',
			'save_changes',
			'text_default',
			'text_module',
            'text_controlpanel',
            'text_language',
            'text_currency',
            'text_customredirect',
            'text_support',
            'text_choose_countries',
            'text_module_status',
            'text_module_status_help',
            'text_detect_method',
            'text_synchronous',
            'text_asynchronous',
            'text_synchronous_desc',
            'text_asynchronous_desc',
            'text_add_country',
            'text_redirectto',
            'text_coming_from',
            'text_use_manual_redirect',
            'text_stripe_text',
            'text_button_text',
            'text_puturl_placeholder',
            'text_putustripe_text_placeholder',
            'text_putustripe_button_placeholder',
            'text_create_redirect',
            'text_select_all',
            'text_deselect_all'
        );       

        foreach ($languageVariables as $languageVariable) {
            $data[$languageVariable] = $this->language->get($languageVariable);
        }

        $data['heading_title'] .= " " . $this->moduleVersion;

		$data['currency']				= $this->config->get('config_currency'); 
        $data['stores']				  	= array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' (' . $data['text_default'].')', 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
        $data['error_warning']          = '';  
        $data['languages']              = $this->model_localisation_language->getLanguages();

        foreach ($data['languages'] as $key => $value) {
            if(version_compare(VERSION, '2.2.0.0', "<")) {
                $data['languages'][$key]['flag_url'] = 'view/image/flags/'.$data['languages'][$key]['image'];

            } else {
                $data['languages'][$key]['flag_url'] = 'language/'.$data['languages'][$key]['code'].'/'.$data['languages'][$key]['code'].'.png"';
            }
        }
        
        $data['currencies']             = $this->model_localisation_currency->getCurrencies();
		$data['countries']              = $this->model_localisation_country->getCountries();
        $data['store']                  = $store;
        $data['token']                  = $this->session->data['token'];
        $data['action']                 = $this->url->link($this->modulePath, 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel']                 = $this->extensionsLink;
        $data['data']                   = $this->model_setting_setting->getSetting($this->moduleName, $store['store_id']);
        $data['layouts']                = $this->model_design_layout->getLayouts();
        $data['catalog_url']			= $catalogURL;		

		if (isset($data['data'][$this->moduleName])) {
			$data['moduleData'] = $data['data'][$this->moduleName];
		} else {
			$data['moduleData'] = array();	
		}

		$ds = DIRECTORY_SEPARATOR;
        $update_check_file = dirname(DIR_APPLICATION) . $ds . "vendors" . $ds . "autodetect" . $ds . "update_check";
        $ip2nation_file = dirname(DIR_APPLICATION) . $ds . "vendors" . $ds . "autodetect" . $ds . "ip2nation.sql";
        $data["display_update_button"] = (file_exists($update_check_file) && file_exists($ip2nation_file)) ? filemtime($ip2nation_file) > filemtime($update_check_file) : (file_exists($ip2nation_file) ? true : false);
        $data["update_url"] = $this->url->link($this->modulePath . "/install", "token=" . $this->session->data["token"], "SSL");		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view($this->modulePath . '.tpl', $data));
    }

    public function import() {
        if (
            !isset($this->request->get['filename']) ||
            !isset($this->request->get['start_pos'])) {
                echo json_encode(array('pointer_pos' => 0, 'done' => true));exit;
        }

        $filename = urldecode($this->request->get['filename']);
        $start_pos = (int)$this->request->get['start_pos'];
        $json = array(
            'done' => false,
            'pointer_pos' => $start_pos,
            'filesize' => 0
        );

        $result = $this->populateTableEntries($filename, $start_pos, 2);
        if ($result === true) {
            $json['done'] = true;
        } else if ($result === false) {
            $json['error'] = 'Unable to open module files. Please make sure you have uploaded all the files.';
        } else {
            $json['pointer_pos'] = $result;
            $json['filesize'] = filesize($filename);
        }

        header('Content-Type: application/json');
        echo json_encode($json);exit;
    }
	
    public function install() {
        $data['modulePath']   = $this->modulePath;
        
		if(!$this->table_exists('ip2nation')) {
			// The IP database is missing and we need to create it.
			$this->db->query("
			CREATE TABLE ".DB_PREFIX."ip2nation (
			  ip int(11) unsigned NOT NULL default '0',
			  country char(2) NOT NULL default '',
			  KEY ip (ip)
			);");
        } else {
            $this->db->query("TRUNCATE TABLE ".DB_PREFIX."ip2nation");
        }

        $this->document->addStyle('view/stylesheet/'.$this->moduleNameSmall.'/'.$this->moduleNameSmall.'.css');
        $this->document->addScript('view/javascript/'.$this->moduleNameSmall.'/nprogress.js');

        $ds = DIRECTORY_SEPARATOR;
        $data['filename'] = dirname(DIR_APPLICATION) . $ds . "vendors" . $ds . "autodetect" . $ds . "ip2nation.sql";
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        echo $this->load->view($this->modulePath . '/install.tpl', $data);
        exit;
    }

    private function table_exists($table) {
		$dbtable = $this->db->query("SHOW TABLES LIKE \"%".$table."%\"");
        return !empty($dbtable->row);
    }

    private function populateTableEntries($file, $start = 0, $timeout = 5) {
        if (!file_exists($file)) return false;

        $ds = DIRECTORY_SEPARATOR;
        $update_check_file = dirname(DIR_APPLICATION) . $ds . "vendors" . $ds . "autodetect" . $ds . "update_check";
        if (!is_dir(dirname($update_check_file))) {
            if (@mkdir(dirname($update_check_file, 0755, true))) {
                touch($update_check_file);
            }
        } else {
            touch($update_check_file);
        }

        $handle = fopen($file, "r");

        if ($handle) {
            fseek($handle, $start);
            $startTime = microtime(true);

            while (($line = fgets($handle)) !== false) {
                $this->db->query(str_replace('ip2nation',DB_PREFIX.'ip2nation',$line));
                if ((microtime(true) - $startTime) >= $timeout) {
                    break;
                }
            }

            if (feof($handle)) {
                $res = true;
            } else {
                $res = ftell($handle);
            }
            fclose($handle);
            return $res;
        } else {
            fclose($handle);
            return false;
        } 

        return true;
    }	

    private function getCatalogURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_CATALOG;
        } else {
            $storeURL = HTTP_CATALOG;
        } 
        return $storeURL;
    }

    private function getServerURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_SERVER;
        } else {
            $storeURL = HTTP_SERVER;
        } 
        return $storeURL;
    }

    private function getCurrentStore($store_id) {    
        if($store_id && $store_id != 0) {
            $store = $this->model_setting_store->getStore($store_id);
        } else {
            $store['store_id'] = 0;
            $store['name'] = $this->config->get('config_name');
            $store['url'] = $this->getCatalogURL(); 
        }
        return $store;
    }
}

?>