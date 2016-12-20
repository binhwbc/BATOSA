<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="row">
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
          </div>
          <div class="panel-body">
			<?php if ($group_lists) { ?>
			<div id="form-group-results"></div>
			<form action="<?php echo $group_compose; ?>" method="post" enctype="multipart/form-data" id="form-compose">
				<textarea style="display:none;" id="menu_output" name="menu_output"></textarea>
				<menu id="nestable-menu">
					<input type="submit" value="<?php echo $button_finished; ?>" class="btn btn-primary pull-right">
					<button type="button" data-action="expand-all" class="btn btn-default pull-left"><?php echo $button_expand; ?></button>
					<button type="button" data-action="collapse-all" class="btn btn-default pull-left"><?php echo $button_collapse; ?></button>
				</menu>
				<div class="cf nestable-lists">
					<div class="dd" id="nestable">
					<?php echo $group_lists; ?>
					</div>
				</div>
				<input type="hidden" name="menu_id" value="<?php echo $menu_info['menu_id']; ?>">
			</form>
			<?php } ?>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><?php echo $text_links; ?></a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <form action="<?php echo $groupSingleAdd; ?>" method="post" enctype="multipart/form-data" id="form-link">
                  <div class="form-group required">
                    <label><?php echo $entry_name; ?></label>
                     <?php foreach ($languages as $language) { ?>
                     <div class="input-group"> <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                       <input type="text" name="menu_group_languages[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($menu_group_languages[$language['language_id']]) ? $menu_group_languages[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
                     </div>
                     <?php if (isset($error_name[$language['language_id']])) { ?>
                     <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                     <?php } ?>
                     <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="input-module_type"><?php echo $input_species; ?></label>
                    <select name="module_type" id="input-module_type" class="form-control" onchange="$('#input-module_id').load('index.php?route=design/menu/species&token=<?php echo $token; ?>&module_type=' + this.value + '&module_id=&menu_id=<?php echo $menu_info['menu_id']; ?>&menu_group_id=');">
                      <option value="link" <?php if($module_type=='link'){ echo 'selected'; } ?>><?php echo $text_links; ?></option>
                      <option value="product" <?php if($module_type=='product'){ echo 'selected'; } ?>><?php echo $text_product; ?></option>
                      <option value="category" <?php if($module_type=='category'){ echo 'selected'; } ?>><?php echo $text_category; ?></option>
                      <option value="information" <?php if($module_type=='information'){ echo 'selected'; } ?>><?php echo $text_information; ?></option>
                      <option value="manufacturer" <?php if($module_type=='manufacturer'){ echo 'selected'; } ?>><?php echo $text_manufacturer; ?></option>
                      <option value="blog" <?php if($module_type=='blog'){ echo 'selected'; } ?>>Blog</option>
                      <option value="blog_category" <?php if($module_type=='blog_category'){ echo 'selected'; } ?>>Blog Category</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="input-module_id"><?php echo $input_module; ?></label>
                    <select name="module_id" id="input-module_id" class="form-control select2" onchange="$.get('index.php?route=design/menu/moduleurl&token=<?php echo $token; ?>&module_type=' + $('#input-module_type').val() + '&module_id=' + this.value + '&menu_id=<?php echo $menu_info['menu_id']; ?>', function(response_url){ $('#input-url').val(response_url); });"></select>
                  </div>
                  <div class="form-group required">
                    <label for="input-url"><?php echo $input_url; ?></label>
                    <input type="text" name="url" id="input-url" value="<?php echo $url; ?>" placeholder="<?php echo $input_url; ?>" class="form-control" />
                  </div>
                
               <div class="form-group ">
                  <label for="input-class">Class</label>
                  <input type="text" name="class" value="<?php echo $class; ?>" placeholder="New / Hot / Sale" id="input-class" class="form-control" />
                </div>
    		      <div class="form-group">
          			<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
          			<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
    		      </div>
                  <div class="form-group">
                    <label for="input-style"><?php echo $input_style; ?></label>
                    <select name="style" id="input-style" class="form-control">
                      <option value="dropdown" <?php if ($style=='dropdown') { ?>selected="selected"<?php } ?>><?php echo $input_style_dropdown; ?></option>
                      <option value="tabbed" <?php if ($style=='tabbed') { ?>selected="selected"<?php } ?>><?php echo $input_style_tabbed; ?></option>
                      <option value="lists" <?php if ($style=='lists') { ?>selected="selected"<?php } ?>><?php echo $input_style_lists; ?></option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="input-font"><?php echo $input_font; ?></label>
                    <div class="input-group">
                    <input type="text" name="font" data-placement="left" value="<?php echo $font; ?>" id="input-font" class="icp icp-auto form-control" />
                      <span class="input-group-btn">
                        <button type="button" id="button-font" class="btn btn-primary"></button>
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="input-window"><?php echo $input_window; ?></label>
                    <select name="window" id="input-window" class="form-control">
                      <?php if ($window) { ?>
                      <option value="1" selected="selected"><?php echo $input_popup; ?></option>
                      <option value="0"><?php echo $input_fixed; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $input_popup; ?></option>
                      <option value="0" selected="selected"><?php echo $input_fixed; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <input type="hidden" name="menu_id" value="<?php echo $menu_info['menu_id']; ?>">
                </form>
                <div class="form-group">
                  <div class="col-sm-12">
                    <?php if (isset($groupSingleCancel)) { ?><a href="<?php echo $groupSingleCancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default pull-right"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a><?php } ?>
                    <button type="submit" id="form-link" form="form-link" class="btn btn-primary pull-left"><i class="fa fa-plus-circle"></i> <?php echo $button_menu; ?></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><?php echo $input_collective; ?></a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
				        <div class="form-group">
                  <label class="col-lg-12 control-label" for="input-points"><?php echo $input_type; ?></label>
                  <div class="col-lg-12">
                    <div class="col-lg-6">
                      <label for="collective_type_product" class="radio-inline">
                      <input id="collective_type_product" name="collective_type" value="product" checked="checked" type="radio"><?php echo $text_product; ?></label>
                    </div>
                    <div class="col-lg-6">
                      <label for="collective_type_category" class="radio-inline">
                      <input id="collective_type_category" name="collective_type" value="category" type="radio"><?php echo $text_category; ?></label>
                    </div>
                    <div class="col-lg-6">
                      <label for="collective_type_information" class="radio-inline">
                      <input id="collective_type_information" name="collective_type" value="information" type="radio"><?php echo $text_information; ?></label>
                    </div>
                    <div class="col-lg-6">
                      <label for="collective_type_manufacturer" class="radio-inline">
                      <input id="collective_type_manufacturer" name="collective_type" value="manufacturer" type="radio"><?php echo $text_manufacturer; ?></label>
                    </div>
                    <div class="col-lg-6">
                      <label for="collective_type_blog" class="radio-inline">
                      <input id="collective_type_blog" name="collective_type" value="blog"  type="radio">Blog</label>
                    </div>
                    <div class="col-lg-6">
                      <label for="collective_type_blog_category" class="radio-inline">
                      <input id="collective_type_blog_category" name="collective_type" value="blog_category"  type="radio">Blog Category</label>
                    </div>

                  </div>
				        </div>

                <div id="collective_type_contents_product" class="col-lg-12">
                	<form action="<?php echo $groupMultipleAdd; ?>" method="post" enctype="multipart/form-data" id="form-product">
        				  <div class="form-group">
        				     <div class="col-sm-12">
        				       <input type="text" name="product" value="" placeholder="<?php echo $text_product; ?>" id="input-product" class="form-control" />
        				       <div id="menu-product" class="well well-sm" style="height: 150px; overflow: auto;"></div>
        				     </div>
        				  </div>
        				  <input type="hidden" name="menu_id" value="<?php echo $menu_info['menu_id']; ?>">
        				  <input type="hidden" name="module_type" value="product">
                  </form>
                  <div class="form-group">
                    <div class="col-sm-12"><button type="submit" id="form-product" form="form-product" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> <?php echo $button_menu_add; ?> <?php echo $text_product; ?></button></div>
                  </div>
                </div>

                <div id="collective_type_contents_category" class="col-lg-12" style="display: none;">
                	<form action="<?php echo $groupMultipleAdd; ?>" method="post" enctype="multipart/form-data" id="form-category">
        				  <div class="form-group">
        				     <div class="col-sm-12">
        				       <input type="text" name="category" value="" placeholder="<?php echo $text_category; ?>" id="input-category" class="form-control" />
        				       <div id="menu-category" class="well well-sm" style="height: 150px; overflow: auto;"></div>
        				     </div>
        				  </div>
        				  <input type="hidden" name="menu_id" value="<?php echo $menu_info['menu_id']; ?>">
        				  <input type="hidden" name="module_type" value="category">
                  </form>
                  <div class="form-group">
                    <div class="col-sm-12"><button type="submit" id="form-category" form="form-category" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> <?php echo $button_menu_add; ?> <?php echo $text_category; ?></button></div>
                  </div>
                </div>

                <div id="collective_type_contents_information" class="col-lg-12" style="display: none;">
                	<form action="<?php echo $groupMultipleAdd; ?>" method="post" enctype="multipart/form-data" id="form-information">
        				  <div class="form-group">
        				     <div class="col-sm-12">
        				       <input type="text" name="information" value="" placeholder="<?php echo $text_information; ?>" id="input-information" class="form-control" />
        				       <div id="menu-information" class="well well-sm" style="height: 150px; overflow: auto;"></div>
        				     </div>
        				  </div>
        				  <input type="hidden" name="menu_id" value="<?php echo $menu_info['menu_id']; ?>">
        				  <input type="hidden" name="module_type" value="information">
                  </form>
                  <div class="form-group">
                    <div class="col-sm-12"><button type="submit" id="form-information" form="form-information" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> <?php echo $button_menu_add; ?> <?php echo $text_information; ?></button></div>
                  </div>
                </div>

                <div id="collective_type_contents_manufacturer" class="col-lg-12" style="display: none;">
                	<form action="<?php echo $groupMultipleAdd; ?>" method="post" enctype="multipart/form-data" id="form-manufacturer">
        				  <div class="form-group">
        				     <div class="col-sm-12">
        				       <input type="text" name="manufacturer" value="" placeholder="<?php echo $text_manufacturer; ?>" id="input-manufacturer" class="form-control" />
        				       <div id="menu-manufacturer" class="well well-sm" style="height: 150px; overflow: auto;"></div>
        				     </div>
        				  </div>
        				  <input type="hidden" name="menu_id" value="<?php echo $menu_info['menu_id']; ?>">
        				  <input type="hidden" name="module_type" value="manufacturer">
                  </form>
                  <div class="form-group">
                    <div class="col-sm-12"><button type="submit" id="form-manufacturer" form="form-manufacturer" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> <?php echo $button_menu_add; ?> <?php echo $text_manufacturer; ?></button></div>
                  </div>
                </div>

                 <div id="collective_type_contents_blog" class="col-lg-12" style="display: none;">
                  <form action="<?php echo $groupMultipleAdd; ?>" method="post" enctype="multipart/form-data" id="form-blog">
                  <div class="form-group">
                     <div class="col-sm-12">
                       <input type="text" name="blog" value="" placeholder="Blog" id="input-blog" class="form-control" />
                       <div id="menu-blog" class="well well-sm" style="height: 150px; overflow: auto;"></div>
                     </div>
                  </div>
                  <input type="hidden" name="menu_id" value="<?php echo $menu_info['menu_id']; ?>">
                  <input type="hidden" name="module_type" value="blog">
                  </form>
                  <div class="form-group">
                    <div class="col-sm-12"><button type="submit" id="form-blog" form="form-blog" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> <?php echo $button_menu_add; ?> Blog</button></div>
                  </div>
                </div>

                <div id="collective_type_contents_blog_category" class="col-lg-12" style="display: none;">
                  <form action="<?php echo $groupMultipleAdd; ?>" method="post" enctype="multipart/form-data" id="form-blog-category">
                  <div class="form-group">
                     <div class="col-sm-12">
                       <input type="text" name="blog_category" value="" placeholder="<?php echo $text_category; ?>" id="input-blog-category" class="form-control" />
                       <div id="menu-blog-category" class="well well-sm" style="height: 150px; overflow: auto;"></div>
                     </div>
                  </div>
                  <input type="hidden" name="menu_id" value="<?php echo $menu_info['menu_id']; ?>">
                  <input type="hidden" name="module_type" value="blog_category">
                  </form>
                  <div class="form-group">
                    <div class="col-sm-12"><button type="submit" id="form-blog-category" form="form-blog-category" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> <?php echo $button_menu_add; ?> Danh mục Blog</button></div>
                  </div>
                </div>
            


              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?php if($menu_group){ ?>
<script type="text/javascript">
$('#input-module_id').load('index.php?route=design/menu/species&token=<?php echo $token; ?>&module_type=<?php echo $menu_group['module_type']; ?>&module_id=<?php echo $menu_group['module_id']; ?>&menu_id=<?php echo $menu_group['menu_id']; ?>&menu_group_id=<?php echo $menu_group['menu_group_id']; ?>');
</script>
<?php } ?>

<script type="text/javascript">
$(function() {
  $('.icp-auto').iconpicker();
});

$('.select2').select2({
  placeholder: 'Select an option'
});

</script>

<script type="text/javascript">
$('input[name=\'collective_type\']').on('change', function() {

  if (this.value == 'product') {
    $('#collective_type_contents_product').show();
    $('#collective_type_contents_category').hide();
    $('#collective_type_contents_information').hide();
    $('#collective_type_contents_manufacturer').hide();
    $('#collective_type_contents_blog').hide();
    $('#collective_type_contents_blog_category').hide();
  }
  if (this.value == 'category') {
    $('#collective_type_contents_product').hide();
    $('#collective_type_contents_category').show();
    $('#collective_type_contents_information').hide();
    $('#collective_type_contents_manufacturer').hide();
    $('#collective_type_contents_blog').hide();
    $('#collective_type_contents_blog_category').hide();
  }
  if (this.value == 'information') {
    $('#collective_type_contents_product').hide();
    $('#collective_type_contents_category').hide();
    $('#collective_type_contents_information').show();
    $('#collective_type_contents_manufacturer').hide();
    $('#collective_type_contents_blog').hide();
    $('#collective_type_contents_blog_category').hide();
  }
  if (this.value == 'manufacturer') {
    $('#collective_type_contents_product').hide();
    $('#collective_type_contents_category').hide();
    $('#collective_type_contents_information').hide();
    $('#collective_type_contents_manufacturer').show();
    $('#collective_type_contents_blog').hide();
    $('#collective_type_contents_blog_category').hide();
  }
  if (this.value == 'blog') {
    $('#collective_type_contents_product').hide();
    $('#collective_type_contents_category').hide();
    $('#collective_type_contents_information').hide();
    $('#collective_type_contents_manufacturer').hide();
    $('#collective_type_contents_blog').show();
    $('#collective_type_contents_blog_category').hide();
  }
  if (this.value == 'blog_category') {
    $('#collective_type_contents_product').hide();
    $('#collective_type_contents_category').hide();
    $('#collective_type_contents_information').hide();
    $('#collective_type_contents_manufacturer').hide();
    $('#collective_type_contents_blog').hide();
    $('#collective_type_contents_blog_category').show();
  }

});
</script>

<script type="text/javascript">

// Blog
$('input[name=\'blog\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=blog/blog/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['title'],
            value: item['blog_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'blog\']').val('');
    $('#menu-blog' + item['value']).remove();
    $('#menu-blog').append('<div id="menu-blog' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="menu_blog[]" value="' + item['value'] + '" /></div>'); 
  } 
});
$('#menu-blog').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});


// Blog category
$('input[name=\'blog_category\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=blog/blog_category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'blog_category\']').val('');
    $('#menu-blog-category' + item['value']).remove();
    $('#menu-blog-category').append('<div id="menu-blog-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="menu_blog_category[]" value="' + item['value'] + '" /></div>');  
  } 
});
$('#menu-blog-category').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});




// product
$('input[name=\'product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'product\']').val('');
		$('#menu-product' + item['value']).remove();
		$('#menu-product').append('<div id="menu-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="menu_product[]" value="' + item['value'] + '" /></div>');	
	}	
});
$('#menu-product').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

// category
$('input[name=\'category\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'category\']').val('');
		$('#menu-category' + item['value']).remove();
		$('#menu-category').append('<div id="menu-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="menu_category[]" value="' + item['value'] + '" /></div>');	
	}	
});
$('#menu-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

// Informations
$('input[name=\'information\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=design/menu/autocompleteinformation&token=<?php echo $token; ?>&filter_title=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['title'],
						value: item['information_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'information\']').val('');
		$('#menu-information' + item['value']).remove();
		$('#menu-information').append('<div id="menu-information' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="menu_information[]" value="' + item['value'] + '" /></div>');	
	}	
});
$('#menu-information').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

// Manufacturer
$('input[name=\'manufacturer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['manufacturer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'manufacturer\']').val('');
		$('#menu-manufacturer' + item['value']).remove();
		$('#menu-manufacturer').append('<div id="menu-manufacturer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="menu_manufacturer[]" value="' + item['value'] + '" /></div>');	
	}	
});
$('#menu-manufacturer').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
</script>

<script type="text/javascript">
  $(document).ready(function() {
  
    var updateOutput = function(e){
      var list   = e.length ? e : $(e.target), output = list.data('output');
      if(output!=undefined){
      if (window.JSON) {
        output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
      } else {
        output.val('JSON browser support required for this demo.');
      }
    }
    };
    $('#nestable').nestable({ group: 1 }).on('change', updateOutput);
    updateOutput($('#nestable').data('output', $('#menu_output')));
    $('#nestable-menu').on('click', function(e){
      var target = $(e.target), action = target.data('action');
      if (action === 'expand-all') {
        $('.dd').nestable('expandAll');
      }
      if (action === 'collapse-all') {
        $('.dd').nestable('collapseAll');
      }
    });
  });
</script>
<?php echo $footer; ?>