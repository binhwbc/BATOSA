<div class="container-fluid">
    
</div>
<div class="">
	<div >
		<?php
		$countries_iso = array();
		
		foreach ($countries as $c){
			$countries_iso[$c['iso_code_2']] = $c['name'];
		}
		 ?>
		
        <?php foreach($languages as $k => $l): ?>
    	<div style="display:block;float:left;width:300px;margin-right:20px;">
            <div>
         <img src="<?php echo $l['flag_url']; ?>" style="display:inline-block; margin-right:10px;" /><h5 style="display:inline-block">Use <b><?php echo $l['name']; ?></b> when the visitor is from
        </h5>
        <?php if (!empty($data['AutoDetect']['Language'][$k])): $lang_codes=explode(',',$data['AutoDetect']['Language'][$k]);?>
        
        <div style="border:1px solid #ddd;padding:10px;border-radius:5px;margin-bottom:10px;">
        <?php foreach ($lang_codes as $code): ?>

        <div style="margin:5px;color:#666"><span class="fa fa-check" style="color:#333;"></span> <?php echo $countries_iso[strtoupper($code)]; ?></div>


        <?php endforeach; ?>
		</div>
        
        <?php endif; ?>
        <input type="hidden" name="AutoDetect[Language][<?php echo $k; ?>]" value="<?php if (isset($data['AutoDetect']['Language'][$k])) echo $data['AutoDetect']['Language'][$k]; else echo ''; ?>" class="language-country" id="lang_country_<?php echo $k; ?>" />
        </div>
		<a class="btn btn-default btn-addlanguage" data-toggle="modal" data-target="#countriesModal" input-id="lang_country_<?php echo $k; ?>"><i class="fa fa-plus"></i> <?php echo $text_add_country; ?></a>
        </div>
    
		<?php endforeach; ?>
        
	</div>

	<style>
	
	#countriesModal .modal-body {
		padding:0;	
	}
	
	ul.countries {
		height:388px;
		overflow-y:scroll;	
		overflow-x:hidden;
		padding:10px 15px;
		margin:0;
		list-style:none;
	}
	
	ul.countries label {
		font-weight:normal;
		margin-left:5px;
	}
	</style>




</div>
  
