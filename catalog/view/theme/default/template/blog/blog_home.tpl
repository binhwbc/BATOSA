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
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
        <?php if ($description) { ?>
        <div class="margin-b"><?php echo $description; ?></div>
        <?php } ?>
      
    <?php if($blogs){ ?>
		<div class="bordered_content box">
        <div class="bottom_buttons pagination_holder top">
    <div class="row">
    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
    </div>
  </div>
        <div class="grid_holder grid<?php echo $list_columns; ?>">
		<div class="product-grid latest_blogs <?php if ($list_columns > 1) { echo 'eq_height'; } ?>">	
            <?php foreach ($blogs as $blog) { ?>
				<div class="item blog_post">
                <?php if($blog['image']){ ?>
                <div class="image zoom_image_container">
				<a href="<?php echo $blog['href']; ?>"><img src="<?php echo $blog['image']; ?>" class="zoom_image" alt="<?php echo $blog['title']; ?>" title="<?php echo $blog['title']; ?>" /></a>
                </div>
				<?php } ?>
                <div class="information_wrapper">
                <h3><a href="<?php echo $blog['href']; ?>"><?php echo $blog['title']; ?></a></h3>
                
                <div class="blog_stats">
                
                <?php if($date_added_status){ ?>
				<span><i class="icon-calendar"></i> <?php echo $blog['date_added_full'];?></span>
                <?php } ?>
                
                <?php if($comments_count_status){ ?>
                <span><a href="<?php echo $blog['href'];?>" title="<?php echo $blog['title'];?>"><i class="icon-comment"></i> <?php echo $blog['comment_total'];?></a></span>
				<?php } ?>

                <?php if($author_status){ ?>
                <span><i class="fa fa-user"></i> <?php echo $text_posted_by; ?> <?php echo $blog['author']; ?></span>
                <?php } ?>
                
				<?php if($page_view_status){ ?>
                <span><i class="fa fa-eye"></i> <?php echo $text_read; ?> <?php echo $blog['count_read']; ?></span>
                <?php } ?>
                
                </div> <!-- blog-stats ends -->
                
                <p><?php echo $blog['short_description']; ?></p>
                <p><a href="<?php echo $blog['href']; ?>" class="btn btn-default"><?php echo $text_read_more; ?></a></p>
                
                </div>
               
              </div> <!-- item ends -->

			<?php } ?>
            </div>
            </div>
            <div class="bottom_buttons pagination_holder">
    <div class="row">
    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
    </div>
  </div>
          </div>
		
	<?php }else{ ?>
		<p class="box"><?php echo $text_no_results; ?></p>
	<?php } ?>
    
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?> 