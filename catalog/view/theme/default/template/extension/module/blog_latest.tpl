<div class="box">
<h3><?php echo $heading_title_latest; ?></h3>
<div class="bordered_content">
<?php if(!empty($posts)){ ?>
<div class="grid_holder grid<?php echo $columns; ?>">
<div class="product-grid latest_blogs m<?php echo $module; ?> <?php if ($carousel) { ?>carousel<?php } ?>">
    <?php foreach ($posts as $blog) { ?>
    <div class="item blog_post">
        <?php if($blog['image'] && $thumb){ ?>
        <div class="image zoom_image_container">
        <a href="<?php echo $blog['href']; ?>"><img src="<?php echo $blog['image']; ?>" class="zoom_image" alt="<?php echo $blog['title']; ?>" title="<?php echo $blog['title']; ?>" /></a>
        </div>
        <?php } ?>
        <h4><a href="<?php echo $blog['href']; ?>"><?php echo $blog['title']; ?></a></h4>
        <div class="blog_stats">
        <?php if($date_added_status){ ?>
        <span><i class="icon-calendar"></i> <?php echo $blog['date_added_full'];?></span>
        <?php } ?>
        <?php if($comments_count_status){ ?>
        <span><a href="<?php echo $blog['href'];?>" title="<?php echo $blog['title'];?>"><i class="icon-comment"></i> <?php echo $blog['comment_total'];?></a></span>
        <?php } ?>
        </div> <!-- blog_stats ends -->
        <?php if(!$characters == '0'){ ?>
        <p><?php echo $blog['description']; ?></p>
        <?php } ?>
      </div>
    <?php } ?>
</div>
</div>
<?php } ?>
</div>
</div>
<?php if($carousel) { ?>
<script type="text/javascript">
$(document).ready(function() {
$('.product-grid.m<?php echo $module; ?>.carousel').owlCarousel({
itemsCustom: [ [0, 1], [500, 2], [767, <?php echo $columns;?>]],
pagination: false,
navigation:true,
navigationText: [
"<div class='slide_arrow_prev'><i class='fa fa-angle-left'></i></div>",
"<div class='slide_arrow_next'><i class='fa fa-angle-right'></i></div>"],
slideSpeed:500,
afterAction: function(){
       this.$owlItems.removeClass('first');
       this.$owlItems.eq(this.currentItem).addClass('first');
     }
}); });
</script>
<?php } ?>