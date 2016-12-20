 
<?php if ($type == 'list' ) { ?>
  
 <div id="navbar-collapse-<?php echo $code; ?>" class="mobileCategory">
      <ul class="nav navbar-nav">
        <?php foreach ($menus as $menu1) { ?> 
        <li>
          <div class="iMenu">
              <a href="<?php echo $menu1['url']; ?>" <?php if($menu1['window']){ ?>target="<?php echo $menu1['window']; ?>"<?php } ?>><?php if($menu1['image']){ ?><img src="<?php echo $menu1['thumb']; ?>" class="img-thumbnail" /><?php } ?>   </a>
           </div>
          <div class="mMenu">
            <a href="<?php echo $menu1['url']; ?>" <?php if($menu1['window']){ ?>target="<?php echo $menu1['window']; ?>"<?php } ?>>
              <?php if($menu1['font']){ ?><i class="fa <?php echo $menu1['font']; ?>"></i><?php } ?>
              <?php echo $menu1['title']; ?> </a>
           </div>
           
         
        </li>
        <?php } ?>
 
      </ul>
    </div>

<?php } elseif ($type=='vertical') {?>
  <div id="smoothmenu_v<?php echo $code; ?>" class="ddsmoothmenu-v">
   <ul>
        <?php foreach ($menus as $menu1) { ?>
        <?php if (isset($menu1['children'])) { ?>
        <?php if($menu1['style']=='' || $menu1['style']=='dropdown'){ ?>
        <li class="level1">
          <a href="#" data-toggle="dropdown" class="<?php echo $menu1['class']; ?>" aria-expanded="false"><?php echo $menu1['title']; ?> <b class="caret"></b>
            <?php if($menu1['image']){ ?><div class="menu-image"><img src="<?php echo $menu1['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
          </a>
          
          <ul role="menu"  class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
            <?php foreach ($menu1['children'] as $menu2) { ?>
            <?php if(isset($menu2['children'])){ ?>
            <li class="level2">
              <a href="<?php echo $menu2['url']; ?>" class="<?php echo $menu2['class']; ?>" aria-expanded="false">
                <?php if($menu2['font']){ ?><i class="fa <?php echo $menu2['font']; ?>"></i><?php } ?>        
                <?php echo $menu2['title']; ?>
                <?php if($menu2['image']){ ?><div class="menu-image"><img src="<?php echo $menu2['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
              </a>
              <ul role="menu" class="dropdown-menu">
              <?php foreach ($menu2['children'] as $menu3) { ?>
              <?php if(isset($menu3['children'])){ ?>
              <li class="level3">
                <a href="<?php echo $menu3['url']; ?>" class="<?php echo $menu3['class']; ?>">
                  <?php if($menu3['font']){ ?><i class="fa <?php echo $menu3['font']; ?>"></i><?php } ?>        
                  <?php echo $menu3['title']; ?>
                  <?php if($menu3['image']){ ?><div class="menu-image"><img src="<?php echo $menu3['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
                </a>
                <ul class="dropdown-menu">
                <?php foreach ($menu3['children'] as $menu4) { ?>
                  <?php if(isset($menu4['children'])){ ?>
                    <li class="level4">
                    <a href="<?php echo $menu4['url']; ?>" class="<?php echo $menu4['class']; ?>">
                      <?php if($menu4['font']){ ?><i class="fa <?php echo $menu4['font']; ?>"></i><?php } ?>
                      <?php echo $menu4['title']; ?>
                      <?php if($menu4['image']){ ?><div class="menu-image"><img src="<?php echo $menu4['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
                    </a>
                    <ul role="menu" class="dropdown-menu">
                    <?php foreach ($menu4['children'] as $menu5) { ?>
                      <?php if(isset($menu5['children'])){ ?>

                      <?php } else{ ?>
                         <li class="level4">
                            <a href="<?php echo $menu5['url']; ?>" class="<?php echo $menu5['class']; ?>">
                            <?php if($menu5['font']){ ?><i class="fa <?php echo $menu5['font']; ?>"></i><?php } ?>
                              <?php echo $menu5['title']; ?>
                              <?php if($menu5['image']){ ?><div class="menu-image"><img src="<?php echo $menu5['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
                            </a>
                          </li>
                      <?php } ?>
                    <?php } ?>
                    </ul>
                    </li>
                  <?php }else{ ?>
                  <li class="level4">
                    <a href="<?php echo $menu4['url']; ?>" class="<?php echo $menu4['class']; ?>">
            <?php if($menu4['font']){ ?><i class="fa <?php echo $menu4['font']; ?>"></i><?php } ?>
                      <?php echo $menu4['title']; ?>
                      <?php if($menu4['image']){ ?><div class="menu-image"><img src="<?php echo $menu4['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
                    </a>
                  </li>
                  <?php } ?>                
                <?php } ?>
                </ul>
              </li>
              <?php }else{ ?>
              <li class="level3">
                <a href="<?php echo $menu3['url']; ?>" class="<?php echo $menu3['class']; ?>">
                  <?php if($menu3['font']){ ?><i class="fa <?php echo $menu3['font']; ?>"></i><?php } ?>        
                  <?php echo $menu3['title']; ?>
                  <?php if($menu3['image']){ ?><div class="menu-image"><img src="<?php echo $menu3['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
                </a>
              </li>
              <?php } ?>
              <?php } ?>
              </ul>
            </li>
            <?php }else{ ?>
            <li class="level2">
              <a href="<?php echo $menu2['url']; ?>" class="<?php echo $menu2['class']; ?>">
                <?php if($menu2['font']){ ?><i class="fa <?php echo $menu2['font']; ?>"></i><?php } ?>        
                <?php echo $menu2['title']; ?>
                <?php if($menu3['image']){ ?><div class="menu-image"><img src="<?php echo $menu3['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
              </a>
            </li>
            <?php } ?>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
          
        <?php } else { ?>
        <li class="level1">
          <a href="<?php echo $menu1['url']; ?>" class="<?php echo $menu1['class']; ?>">
      <?php if($menu1['font']){ ?><i class="fa <?php echo $menu1['font']; ?>"></i><?php } ?>
          <?php echo $menu1['title']; ?>
          <?php if($menu1['image']){ ?><div class="menu-image"><img src="<?php echo $menu1['thumb']; ?>" class="img-thumbnail" /></div><?php } ?> 
          </a>
        </li>
        <?php } ?>

        <?php } ?>
      </ul>
</div>
<script>
ddsmoothmenu.init({
    mainmenuid: "smoothmenu_v<?php echo $code; ?>", //Menu DIV id
    orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
    classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
    method: 'hover', // set to 'hover' (default) or 'toggle'
    arrowswap: true, // enable rollover effect on menu arrow images?
    //customtheme: ["#804000", "#482400"],
    contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>

<?php } else { ?>

<div id="smoothmenu_h<?php echo $code; ?>" class="ddsmoothmenu">
   <ul>
        <?php foreach ($menus as $menu1) { ?>
        <?php if (isset($menu1['children'])) { ?>
        <?php if($menu1['style']=='' || $menu1['style']=='dropdown'){ ?>
        <li class="level1">
          <a href="#" data-toggle="dropdown" class="<?php echo $menu1['class']; ?>" aria-expanded="false"><?php echo $menu1['title']; ?> <b class="caret"></b>
            <?php if($menu1['image']){ ?><div class="menu-image"><img src="<?php echo $menu1['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
          </a>
          
          <ul role="menu"  class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
            <?php foreach ($menu1['children'] as $menu2) { ?>
            <?php if(isset($menu2['children'])){ ?>
            <li class="level2">
              <a href="<?php echo $menu2['url']; ?>" class="<?php echo $menu2['class']; ?>" aria-expanded="false">
                <?php if($menu2['font']){ ?><i class="fa <?php echo $menu2['font']; ?>"></i><?php } ?>        
                <?php echo $menu2['title']; ?>
                <?php if($menu2['image']){ ?><div class="menu-image"><img src="<?php echo $menu2['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
              </a>
              <ul role="menu" class="dropdown-menu">
              <?php foreach ($menu2['children'] as $menu3) { ?>
              <?php if(isset($menu3['children'])){ ?>
              <li class="level3">
                <a href="<?php echo $menu3['url']; ?>" class="<?php echo $menu3['class']; ?>">
                  <?php if($menu3['font']){ ?><i class="fa <?php echo $menu3['font']; ?>"></i><?php } ?>        
                  <?php echo $menu3['title']; ?>
                  <?php if($menu3['image']){ ?><div class="menu-image"><img src="<?php echo $menu3['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
                </a>
                <ul class="dropdown-menu">
                <?php foreach ($menu3['children'] as $menu4) { ?>
                  <?php if(isset($menu4['children'])){ ?>
                    <li class="level4">
                    <a href="<?php echo $menu4['url']; ?>" class="<?php echo $menu4['class']; ?>">
                      <?php if($menu4['font']){ ?><i class="fa <?php echo $menu4['font']; ?>"></i><?php } ?>
                      <?php echo $menu4['title']; ?>
                      <?php if($menu4['image']){ ?><div class="menu-image"><img src="<?php echo $menu4['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
                    </a>
                    <ul role="menu" class="dropdown-menu">
                    <?php foreach ($menu4['children'] as $menu5) { ?>
                      <?php if(isset($menu5['children'])){ ?>

                      <?php } else{ ?>
                         <li class="level4">
                            <a href="<?php echo $menu5['url']; ?>" class="<?php echo $menu5['class']; ?>">
                            <?php if($menu5['font']){ ?><i class="fa <?php echo $menu5['font']; ?>"></i><?php } ?>
                              <?php echo $menu5['title']; ?>
                              <?php if($menu5['image']){ ?><div class="menu-image"><img src="<?php echo $menu5['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
                            </a>
                          </li>
                      <?php } ?>
                    <?php } ?>
                    </ul>
                    </li>
                  <?php }else{ ?>
                  <li class="level4">
                    <a href="<?php echo $menu4['url']; ?>" class="<?php echo $menu4['class']; ?>">
            <?php if($menu4['font']){ ?><i class="fa <?php echo $menu4['font']; ?>"></i><?php } ?>
                      <?php echo $menu4['title']; ?>
                      <?php if($menu4['image']){ ?><div class="menu-image"><img src="<?php echo $menu4['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
                    </a>
                  </li>
                  <?php } ?>                
                <?php } ?>
                </ul>
              </li>
              <?php }else{ ?>
              <li class="level3">
                <a href="<?php echo $menu3['url']; ?>" class="<?php echo $menu3['class']; ?>">
                  <?php if($menu3['font']){ ?><i class="fa <?php echo $menu3['font']; ?>"></i><?php } ?>        
                  <?php echo $menu3['title']; ?>
                  <?php if($menu3['image']){ ?><div class="menu-image"><img src="<?php echo $menu3['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
                </a>
              </li>
              <?php } ?>
              <?php } ?>
              </ul>
            </li>
            <?php }else{ ?>
            <li class="level2">
              <a href="<?php echo $menu2['url']; ?>" class="<?php echo $menu2['class']; ?>">
                <?php if($menu2['font']){ ?><i class="fa <?php echo $menu2['font']; ?>"></i><?php } ?>        
                <?php echo $menu2['title']; ?>
                <?php if($menu3['image']){ ?><div class="menu-image"><img src="<?php echo $menu3['thumb']; ?>" class="img-thumbnail" /></div><?php } ?>
              </a>
            </li>
            <?php } ?>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
          
        <?php } else { ?>
        <li class="level1">
          <a href="<?php echo $menu1['url']; ?>" class="<?php echo $menu1['class']; ?>">
      <?php if($menu1['font']){ ?><i class="fa <?php echo $menu1['font']; ?>"></i><?php } ?>
          <?php echo $menu1['title']; ?>
          <?php if($menu1['image']){ ?><div class="menu-image"><img src="<?php echo $menu1['thumb']; ?>" class="img-thumbnail" /></div><?php } ?> 
          </a>
        </li>
        <?php } ?>

        <?php } ?>
      </ul>

</div>
<script> 


ddsmoothmenu.init({
  mainmenuid: "smoothmenu_h<?php echo $code; ?>", //menu DIV id
  orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
  classname: 'ddsmoothmenu', //class added to menu's outer DIV
  //customtheme: ["#1c5a80", "#18374a"],
  contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>

 <?php } ?>
  