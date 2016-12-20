<div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <h5><span class="required">* </span><?php echo $text_module_status; ?>:</h5>
      </div>
      <div class="col-md-2">
        <select name="<?php echo $moduleName; ?>[Enabled]" class="form-control">
              <option value="yes" <?php echo (!empty($moduleData['Enabled']) && $moduleData['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
              <option value="no"  <?php echo (empty($moduleData['Enabled']) || $moduleData['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
        </select>
      </div>
      <div class="col-md-8">
              <span class="help"><?php echo $text_module_status_help; ?></span>
      </div>
    </div>
    <div class="row" style="margin-top:20px;">
      <div class="col-md-2">
        <h5><span class="required">* </span>Search engines</h5>
      </div>
      <div class="col-md-2">
        <select name="<?php echo $moduleName; ?>[SearchEngines]" class="form-control">
              <option value="yes" <?php echo (!empty($moduleData['SearchEngines']) && $moduleData['SearchEngines'] == 'yes') ? 'selected=selected' : '' ?>>Enable detection for search engines</option>
              <option value="no"  <?php echo (empty($moduleData['SearchEngines']) || $moduleData['SearchEngines']== 'no') ? 'selected=selected' : '' ?>>Disable detection for search engines</option>
        </select>
      </div>
      <div class="col-md-8">
              <span class="help">Choose module behavior when a search engine visits your site</span>
      </div>
    </div>
    <div class="row" style="margin-top:20px;">
      <div class="col-md-2">
        <h5><span class="required">* </span><?php echo $text_detect_method; ?>:</h5>

      </div>
      <div class="col-md-2">
        <select name="<?php echo $moduleName; ?>[DetectMethod]" class="form-control">
              <option value="sync" <?php echo (!empty($moduleData['DetectMethod']) && $moduleData['DetectMethod'] == 'sync') ? 'selected=selected' : '' ?>><?php echo $text_synchronous; ?></option>
              <option value="async"  <?php echo (empty($moduleData['DetectMethod']) || $moduleData['DetectMethod']== 'async') ? 'selected=selected' : '' ?>><?php echo $text_asynchronous; ?></option>
        </select>
      </div>
      <div class="col-md-8">
       <span class="help"><b><?php echo $text_asynchronous; ?></b> - <?php echo $text_asynchronous_desc; ?><br>
		<b><?php echo $text_synchronous; ?></b> - <?php echo $text_synchronous_desc; ?>
    	</span>
      </div>
    </div>
    <div style="margin-top:50px;color:#999;font-size:11px;">
	<?php 
    $lastupdate = file_get_contents('../vendors/autodetect/database.txt');
    echo $lastupdate;
    ?>

    <?php if ($display_update_button) { ?>
    <a style='margin-left:10px;color:#FFF;' href="<?php echo $update_url; ?>" class="btn btn-primary btn-xs">Update database</a>
    <?php } ?>
    </div>
</div>