<?php

class ModelExtensionModuleAutoDetect extends Model {

	public function detect() {
		$resp = array();

		if (!isset($_SERVER['REMOTE_ADDR'])) {
			$res = array('error'=>'true');
			return $res;

		}

		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];	            
        } else if(!empty($_SERVER['REMOTE_ADDR'])) {
        			$ip = $_SERVER['REMOTE_ADDR'];	
        } else {
        			$ip = "";
        }   

        if(!preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $ip)){
        	$ip = '';
        }

		//$ip = $_SERVER['REMOTE_ADDR'];	
		$config = $this->config->get('AutoDetect');

		if (!isset($config['Enabled']) || $config['Enabled'] != 'yes') {
			return;
		}
		
		if(!empty($config["SearchEngines"]) && $config["SearchEngines"]=="no") {
			if($this->isBot()) return;
		}


		$result = $this->getCountryByIp($ip);

		$country_of_the_visitor = 'xxx';

		if (isset($result[0]['country'])) {
			$country_of_the_visitor = $result[0]['country'];

		}
	
		
		$res = array(
		'languageto'=>'',
		'currencyto'=>'',
		'redirectto'=>'',
		'syncmethod'=>''
		);

		

		if (!isset($config['Language'])) {
			$config['Language'] = array();
		}


		if (!isset($config['Currency'])) {
			$config['Currency'] = array();
		}

		

		if (!isset($config['RedirectTo'])) {
			$config['RedirectTo'] = array();
		}

		

		foreach ($config['Language'] as $k => $l) {
			if (strpos(strtoupper($l),strtoupper($country_of_the_visitor)) !== false) {
				$res['languageto'] = $k;
			}
		}

		foreach ($config['Currency'] as $k => $l) {
			if (strpos(strtoupper($l),strtoupper($country_of_the_visitor)) !== false) {
				$res['currencyto'] = $k;
			}
		}

		$res['syncmethod'] = $config['DetectMethod'];

		foreach ($config['RedirectTo'] as $k => $l) {
			if (strpos(strtoupper($l['countries']),strtoupper($country_of_the_visitor)) !== false) {
				$res['redirectto'] = $l['link'];
				if(isset($l['manual_redirect'])) {
					$res['manual_redirect'] = $l['manual_redirect'];
					$res['stripe_text'] = $l['stripe_text'];
					$res['button_text'] = $l['button_text'];
				}
			}
		}
		return $res;
	}

	public function getCountryByIp($ip) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ip2nation WHERE ip < INET_ATON(\"".$this->db->escape($ip)."\") ORDER BY `ip` DESC LIMIT 1");
		return $query->rows;

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