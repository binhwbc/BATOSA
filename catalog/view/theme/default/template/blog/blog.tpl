<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row">
  
  <?php echo $column_left; ?>
    
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-md-9 col-sm-8'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
    <?php echo $content_top; ?>
    <div class="blog_post">
    
    <h1><?php echo $heading_title; ?></h1>
	
   <div class="bordered_content box">
   <div class="padded main">
    
    <div class="blog_stats">
    <?php if($post_date_added_status){ ?>
    <span><i class="icon-calendar"></i> <?php echo $date_added; ?></span>
    <?php } ?>
    <?php if($post_comments_count_status){ ?>
    <span><i class="icon-comment"></i> <?php echo $comment_total;?></span>
    <?php } ?>
	<?php if($post_author_status){ ?>
    <span><i class="fa fa-user"></i> <?php echo $text_posted_by; ?> <?php echo $author; ?></span>
    <?php } ?>
	<?php if($post_page_view_status){ ?>
    <span><i class="fa fa-eye"></i> <?php echo $text_read; ?> <?php echo $new_read_counter_value; ?></span>
    <?php } ?>
    </div>
    
    <?php if($main_thumb && $blogsetting_post_thumb){ ?>
    <div class="image">
    <img src="<?php echo $blogsetting_post_thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" />
    </div>
    <?php } ?>
    
    
   <div class="description">
   <?php echo $description; ?>
   </div>
   
   <div class="share_this">
   <span class="text"><?php echo $text_share_this;?></span>
    <!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
    <a class="addthis_button_preferred_1"></a>
    <a class="addthis_button_preferred_2"></a>
    <a class="addthis_button_preferred_3"></a>
    <a class="addthis_button_preferred_4"></a>
    <a class="addthis_button_compact"></a>
    </div>
    <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js"></script>
    </div> <!-- share_this END -->
    
    </div>
    
    <?php if ($tags) { ?>
	<div class="bottom_buttons">
    <span class="tag_text"><?php echo $text_tags; ?></span>
	<?php for ($i = 0; $i < count($tags); $i++) { ?>
	<?php if ($i < (count($tags) - 1)) { ?>
	<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>, 
	<?php } else { ?>
	<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
	<?php } ?>
	<?php } ?>
	</div>
	<?php } ?>

  </div>

    <?php if ($related_blogs) { ?>
		<h3><?php echo $text_related_blog; ?></h3>
		<div class="bordered_content box">
        <div class="grid_holder grid<?php echo $rel_per_row; ?> list">
		<div class="product-grid latest_blogs <?php if ($rel_per_row > 1) { echo 'eq_height'; } ?>">
            <?php foreach ($related_blogs as $blog) { ?>
				<div class="item blog_post">
                <?php if(($blog['image']) && ($rel_thumb_status)){ ?>
                <div class="image zoom_image_container">
				<a href="<?php echo $blog['href']; ?>"><img src="<?php echo $blog['image']; ?>" class="zoom_image" alt="<?php echo $blog['title']; ?>" title="<?php echo $blog['title']; ?>" /></a>
                </div>
				<?php } ?>
                <div class="information_wrapper">
                <h4><a href="<?php echo $blog['href']; ?>"><?php echo $blog['title']; ?></a></h4>
                <div class="blog_stats">
                <?php if($date_added_status){ ?>
				<span><i class="icon-calendar"></i> <?php echo $blog['date_added_full'];?></span>
                <?php } ?>
                <?php if($comments_count_status){ ?>
                <span><a href="<?php echo $blog['href'];?>" title="<?php echo $blog['title'];?>"><i class="icon-comment"></i> <?php echo $blog['comment_total'];?></a></span>
				<?php } ?>
                </div> <!-- blog-stats ends -->
                </div>
              </div> <!-- item ends -->
			<?php } ?>
           </div>
           </div>
          </div>
	<?php } ?>
	 <!-- Related Blog End -->
	 
     <!-- Comment Area start -->
     <?php if($allow_comment){ ?>
     <h3><?php echo $text_comments; ?></h3>
     <div class="bordered_content box">
     <div id="comment"></div>
     </div>
     <?php } ?>
     
     <!-- Write Comment Area start -->
  		<?php if($allow_comment){ ?>
        <h3><?php echo $text_write_comment; ?></h3>
              
              <div class="bordered_content padded box">
              <div id="comment_message"></div>
              <form id="comment_form">
                <div class="row">
				<div class="form-group col-sm-6 required">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="name" value="" id="input-name" class="form-control" />
                </div>
                <div class="form-group col-sm-6 required">
                <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" name="email" value="" id="input-email" class="form-control" />
                </div>
                </div>
                
                <div class="row">
                <div class="form-group col-sm-12 required">
                <label class="control-label" for="input-review"><?php echo $entry_comment; ?></label>
                <textarea name="comment" rows="5" id="input-comment" class="form-control"></textarea>
                </div>
                </div>
                
                <div class="row">
                <div class="col-sm-12">
                  <div class="form-group required">
                  <label class="control-label" for="input-captcha_comment"><?php echo $entry_captcha; ?></label>
                    <div class="input-group">
                    <span class="input-group-addon captcha_wrap"><img src="index.php?route=blog/blog/captcha" alt="" id="captcha_comment" /></span>
                    <input type="text" name="captcha_comment" value="" id="input-captcha_comment" class="form-control" />
                    </div>
                  </div>
                </div>
                </div>
    
				<div class="row">
               
                <div class="form-group col-sm-12 text-right">
                <a id="button-comment" class="btn btn-primary"><?php echo $button_send; ?></a>
                </div>
                </div>
				</form>
              </div>
      <?php } ?>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--

$('#comment').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();
	$("html,body").animate({scrollTop:(($("#comment").offset().top)-50)},500);
    $('#comment').fadeOut(50);

    $('#comment').load(this.href);

    $('#comment').fadeIn(500);
	
});

$('#comment').load('index.php?route=blog/blog/comment&blog_id=<?php echo $blog_id; ?>');
//--></script>

<script type="text/javascript"><!--

$('#button-comment').on('click', function() {
	$.ajax({
		url: 'index.php?route=blog/blog/write&blog_id=<?php echo $blog_id; ?>',
		type: 'post',
		dataType: 'json',

		data: $("#comment_form").serialize(),
		
		complete: function() {
			$('#button-comment').button('reset');
			$('input[name=\'captcha_comment\']').val('');
			$('#captcha_comment').attr('src', 'index.php?route=blog/blog/captcha#'+new Date().getTime());
			//$('#captcha').attr('src', 'index.php?route=tool/captcha#'+new Date().getTime());
			//$('input[name=\'captcha\']').val('');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();
			
			if (json['error']) {
				$('#comment_message').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
			
			if (json['success']) {
				$('#comment_message').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
				
				$('input[name=\'name\']').val('');
				$('input[name=\'email\']').val('');
				$('textarea[name=\'comment\']').val('');
				//$('input[name=\'captcha\']').val('');
			}
		}
	});
});     
</script>
<?php echo $footer; ?> 