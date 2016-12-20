<div class="box">
<h3><?php echo $heading_title_category; ?></h3>
<?php if (!empty($categories)) { ?>
<ul class="category_tree">
<?php foreach ($categories as $category_1) { ?>
   <?php if ($category_1['category_1_id'] == $category_1_id) { ?>
     <li class="open active"><a class="dark_bg_color_hover" href="<?php echo $category_1['href']; ?>" ><?php echo $category_1['name']; ?></a>
      <?php } else { ?>
      <li><a class="dark_bg_color_hover" href="<?php echo $category_1['href']; ?>" ><?php echo $category_1['name']; ?></a> 
      <?php } ?>
      <?php if ($category_1['children']) { ?>
      <div class="sign"><span class="plus"><i class="fa fa-plus"></i></span><span class="minus"><i class="fa fa-minus"></i></span></div>
      <ul>
      <?php foreach ($category_1['children'] as $category_2) { ?>
      <li class="active"><a class="dark_bg_color_hover" href="<?php echo $category_2['href']; ?>"><?php echo $category_2['name']; ?></a></li>
      <?php } ?>
      </ul>
      <?php } ?>
    </li>
    <?php } ?>
</ul>
<?php } ?>
</div>
<script>        
	$('.category_tree li').bind().click(function(e) {
	$(this).toggleClass("open").find('>ul').stop(true, true).slideToggle(500)
	.end().siblings().find('>ul').slideUp().parent().removeClass("open");
	e.stopPropagation();
	});
	$('.category_tree li a').click(function(e) {
	e.stopPropagation();
	});
</script>