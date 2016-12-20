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

        <?php foreach($currencies as $k => $l): ?>
    	<div style="display:block;float:left;width:300px;margin-right:20px;">
            <div>
         <h5 style="display:inline-block">Use <b><?php echo $k; ?></b> when the visitor is from
        </h5>
        <?php if (!empty($data['AutoDetect']['Currency'][$k])): $lang_codes=explode(',',$data['AutoDetect']['Currency'][$k]);?>
        
        <div style="border:1px solid #ddd;padding:10px;border-radius:5px;margin-bottom:10px;">
        <?php  foreach ($lang_codes as $code): ?>

        <div style="margin:5px;color:#666"><span class="fa fa-check" style="color:#333;"></span> <?php echo $countries_iso[$code]; ?></div>


        <?php endforeach; ?>
		</div>
        
        <?php endif; ?>
        <input type="hidden" name="AutoDetect[Currency][<?php echo $k; ?>]" value="<?php if (isset($data['AutoDetect']['Currency'][$k])) echo $data['AutoDetect']['Currency'][$k]; else echo ''; ?>" class="language-country" id="lang_country_<?php echo $k; ?>" />
        </div>
		<a class="btn btn-default btn-addlanguage" data-toggle="modal" data-target="#countriesModal" input-id="lang_country_<?php echo $k; ?>"><i class="fa fa-plus"></i> <?php echo $text_add_country; ?></a>
        </div>
    
		<?php endforeach; ?>
        
	</div>


</div>
  
