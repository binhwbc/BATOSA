<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-setting" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
  <?php if ((!$blogsetting_blogs_per_page) || (!$blogsetting_comment_per_page) || (!$blogsetting_thumbs_w) || (!$blogsetting_thumbs_h) || (!$blogsetting_rel_thumbs_w) || (!$blogsetting_rel_thumbs_h) || (!$blogsetting_rel_characters)) { ?>
	<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_missing; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
	<?php } ?>
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">

        <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10"><legend><h3 style="margin-top:20px;"><?php echo $heading_blog_home; ?></h3></legend></div>
        </div>
        
        <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
        <ul class="nav nav-tabs" id="language">
        <?php foreach ($languages as $language) { ?>
        <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
        <?php } ?>
        </ul>
        </div>
        </div>
        
        <div class="tab-content">
		<?php foreach ($languages as $language) { ?>
        <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
        <!-- Multilingual start -->
        
        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_home_title; ?></label>
        <div class="col-sm-10">
         <input type="text" class="form-control" value="<?php echo $blogsetting_home_title[$language['language_id']]; ?>" name="blogsetting_home_title[<?php echo $language['language_id']; ?>]" />
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_home_page_title; ?></label>
        <div class="col-sm-10">
         <input type="text" class="form-control" value="<?php echo $blogsetting_home_page_title[$language['language_id']]; ?>" name="blogsetting_home_page_title[<?php echo $language['language_id']; ?>]" />
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_home_description; ?></label>
        <div class="col-sm-10">         
         <textarea name="blogsetting_home_description[<?php echo $language['language_id']; ?>]" id="block<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($blogsetting_home_description[$language['language_id']]) ? $blogsetting_home_description[$language['language_id']] : ''; ?></textarea>
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_home_meta_description; ?></label>
        <div class="col-sm-10">         
         <textarea name="blogsetting_home_meta_description[<?php echo $language['language_id']; ?>]" id="block<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($blogsetting_home_meta_description[$language['language_id']]) ? $blogsetting_home_meta_description[$language['language_id']] : ''; ?></textarea>
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_home_meta_keyword; ?></label>
        <div class="col-sm-10">
         <input type="text" class="form-control" value="<?php echo $blogsetting_home_meta_keyword[$language['language_id']]; ?>" name="blogsetting_home_meta_keyword[<?php echo $language['language_id']; ?>]" />
        </div>
        </div>

        <!-- multilingual ends -->
        </div>
        <?php } ?>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_blogsetting_home_url_h; ?>"><?php echo $entry_blogsetting_home_url; ?></span></label>
        <div class="col-sm-10">
        <input name="blog_home_url" class="form-control" value="<?php echo $blog_home_url; ?>" />
        </div>
        </div>
        
        <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10"><legend><h3 style="margin-top:20px;"><?php echo $heading_blog_listing; ?></h3></legend>
        <?php echo $heading_blog_listing_h; ?><br /><br />

        </div>
		
        </div>
       
        <div class="form-group required">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_blogs_per_page; ?></label>
        <div class="col-sm-10">
        <input name="blogsetting_blogs_per_page" class="form-control" value="<?php echo $blogsetting_blogs_per_page; ?>" />
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_layout; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_layout" class="form-control">
		<?php if ($blogsetting_layout == '1') { ?>
		<option value="1" selected="selected">1</option>
        <?php } else { ?>
		<option value="1">1</option>
		<?php } ?>
        <?php if ($blogsetting_layout == '2') { ?>
		<option value="2" selected="selected">2</option>
        <?php } else { ?>
		<option value="2">2</option>
		<?php } ?>
        <?php if ($blogsetting_layout == '3') { ?>
		<option value="3" selected="selected">3</option>
        <?php } else { ?>
		<option value="3">3</option>
		<?php } ?>
        <?php if ($blogsetting_layout == '4') { ?>
		<option value="4" selected="selected">4</option>
        <?php } else { ?>
		<option value="4">4</option>
		<?php } ?>
		</select>
        </div>
        </div>
        
        <div class="form-group required">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_thumb_size; ?></label>
        <div class="col-sm-5">
        <input name="blogsetting_thumbs_w" class="form-control" value="<?php echo $blogsetting_thumbs_w; ?>" />
        </div>
        <div class="col-sm-5">
        <input name="blogsetting_thumbs_h" class="form-control" value="<?php echo $blogsetting_thumbs_h; ?>" />
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_date_added; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_date_added" class="form-control">
		<?php if ($blogsetting_date_added) { ?>
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
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_comments_count; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_comments_count" class="form-control">
		<?php if ($blogsetting_comments_count) { ?>
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
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_page_view; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_page_view" class="form-control">
		<?php if ($blogsetting_page_view) { ?>
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
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_author; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_author" class="form-control">
		<?php if ($blogsetting_author) { ?>
		<option value="1" selected="selected"><?php echo $text_yes; ?></option>
		<option value="0"><?php echo $text_no; ?></option>
		<?php } else { ?>
        <option value="1"><?php echo $text_yes; ?></option>
		<option value="0" selected="selected"><?php echo $text_no; ?></option>
		<?php } ?>
		</select>
        </div>
        </div>
        
        
        
        <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10"><legend><h3 style="margin-top:20px;"><?php echo $heading_blog_post; ?></h3></legend></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_post_date_added; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_post_date_added" class="form-control">
		<?php if ($blogsetting_post_date_added) { ?>
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
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_post_comments_count; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_post_comments_count" class="form-control">
		<?php if ($blogsetting_post_comments_count) { ?>
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
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_post_page_view; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_post_page_view" class="form-control">
		<?php if ($blogsetting_post_page_view) { ?>
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
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_post_author; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_post_author" class="form-control">
		<?php if ($blogsetting_post_author) { ?>
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
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_share; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_share" class="form-control">
		<?php if ($blogsetting_share) { ?>
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
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_post_thumb; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_post_thumb" class="form-control">
		<?php if ($blogsetting_post_thumb) { ?>
		<option value="1" selected="selected"><?php echo $text_yes; ?></option>
		<option value="0"><?php echo $text_no; ?></option>
		<?php } else { ?>
        <option value="1"><?php echo $text_yes; ?></option>
		<option value="0" selected="selected"><?php echo $text_no; ?></option>
		<?php } ?>
		</select>
        </div>
        </div>
        
        <div class="form-group required">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_thumb_size; ?></label>
        <div class="col-sm-5">
        <input name="blogsetting_post_thumbs_w" class="form-control" value="<?php echo $blogsetting_post_thumbs_w; ?>" />
        </div>
        <div class="col-sm-5">
        <input name="blogsetting_post_thumbs_h" class="form-control" value="<?php echo $blogsetting_post_thumbs_h; ?>" />
        </div>
        </div>
        
        
		
        <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10"><legend><h3 style="margin-top:20px;"><?php echo $heading_related; ?></h3></legend></div>
        </div>
		
        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_rel_blog_per_row; ?></label>
        <div class="col-sm-10">        
        <select name="blogsetting_rel_blog_per_row" class="form-control">
		<?php if ($blogsetting_rel_blog_per_row == '1') { ?>
		<option value="1" selected="selected">1</option>
        <?php } else { ?>
		<option value="1">1</option>
		<?php } ?>
        <?php if ($blogsetting_rel_blog_per_row == '2') { ?>
		<option value="2" selected="selected">2</option>
        <?php } else { ?>
		<option value="2">2</option>
		<?php } ?>
        <?php if ($blogsetting_rel_blog_per_row == '3') { ?>
		<option value="3" selected="selected">3</option>
        <?php } else { ?>
		<option value="3">3</option>
		<?php } ?>
		</select>
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_rel_thumb; ?></label>
        <div class="col-sm-10">
        <select name="blogsetting_rel_thumb" class="form-control">
		<?php if ($blogsetting_rel_thumb) { ?>
		<option value="1" selected="selected"><?php echo $text_yes; ?></option>
		<option value="0"><?php echo $text_no; ?></option>
		<?php } else { ?>
        <option value="1"><?php echo $text_yes; ?></option>
		<option value="0" selected="selected"><?php echo $text_no; ?></option>
		<?php } ?>
		</select>
        </div>
        </div>
        
        <div class="form-group required">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_rel_thumbs; ?></label>
        <div class="col-sm-5">
        <input name="blogsetting_rel_thumbs_w" class="form-control" value="<?php echo $blogsetting_rel_thumbs_w; ?>" />
        </div>
        <div class="col-sm-5">
        <input name="blogsetting_rel_thumbs_h" class="form-control" value="<?php echo $blogsetting_rel_thumbs_h; ?>" />
        </div>
        </div>
        
        <div class="form-group required">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_rel_characters; ?></label>
        <div class="col-sm-10">         
        <input name="blogsetting_rel_characters" class="form-control" value="<?php echo $blogsetting_rel_characters; ?>" />
        </div>
        </div>



     	<div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10"><legend><h3 style="margin-top:20px;"><?php echo $heading_comments; ?></h3></legend></div>
        </div>
 
 		<div class="form-group required">
        <label class="col-sm-2 control-label"><?php echo $entry_blogsetting_comment_per_page; ?></label>
        <div class="col-sm-10"> 
        <input name="blogsetting_comment_per_page" class="form-control" value="<?php echo $blogsetting_comment_per_page; ?>" />        
        </div>
        </div>

		<div class="form-group">
        <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_blogsetting_comment_approve_h; ?>"><?php echo $entry_blogsetting_comment_approve; ?></span></label>
        <div class="col-sm-10">
        <select name="blogsetting_comment_approve" class="form-control">
		<?php if ($blogsetting_comment_approve) { ?>
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
        <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_blogsetting_comment_notification_h; ?>"><?php echo $entry_blogsetting_comment_notification; ?></span></label>
        <div class="col-sm-10">
        <select name="blogsetting_comment_notification" class="form-control">
		<?php if ($blogsetting_comment_notification) { ?>
		<option value="1" selected="selected"><?php echo $text_yes; ?></option>
		<option value="0"><?php echo $text_no; ?></option>
		<?php } else { ?>
        <option value="1"><?php echo $text_yes; ?></option>
		<option value="0" selected="selected"><?php echo $text_no; ?></option>
		<?php } ?>
		</select>
        </div>
        </div>
        
        
        
        
        <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10"><legend><h3 style="margin-top:20px;"><?php echo $heading_author; ?></h3></legend></div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_blogsetting_author_change_h; ?>"><?php echo $entry_blogsetting_author_change; ?></span></label>
        <div class="col-sm-10">
        <select name="blogsetting_author_change" class="form-control">
		<?php if ($blogsetting_author_change) { ?>
		<option value="1" selected="selected"><?php echo $text_yes; ?></option>
		<option value="0"><?php echo $text_no; ?></option>
		<?php } else { ?>
        <option value="1"><?php echo $text_yes; ?></option>
		<option value="0" selected="selected"><?php echo $text_no; ?></option>
		<?php } ?>
		</select>
        </div>
        </div>





    </form>
      </div>
    </div>
  </div>
  </div>
 
<script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script>



<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<?php echo $footer; ?>