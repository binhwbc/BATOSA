<?php
class ControllerExtensionModuleAutoDetect extends Controller {
	private $moduleName;
	private $moduleNameSmall;
    private $modulePath;
    private $callModel; 
    private $moduleModel;

	public function __construct($registry) {
        parent::__construct($registry);

        $this->config->load('isenselabs/autodetect');

        /* OC version-specific declarations - Begin */
        $this->moduleName           = $this->config->get('autodetect_name');
        $this->moduleNameSmall      = $this->config->get('autodetect_name_small');
        $this->modulePath           = $this->config->get('autodetect_path');
        /* OC version-specific declarations - End */

        /* Module-specific declarations - Begin */
        $this->load->language($this->modulePath);
        $this->load->model($this->modulePath);
        $this->callModel            = $this->config->get('autodetect_model_call');
        $this->moduleModel          = $this->{$this->callModel};
        /* Module-specific declarations - End */
    }

	public function detect() {		
		$res =  $this->moduleModel->detect();
		$ad_config = $this->config->get('AutoDetect');
		if(!empty($ad_config["SearchEngines"]) && $ad_config["SearchEngines"]=="no") {
			if($this->isBot()) exit;
		}

		$data['reload'] = false;
		$data['syncmethod'] = $res['syncmethod'];

		if($res['languageto']){
			if(!isset($_COOKIE['languageChanged']) || $_COOKIE['languageChanged'] != $res['languageto']) {
				if( $this->session->data['language'] != $res['languageto']){
						 $this->session->data['language'] = $res['languageto'];
						 setcookie("languageChanged", $res['languageto'], time() + (86400 * 30)); // 30 days
						 $data['reload'] = true;
				} else {
					setcookie("languageChanged", $res['languageto'], time() + (86400 * 30)); // 30 days
				}
			}
		}
		
		if($res['currencyto']){

			if(!isset($_COOKIE['currencyChanged']) || $_COOKIE['currencyChanged'] != $res['currencyto']) {
				if( $this->session->data['currency'] != $res['currencyto']){
					 $this->session->data['currency'] = $res['currencyto'];
					  setcookie("currencyChanged", $res['currencyto'], time() + (86400 * 30)); // 30 days
					  $data['reload'] = true;
				} else {
					 setcookie("currencyChanged", $res['currencyto'], time() + (86400 * 30)); // 30 days
				}
			}

			
		}

		if($res['redirectto']){
			$data['redirectto'] = $res['redirectto'];
			$data['manual_redirect'] = $res['manual_redirect'];
			$data['stripe_text'] = $res['stripe_text'];
			$data['button_text'] = $res['button_text'];
		}

		header('content-type: text/json');
		echo json_encode($data);exit;

	}	

	public function test() {

		if (!isset($_SERVER['REMOTE_ADDR'])) {
			if (!isset($_GET['ip'])) {
				echo 'No way to detect the IP address. Your client does not identify itself and you have not set a custom IP parameter.';
				exit;							
			}
		}


		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $valid_ip = preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $_SERVER['HTTP_X_FORWARDED_FOR']);
                if($valid_ip) {
                	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];	
                }                
        } else if(!empty($_SERVER['REMOTE_ADDR'])) {
        		$valid_ip = preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $_SERVER['REMOTE_ADDR']);
        		if($valid_ip) {
        			$ip = $_SERVER['REMOTE_ADDR'];
        		}	
        } else {
        	$ip = "";
        }   


		if (!empty($_GET['ip'])) {
			$ip = $_GET['ip'];
		}
		
		$result =  $this->moduleModel->getCountryByIp($ip);	
		echo '<p>IP address: '.$ip.'</p>';
		echo '<p>Country: <b>'.strtoupper($result[0]['country']).'</b></p>';
	}

	public function isBot(){
		if (!isset($_SERVER['HTTP_USER_AGENT'])) {
			return false;	
		}
		$bots = array(
			'Googlebot', 'Baiduspider', 'ia_archiver',
			'R6_FeedFetcher', 'NetcraftSurveyAgent', 'Sogou web spider',
			'bingbot', 'Yahoo! Slurp', 'facebookexternalhit', 'PrintfulBot',
			'msnbot', 'Twitterbot', 'UnwindFetchor',
			'urlresolver', 'Butterfly', 'TweetmemeBot' );
	 	
		foreach($bots as $b){
	 
			if( stripos( $_SERVER['HTTP_USER_AGENT'], $b ) !== false ) return true;
	 
		}
		return false;
	 
	}

}

?>