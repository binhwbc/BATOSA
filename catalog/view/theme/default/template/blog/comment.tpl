<?php if ($comments) { ?>
<?php foreach ($comments as $comment) { ?>
<div class="blog_comment">
<div class="left">
<i class="fa fa-user"></i>
</div>
<div class="right">
<p class="author"><b><?php echo $comment['name']; ?></b> - <span class="date"><?php echo $comment['date_added']; ?></span></p>
<p><?php echo $comment['comment']; ?></p>
</div>
</div>
<?php } ?>
    <?php if ($pagination) { ?>
    <div class="bottom_buttons comment_pagination text-right"><?php echo $pagination; ?></div>
    <?php } ?>
<?php } else { ?>
<div class="padded">
<p><?php echo $text_no_comment; ?></p>
</div>
<?php } ?>
