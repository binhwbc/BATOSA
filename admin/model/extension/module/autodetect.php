<?php 

class ModelExtensionModuleAutoDetect extends Model {

	

  	public function install() {

		$this->db->query("

		CREATE TABLE ".DB_PREFIX."ip2nation (

		  ip int(11) unsigned NOT NULL default '0',

		  country char(2) NOT NULL default '',

		  KEY ip (ip)

		);");

		$handle = fopen("../vendors/autodetect/ip2nation.sql", "r");

		if ($handle) {

			while (($line = fgets($handle)) !== false) {

				$this->db->query(str_replace('ip2nation',DB_PREFIX.'ip2nation',$line));

			}

		} else {

			echo 'Unable to open module files. Please make sure you have uploaded all the files.';

		} 

		fclose($handle);

		

  	} 

  

  	public function uninstall() {

		$this->db->query("DROP TABLE IF EXISTS ".DB_PREFIX."ip2nation;");

  	}



}

?>