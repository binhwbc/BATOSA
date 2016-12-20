<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-category').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_list; ?></h3>
      </div>
      <div class="panel-body">
      
  
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-category">
        <div class="table-responsive">
         <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td width="1"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
              <td><?php echo $column_name; ?></td>
              <td class="text-right"><?php echo $column_sort_order; ?></td>
              <td class="text-right"><?php echo $column_status; ?></td>
              <td width="1"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($blog_categories) { ?>
            <?php foreach ($blog_categories as $blog_category) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($blog_category['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $blog_category['blog_category_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $blog_category['blog_category_id']; ?>" />
                <?php } ?></td>
              <td><?php echo $blog_category['name']; ?></td>
              <td class="text-right"><?php echo $blog_category['sort_order']; ?></td>
              <td class="text-right">
              <?php if($blog_category['status']){ ?>
            <span class="label label-success" style="font-size:100%;"><?php echo $text_enabled; ?></span>
            <?php }else{ ?>
            <span class="label label-danger" style="font-size:100%;"><?php echo $text_disabled; ?></span>
            <?php } ?>
            </td>
              <td class="text-right">
                <a href="<?php echo $blog_category['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>