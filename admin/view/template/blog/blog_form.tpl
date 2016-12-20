<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-information" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <ul class="nav nav-tabs">
            
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
            <li><a href="#tab-links" data-toggle="tab"><?php echo $tab_links; ?></a></li>
            <li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>

          </ul>
          <div class="tab-content">
            
            
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                <!-- multilingual start -->
                
                
                <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_title; ?></label>
                <div class="col-sm-10">
                <input name="blog_description[<?php echo $language['language_id']; ?>][title]" class="form-control" value="<?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['title'] : ''; ?>" />
                <?php if (isset($error_title[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
              <?php } ?>
              </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_page_title; ?></label>
                <div class="col-sm-10">
                <input name="blog_description[<?php echo $language['language_id']; ?>][page_title]" class="form-control" value="<?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['page_title'] : ''; ?>" />
              </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_description; ?></label>
                <div class="col-sm-10">
                <textarea name="blog_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['description'] : ''; ?></textarea>
              </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_short_description_h; ?>"><?php echo $entry_short_description; ?></span></label>
                <div class="col-sm-10">
                <textarea name="blog_description[<?php echo $language['language_id']; ?>][short_description]" id="short_description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['short_description'] : ''; ?></textarea>
                <?php if (isset($error_short_description[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_short_description[$language['language_id']]; ?></span>
              <?php } ?>
              </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_meta_description; ?></label>
                <div class="col-sm-10">
                <textarea name="blog_description[<?php echo $language['language_id']; ?>][meta_description]" class="form-control"><?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
              </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_meta_keyword; ?></label>
                <div class="col-sm-10">
                <input name="blog_description[<?php echo $language['language_id']; ?>][meta_keyword]" class="form-control" value="<?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['meta_keyword'] : ''; ?>" />
              </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_tags; ?></label>
                <div class="col-sm-10">
                <input name="blog_description[<?php echo $language['language_id']; ?>][tags]" class="form-control" value="<?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['tags'] : ''; ?>" />
              </div>
              </div>
                
				<!-- multilingual ends -->
                </div>
                <?php } ?>
              </div> <!-- language tab ends -->
            </div> <!-- tab-general ends -->
            
            
            <div class="tab-pane" id="tab-data">
			
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_keyword; ?></label>
                <div class="col-sm-10">
                <input type="text" name="keyword" class="form-control" value="<?php echo $keyword; ?>" />
              </div>
              </div>
              
              <?php if ($allow_author_change) { ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_author; ?></label>
                <div class="col-sm-10">
                <input type="text" name="author" class="form-control" value="<?php echo $author; ?>" />
              </div>
              </div>
              <?php } else { ?>
              <input type="hidden" name="author" class="form-control" value="<?php echo $author; ?>" />
              <?php } ?>
              

              
             <div class="form-group">
                <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
                <div class="col-sm-10">
                  <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                </div>
              </div>
              
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_allow_comment; ?></label>
                <div class="col-sm-10">
                <select name="allow_comment" class="form-control">
                <?php if ($allow_comment) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select>
              </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                <select name="status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
              </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                <input name="sort_order" value="<?php echo $sort_order; ?>" class="form-control" />
              </div>
              </div>		
            
            </div> <!-- tab-data ends -->
            
            <div class="tab-pane" id="tab-links">
            
            <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_category; ?></label>
            <div class="col-sm-10">
            <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" class="form-control" />
            <div id="blog-category" class="well well-sm" style="height: 150px; overflow: auto;">
            <?php foreach ($blog_categories as $blog_category) { ?>
            <?php if (in_array($blog_category['blog_category_id'], $this_blog_category)) { ?>
            <div id="blog-category<?php echo $blog_category['blog_category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $blog_category['name']; ?>
            <input type="hidden" name="this_blog_category[]" value="<?php echo $blog_category['blog_category_id']; ?>" />
            </div>
            <?php } ?>
            <?php } ?>
            </div>
            </div>
            </div>
      
      		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_related; ?></label>
            <div class="col-sm-10">
            <input type="text" name="related" value="" placeholder="<?php echo $entry_related; ?>" class="form-control" />
            <div id="blog-related" class="well well-sm" style="height: 150px; overflow: auto;">
            <?php foreach ($blogs as $blog) { ?>
            <?php if (in_array($blog['blog_id'], $related_blog)) { ?>
            <div id="blog-related<?php echo $blog['blog_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $blog['title']; ?>
            <input type="hidden" name="related_blog[]" value="<?php echo $blog['blog_id']; ?>" />
            </div>
            <?php } ?>
            <?php } ?>
            </div>
            </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $blog_store)) { ?>
                        <input type="checkbox" name="blog_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="blog_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $blog_store)) { ?>
                        <input type="checkbox" name="blog_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="blog_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              
          	</div> <!-- tab-links ends -->
            

            <div class="tab-pane" id="tab-design">
          	<div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_store; ?></td>
                      <td class="text-left"><?php echo $entry_layout; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left"><?php echo $text_default; ?></td>
                      <td class="text-left"><select name="blog_layout[0][layout_id]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($blog_layout[0]) && $blog_layout[0] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php foreach ($stores as $store) { ?>
                    <tr>
                      <td class="text-left"><?php echo $store['name']; ?></td>
                      <td class="text-left"><select name="blog_layout[<?php echo $store['store_id']; ?>][layout_id]" class="form-control">
                      <option value=""></option>
                      <?php foreach ($layouts as $layout) { ?>
                      <?php if (isset($blog_layout[$store['store_id']]) && $blog_layout[$store['store_id']] == $layout['layout_id']) { ?>
                      <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                      </select></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
            </div>
            
          	</div><!-- tab-design ends -->
            
        </form>
      </div>
    </div>
  </div>
  </div>
 </div>

<script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script>

<script type="text/javascript"><!--
// Category
$('input[name=\'category\']').autocomplete({
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
		$('input[name=\'category\']').val('');
		
		$('#blog-category' + item['value']).remove();
		
		$('#blog-category').append('<div id="blog-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="this_blog_category[]" value="' + item['value'] + '" /></div>');	
	}
});

$('#blog-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

//Related
$('input[name=\'related\']').autocomplete({
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
		$('input[name=\'related\']').val('');
		
		$('#blog-related' + item['value']).remove();
		
		$('#blog-related').append('<div id="blog-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="related_blog[]" value="' + item['value'] + '" /></div>');
	}
});

$('#blog-related').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<?php echo $footer; ?>