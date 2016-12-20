<?php echo $header;?><?php echo $column_left; ?>
<div id="content" class="AutoDetect">
	<script type="text/javascript">
		NProgress.configure({
			showSpinner: false,
			ease: 'ease',
			speed: 500,
			trickleRate: 0.2,
			trickleSpeed: 200 
		});
	</script>
 <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
     <?php echo (empty($moduleData['LicensedOn'])) ? base64_decode('ICAgIDxkaXYgY2xhc3M9ImFsZXJ0IGFsZXJ0LWRhbmdlciBmYWRlIGluIj4NCiAgICAgICAgPGJ1dHRvbiB0eXBlPSJidXR0b24iIGNsYXNzPSJjbG9zZSIgZGF0YS1kaXNtaXNzPSJhbGVydCIgYXJpYS1oaWRkZW49InRydWUiPsOXPC9idXR0b24+DQogICAgICAgIDxoND5XYXJuaW5nISBVbmxpY2Vuc2VkIHZlcnNpb24gb2YgdGhlIG1vZHVsZSE8L2g0Pg0KICAgICAgICA8cD5Zb3UgYXJlIHJ1bm5pbmcgYW4gdW5saWNlbnNlZCB2ZXJzaW9uIG9mIHRoaXMgbW9kdWxlISBZb3UgbmVlZCB0byBlbnRlciB5b3VyIGxpY2Vuc2UgY29kZSB0byBlbnN1cmUgcHJvcGVyIGZ1bmN0aW9uaW5nLCBhY2Nlc3MgdG8gc3VwcG9ydCBhbmQgdXBkYXRlcy48L3A+PGRpdiBzdHlsZT0iaGVpZ2h0OjVweDsiPjwvZGl2Pg0KICAgICAgICA8YSBjbGFzcz0iYnRuIGJ0bi1kYW5nZXIiIGhyZWY9ImphdmFzY3JpcHQ6dm9pZCgwKSIgb25jbGljaz0iJCgnYVtocmVmPSNpc2Vuc2Vfc3VwcG9ydF0nKS50cmlnZ2VyKCdjbGljaycpIj5FbnRlciB5b3VyIGxpY2Vuc2UgY29kZTwvYT4NCiAgICA8L2Rpdj4=') : '' ?>
    <?php if ($error_warning) { ?>
        <div class="alert alert-danger autoSlideUp"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
         <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php } ?>
    <?php if ($success) { ?>
        <div class="alert alert-success autoSlideUp"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <script>$('.autoSlideUp').delay(3000).fadeOut(600, function(){ $(this).show().css({'visibility':'hidden'}); }).slideUp(600);</script>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>&nbsp;<span style="vertical-align:middle;font-weight:bold;">Module settings</span></h3>           
        </div>
        <div class="panel-body">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form"> 
                <input type="hidden" name="store_id" value="<?php echo $store['store_id']; ?>" />
                <div class="tabbable">
                    <div class="tab-navigation form-inline">
                        <ul class="nav nav-tabs mainMenuTabs" id="mainTabs" role="tablist">
                            <li><a href="#control_panel" role="tab" data-toggle="tab"><i class="fa fa-power-off"></i>&nbsp;&nbsp;<?php echo $text_controlpanel; ?></a></li>
                            <li><a href="#language" role="tab" data-toggle="tab"><i class="fa fa-language"></i>&nbsp;&nbsp;<?php echo $text_language; ?></a></li>
                            <li><a href="#currency" role="tab" data-toggle="tab"><i class="fa fa-usd"></i>&nbsp;&nbsp;<?php echo $text_currency; ?></a></li>
                            <li><a href="#customredirect" role="tab" data-toggle="tab"><i class="fa fa-exchange"></i>&nbsp;&nbsp;<?php echo $text_customredirect; ?></a></li>

                            <li><a href="#isense_support" role="tab" data-toggle="tab"><i class="fa fa-ticket"></i>&nbsp;&nbsp;<?php echo $text_support; ?></a></li>
                        </ul>
                        <div class="tab-buttons">
                            <button type="submit" class="btn btn-success save-changes"><i class="fa fa-check"></i>&nbsp;<?php echo $save_changes?></button>
                            <a onclick="location = '<?php echo $cancel; ?>'" class="btn btn-warning"><?php echo $button_cancel?></a>
                        </div> 
                    </div><!-- /.tab-navigation --> 
                    <div class="tab-content">
                        <div id="control_panel" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/' . $modulePath . '/tab_controlpanel.php'); ?></div>
                        <div id="language" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/' . $modulePath . '/tab_language.php'); ?></div>
                        <div id="currency" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/' . $modulePath . '/tab_currency.php'); ?></div>
                        <div id="customredirect" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/' . $modulePath . '/tab_customredirect.php'); ?></div>

                        <div id="isense_support" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/' . $modulePath . '/tab_support.php'); ?></div>
                    </div> <!-- /.tab-content --> 
                </div><!-- /.tabbable -->
                

<div class="modal fade" id="countriesModal" parent="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><?php echo $text_choose_countries; ?></h4>
      </div>
      <div class="modal-body">
        <div>
            <ul class="countries">
            <?php foreach($countries as $c): ?>
                <li><input type="checkbox" value="<?php echo $c['iso_code_2'] ?>" id="c_<?php echo $c['country_id'] ?>" /><label for="c_<?php echo $c['country_id'] ?>"><?php echo $c['name'] ?> (<?php echo $c['iso_code_2'] ?>)</label> </li>    
            <?php endforeach; ?>
            </ul>
        </div>
      </div>
      <div class="modal-footer"> 
        <div class="select-buttons pull-left">
          <a href="#" class="select-all"><?php echo $text_select_all ?></a>
          &nbsp;|&nbsp;
          <a href="#" class="deselect-all"><?php echo $text_deselect_all ?></a>
        </div>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $button_cancel?></button>
        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> <?php echo $save_changes?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
                
                
            </form>
        </div> 
    </div>
  </div>
</div>


<?php echo $footer; ?>
<script type="text/javascript">
	$('#mainTabs a:first').tab('show'); // Select first tab
	$('.followup-list').children().last().children('a').click();
	if (window.localStorage && window.localStorage['currentTab']) {
		$('.mainMenuTabs a[href="'+window.localStorage['currentTab']+'"]').tab('show');
	}
	if (window.localStorage && window.localStorage['currentSubTab']) {
		$('a[href="'+window.localStorage['currentSubTab']+'"]').tab('show');
	}
	$('.fadeInOnLoad').css('visibility','visible');
	$('.mainMenuTabs a[data-toggle="tab"]').click(function() {
		if (window.localStorage) {
			window.localStorage['currentTab'] = $(this).attr('href');
		}
	});
	$('a[data-toggle="tab"]:not(.mainMenuTabs a[data-toggle="tab"], .followup_tabs a[data-toggle="tab"])').click(function() {
		if (window.localStorage) {
			window.localStorage['currentSubTab'] = $(this).attr('href');
		}
	});
</script>

  
  <script>
  	var inputid = '';
  	$('.btn-addlanguage').on('click',function(e) {
		inputid = $(this).attr('input-id');

		val = $('#'+inputid).val();
		$('ul.countries li input').removeAttr('checked');
		$('ul.countries li input').each(function(index, element) {
      if (val.indexOf($(element).val()) != -1) {
				$(element).prop('checked',true);
			}
    });
	});

  function joinCheckedValues () {
    var checkedValues = $('ul.countries li input[type="checkbox"]:checked').map(function() {
       return this.value;
    }).get();
    $('#'+inputid).val(checkedValues.join()); 
  }
	
	$('ul.countries li input').click(function(e) {
		joinCheckedValues();
	});

  $('.select-buttons .select-all').click(function(event) {  //on click 
    event.preventDefault();
    event.stopPropagation();
    $(this).parents('.modal-content').find('ul.countries input[type="checkbox"]').each(function() {
        this.checked = true;     
    });
    joinCheckedValues();
  });

  $('.select-buttons .deselect-all').click(function(event) {  //on click 
      event.preventDefault();
      event.stopPropagation();
      $(this).parents('.modal-content').find('ul.countries input[type="checkbox"]').each(function() {
          this.checked = false;          
      });
      joinCheckedValues();
  });
  
  </script>