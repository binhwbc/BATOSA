<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      <button type="submit" form="form-comment" formaction="<?php echo $enable; ?>" data-toggle="tooltip" title="<?php echo $text_enable; ?>" class="btn btn-success"><i class="fa fa-check"></i></button>
      <button type="submit" form="form-comment" formaction="<?php echo $disable; ?>" data-toggle="tooltip" title="<?php echo $text_disable; ?>" class="btn btn-warning"><i class="fa  fa-ban"></i></button>
      <button onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-comment').submit() : false;" form="form-comment" formaction="<?php echo $delete; ?>" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-comment">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
     		<thead>
     		<tr>
            <td width="1"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td width="50%"><?php echo $column_comment; ?></td>
            <td><?php echo $column_post; ?></td>
            <td><?php echo $column_name; ?></td>
            <td class="text-right"><?php echo $column_date; ?></td>
            <td class="text-right"><?php echo $column_status; ?></td>
          </tr>
     		</thead>
     		<tbody>
     		<?php if ($blog_comments) { ?>
     		<?php foreach ($blog_comments as $blog_comment) { ?>
     		<tr>
            <td>
            <input type="checkbox" name="selected[]" value="<?php echo $blog_comment['blog_comment_id'];?>">
            </td>
            <td><?php echo $blog_comment['comment']; ?></td>
             <td class="left"><?php echo $blog_comment['title']; ?></td>
            <td><?php echo $blog_comment['name']; ?><br />(<?php echo $blog_comment['email']; ?>)</td>
            <td class="text-right"><?php echo $blog_comment['date_added']; ?></td>
            <td class="text-right">
            <?php if($blog_comment['status']){ ?>
            <span class="label label-success" style="font-size:100%;"><?php echo $text_enabled; ?></span>
            <?php }else{ ?>
            <span class="label label-danger" style="font-size:100%;"><?php echo $text_disabled; ?></span>
            <?php } ?>
            </tr>
     		<?php } ?>
     		<?php }else{ ?>
     		<tr>
            <td class="text-center" colspan="8"><?php echo $text_no_result; ?></td>
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