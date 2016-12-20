<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">

      <div class="table-responsive">
         <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td width="1"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td><?php if ($sort == 'id.title') { ?>
              <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
              <?php } ?></td>
            <td><?php if ($sort == 'i.date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
              <?php } ?></td>
            <td class="text-right"><?php echo $column_comments; ?></td>
            <td class="text-right"><?php echo $column_count_read; ?></td>
			<td class="text-right"><?php if ($sort == 'i.sort_order') { ?>
              <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
              <?php } ?></td>
              <td class="text-right"><?php echo $column_status; ?></td>
            <td width="1"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($blogs) { ?>
          <?php foreach ($blogs as $blog) { ?>
          <tr>
            <td style="text-align: center;"><?php if ($blog['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $blog['blog_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $blog['blog_id']; ?>" />
              <?php } ?></td>
            <td><?php echo $blog['title']; ?></td>
            <td><?php echo $blog['date_added']; ?></td>

            <td class="text-right"><?php echo $blog['comment_total']; ?></td>
            <td class="text-right"><?php echo $blog['count_read']; ?></td>
            <td class="text-right"><?php echo $blog['sort_order']; ?></td>
            <td class="text-right">
            <?php if($blog['status']){ ?>
            <span class="label label-success" style="font-size:100%;"><?php echo $text_enabled; ?></span>
            <?php }else{ ?>
            <span class="label label-danger" style="font-size:100%;"><?php echo $text_disabled; ?></span>
            <?php } ?>
            </td>
            <td class="text-right"><a href="<?php echo $blog['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      </div>
		
    </form>
    <div class="row">
     <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
     <div class="col-sm-6 text-right"><?php echo $results; ?></div>
    </div>
    </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>