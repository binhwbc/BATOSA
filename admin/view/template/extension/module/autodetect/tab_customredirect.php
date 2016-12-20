<div class="container-fluid">
    
</div>
<div class="">
	<div class="redirect-rules">
		<?php
		$countries_iso = array();
		
		foreach ($countries as $c){
			$countries_iso[$c['iso_code_2']] = $c['name'];
		}
		
		$k=0;
		
if (!isset($data['AutoDetect']['RedirectTo'])) {
	$data['AutoDetect']['RedirectTo'] = array();
}

foreach ($data['AutoDetect']['RedirectTo'] as $k=>$r):
		 ?>

    	<div class="redirect-rule" style="display:block;float:left;width:300px;margin:0 20px 20px 0; padding:15px; background:rgba(245,245,245,1);border-radius:6px;">
            <div style="position:relative;">
            <a class="btn btn-xs" style="position:absolute;right:24px;top:0;" data-toggle="tooltip" data-placement="top" title="The {REQUEST_URI} shortcode is allowed. For example, 'http://domain.com/{REQUEST_URI}'."><i class="fa fa-info"></i></a>
            <a class="btn btn-xs btn-cancelredirect" style="position:absolute;right:0;top:0;"><i class="fa fa-times"></i></a>
        <h5 style="display:inline-block"><?php echo $text_redirectto; ?> <input type="text" value="<?php if (isset($data['AutoDetect']['RedirectTo'][$k]['link'])) echo $data['AutoDetect']['RedirectTo'][$k]['link']; else echo ''; ?>" name="AutoDetect[RedirectTo][<?php echo $k; ?>][link]" style="display:inline;margin:10px 0;" class="form-control" placeholder="<?php echo $text_puturl_placeholder; ?>" />         
         <?php echo $text_coming_from; ?>
        </h5>
        <?php if (!empty($data['AutoDetect']['RedirectTo'][$k]['countries'])): $lang_codes=explode(',',$data['AutoDetect']['RedirectTo'][$k]['countries']);?>
        
        <div style="border:1px solid #ddd;padding:10px;background:#fff;border-radius:5px;margin-bottom:10px;">
        <?php  foreach ($lang_codes as $code): ?>

        <div style="margin:5px;color:#666"><span class="fa fa-check" style="color:#333;"></span> <?php echo $countries_iso[$code]; ?></div>


        <?php endforeach; ?>
		</div>
        
        <?php endif; ?>
        <input type="hidden" name="AutoDetect[RedirectTo][<?php echo $k; ?>][countries]" value="<?php if (isset($data['AutoDetect']['RedirectTo'][$k]['countries'])) echo $data['AutoDetect']['RedirectTo'][$k]['countries']; else echo ''; ?>" class="language-country" id="redir_country_<?php echo $k; ?>" />
        </div>
        
		<a class="btn btn-default btn-addlanguage" data-toggle="modal" data-target="#countriesModal" input-id="redir_country_<?php echo $k; ?>"><i class="fa fa-plus"></i> <?php echo $text_add_country; ?></a>
        <div class="checkbox">
            <label>
              <input type="checkbox" name="AutoDetect[RedirectTo][<?php echo $k; ?>][manual_redirect]" <?php if (isset($data['AutoDetect']['RedirectTo'][$k]['manual_redirect'])) echo 'checked=checked'; else echo ''; ?>>&nbsp;&nbsp;<?php echo $text_use_manual_redirect; ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-info" data-toggle="tooltip" data-original-title="This option will work only if you use asynchronous detection mode."></i>
            </label>
        </div>
        
        <div class="stripe-options">
            <?php echo $text_stripe_text; ?>
            <input type="text" class="form-control stripe-text" name="AutoDetect[RedirectTo][<?php echo $k; ?>][stripe_text]" value="<?php if (isset($data['AutoDetect']['RedirectTo'][$k]['stripe_text'])) echo $data['AutoDetect']['RedirectTo'][$k]['stripe_text']; else echo ''; ?>" placeholder="<?php echo $text_putustripe_text_placeholder; ?>" />
            <?php echo $text_button_text; ?>
            <input type="text" class="form-control stripe-text" name="AutoDetect[RedirectTo][<?php echo $k; ?>][button_text]" value="<?php if (isset($data['AutoDetect']['RedirectTo'][$k]['button_text'])) echo $data['AutoDetect']['RedirectTo'][$k]['button_text']; else echo 'Redirect me!'; ?>" placeholder="<?php echo $text_putustripe_button_placeholder; ?>" />
            </div>
        </div>
  <?php endforeach; ?>
        
     <a class="btn btn-default btn-create-redirect" ><?php echo $text_create_redirect; ?></a>
       
	</div>


</div>
<script>
    $('.btn-create-redirect').click(function() {
    	var html = $('.redirect-rule-template').html();
    	var cnt = $('.redirect-rules > .redirect-rule').size();
    	html = html.replace(/9999/g,cnt);
    	html = html.replace(/dataput/g,'input');
    	$('.redirect-rules').append(html);

        stripe_selectors();
    });
</script>

<div style="display:none" class="redirect-rule-template">
<?php  $k = 9999; ?>
    	<div class="redirect-rule" style="display:block;float:left;width:300px;margin:0 20px 20px 0; padding:15px; background:rgba(245,245,245,1);border-radius:6px;">
            <div style="position:relative;">
            <a class="btn btn-xs" style="position:absolute;right:24px;top:0;" data-toggle="tooltip" data-placement="top" title="The {REQUEST_URI} shortcode is allowed. For example, 'http://domain.com/{REQUEST_URI}'."><i class="fa fa-info"></i></a>
            <a class="btn btn-xs btn-cancelredirect" style="position:absolute;right:0;top:0;"><i class="fa fa-times"></i></a>
         <h5 style="display:inline-block"><?php echo $text_redirectto; ?> <dataput type="text" value="<?php if (isset($data['AutoDetect']['RedirectTo'][$k]['link'])) echo $data['AutoDetect']['RedirectTo'][$k]['link']; else echo ''; ?>" name="AutoDetect[RedirectTo][<?php echo $k; ?>][link]" style="display:inline;margin:10px 0;" class="form-control" placeholder="<?php echo $text_puturl_placeholder; ?>" /> <?php echo $text_coming_from; ?>
        </h5>
        <?php if (!empty($data['AutoDetect']['RedirectTo'][$k]['countries'])): $lang_codes=explode(',',$data['AutoDetect']['RedirectTo'][$k]['countries']);?>
        
        <div style="border:1px solid #ddd;padding:10px;background:#fff;border-radius:5px;margin-bottom:10px;">
        <?php  foreach ($lang_codes as $code): ?>

        <div style="margin:5px;color:#666"><span class="fa fa-check" style="color:#333;"></span> <?php echo $countries_iso[$code]; ?></div>


        <?php endforeach; ?>
		</div>
        
        <?php endif; ?>
        <dataput type="hidden" name="AutoDetect[RedirectTo][<?php echo $k; ?>][countries]" value="<?php if (isset($data['AutoDetect']['RedirectTo'][$k]['countries'])) echo $data['AutoDetect']['RedirectTo'][$k]['countries']; else echo ''; ?>" class="language-country" id="redir_country_<?php echo $k; ?>" />
        </div>
        
		<a class="btn btn-default btn-addlanguage" data-toggle="modal" data-target="#countriesModal" input-id="redir_country_<?php echo $k; ?>"><i class="fa fa-plus"></i> <?php echo $text_add_country; ?></a>
        <div class="checkbox">
            <label>
              <input type="checkbox" name="AutoDetect[RedirectTo][<?php echo $k; ?>][manual_redirect]" <?php if (isset($data['AutoDetect']['RedirectTo'][$k]['manual_redirect'])) echo 'checked=checked'; else echo ''; ?>>&nbsp;&nbsp;<?php echo $text_use_manual_redirect; ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-info" data-toggle="tooltip" data-original-title="This option will work only if you use asynchronous detection mode."></i>
            </label>
        </div>
        <div class="stripe-options">
            <?php echo $text_stripe_text; ?>
            <input type="text" class="form-control stripe-text" name="AutoDetect[RedirectTo][<?php echo $k; ?>][stripe_text]" value="<?php if (isset($data['AutoDetect']['RedirectTo'][$k]['stripe_text'])) echo $data['AutoDetect']['RedirectTo'][$k]['stripe_text']; else echo ''; ?>" placeholder="<?php echo $text_putustripe_text_placeholder; ?>" />
            <?php echo $text_button_text; ?>
            <input type="text" class="form-control stripe-text" name="AutoDetect[RedirectTo][<?php echo $k; ?>][button_text]" value="<?php if (isset($data['AutoDetect']['RedirectTo'][$k]['button_text'])) echo $data['AutoDetect']['RedirectTo'][$k]['button_text']; else echo 'Redirect me!'; ?>" placeholder="<?php echo $text_putustripe_button_placeholder; ?>" />
        </div>
        
        </div>
</div>
  
<script>
    function stripe_selectors() {
        $('.stripe-options').prev('.checkbox').children().children("input").each(function() {

            $(this).on('change', function() {
                if($(this).is(":checked")) {
                    $(this).parent().parent().next().show(200);
                } else {
                    $(this).parent().parent().next().hide(200);
                }
            });

            if($(this).is(":checked")) {
                $(this).parent().parent().next().show();
            } else {
                $(this).parent().parent().next().hide();
            }
            
        });

        $('.redirect-rule .btn-cancelredirect').each(function () {
        $(this).on('click', function() {
            $(this).parent().parent('.redirect-rule').remove();
            $('#form').submit();
        });
    });

    $('[data-toggle="tooltip"]').tooltip(); 
    }
    stripe_selectors();
    $('#form').on('submit', function() {
        $('.redirect-rule input[name*=9999]').parents('.redirect-rule').remove()
    });
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>