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

                <div class="form-group required">
                    <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="blog_category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($blog_category_description[$language['language_id']]) ? $blog_category_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
                      <?php if (isset($error_name[$language['language_id']])) { ?>
                  		<span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                  		<?php } ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_page_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="blog_category_description[<?php echo $language['language_id']; ?>][page_title]" value="<?php echo isset($blog_category_description[$language['language_id']]) ? $blog_category_description[$language['language_id']]['page_title'] : ''; ?>" placeholder="<?php echo $entry_page_title; ?>" class="form-control" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                     <textarea name="blog_category_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($blog_category_description[$language['language_id']]) ? $blog_category_description[$language['language_id']]['description'] : ''; ?></textarea>
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_meta_description; ?></label>
                    <div class="col-sm-10">
                     <textarea name="blog_category_description[<?php echo $language['language_id']; ?>][meta_description]" class="form-control"><?php echo isset($blog_category_description[$language['language_id']]) ? $blog_category_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_meta_keyword; ?></label>
                    <div class="col-sm-10">
                     <input type="text" name="blog_category_description[<?php echo $language['language_id']; ?>][meta_keywords]" value="<?php echo isset($blog_category_description[$language['language_id']]) ? $blog_category_description[$language['language_id']]['meta_keywords'] : ''; ?>" placeholder="<?php echo $entry_meta_keyword; ?>" class="form-control" />
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
                  <input type="text" name="keyword" value="<?php echo $keyword; ?>" class="form-control"/>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control" />
                </div>
              </div>


                <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
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

            </div> <!-- tab-data ends -->

            <div class="tab-pane" id="tab-links">

             <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_parent; ?></label>
                <div class="col-sm-10">
                <select name="parent_id" class="form-control">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($blog_categories as $blog_category) { ?>
                  <?php if ($blog_category['blog_category_id'] == $parent_id) { ?>
                  <option value="<?php echo $blog_category['blog_category_id']; ?>" selected="selected"><?php echo $blog_category['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $blog_category['blog_category_id']; ?>"><?php echo $blog_category['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $blog_category_store)) { ?>
                        <input type="checkbox" name="blog_category_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="blog_category_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $blog_category_store)) { ?>
                        <input type="checkbox" name="blog_category_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="blog_category_store[]" value="<?php echo $store['store_id']; ?>" />
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
                      <td class="text-left"><select name="blog_category_layout[0][layout_id]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($blog_category_layout[0]) && $blog_category_layout[0] == $layout['layout_id']) { ?>
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
                      <td class="text-left"><select name="blog_category_layout[<?php echo $store['store_id']; ?>][layout_id]" class="form-control">
                      <option value=""></option>
                      <?php foreach ($layouts as $layout) { ?>
                      <?php if (isset($blog_category_layout[$store['store_id']]) && $blog_category_layout[$store['store_id']] == $layout['layout_id']) { ?>
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

  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<?php echo $footer; ?>
