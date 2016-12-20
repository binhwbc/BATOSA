<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-blog_latest" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-blog_latest" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_columns; ?></label>
            <div class="col-sm-10">
            <select name="columns" id="input-columns" class="form-control">
            <?php if ($columns == '4') { ?>
            <option value="4" selected="selected"><?php echo $text_4; ?></option>
            <?php } else { ?>
            <option value="4"><?php echo $text_4; ?></option>
            <?php } ?>
            <?php if ($columns == '3') { ?>
            <option value="3" selected="selected"><?php echo $text_3; ?></option>
            <?php } else { ?>
            <option value="3"><?php echo $text_3; ?></option>
            <?php } ?>
            <?php if ($columns == '2') { ?>
            <option value="2" selected="selected"><?php echo $text_2; ?></option>
            <?php } else { ?>
            <option value="2"><?php echo $text_2; ?></option>
            <?php } ?>
            <?php if ($columns == '1') { ?>
            <option value="1" selected="selected"><?php echo $text_1; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_1; ?></option>
            <?php } ?>
            <?php if ($columns == '1 list') { ?>
            <option value="1 list" selected="selected"><?php echo $text_1_list; ?></option>
            <?php } else { ?>
            <option value="1 list"><?php echo $text_1_list; ?></option>
            <?php } ?>
             </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_carousel; ?></label>
            <div class="col-sm-10">
             <select name="carousel" id="input-carousel" class="form-control">
                <?php if ($carousel) { ?>
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
            <label class="col-sm-2 control-label" for="input-width">
            <span data-toggle="tooltip" title="<?php echo $entry_characters_h; ?>"><?php echo $entry_characters; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="characters" value="<?php echo $characters; ?>" placeholder="<?php echo $entry_characters; ?>" id="input-limit" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_thumb; ?></label>
            <div class="col-sm-10">
              <select name="thumb" id="input-status" class="form-control">
                <?php if ($thumb) { ?>
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
            <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_thumb_size; ?></label>
            <div class="col-sm-5">
            <input type="text" name="width" value="<?php echo $width; ?>" id="input-width" class="form-control" />
            </div>
            <div class="col-sm-5">
            <input type="text" name="height" value="<?php echo $height; ?>" id="input-height" class="form-control" />
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
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>