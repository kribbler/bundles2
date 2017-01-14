<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title> 
<?php if (is_home()) { ?>
<?php bloginfo('description'); ?>
: 
<?php bloginfo('name'); ?>
<?php }  ?>
<?php if (is_page()) { ?>
<?php wp_title(' '); ?>
<?php if(wp_title(' ', false)) { echo ' : '; } ?>
<?php bloginfo('name'); ?>
<?php }  ?>
<?php if (is_404()) { ?>
Page not found : 
<?php bloginfo('name'); ?>
<?php }  ?>
<?php if (is_archive()) { ?>
<?php wp_title(' '); ?>
<?php if(wp_title(' ', false)) { echo ' : '; } ?>
<?php bloginfo('name'); ?>
<?php }  ?>
<?php if(is_search()) { ?>
<?php echo wp_specialchars($s, 1); ?>: 
<?php bloginfo('name'); ?>
<?php } else if (is_single()){ ?>
<?php { 
wp_title(' ');
if(wp_title(' ', false)) { echo ' '; }
single_cat_title();
echo " : "; 
bloginfo('name');
} ?>
<?php } ?>
</title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" /> 

<script src="<?php bloginfo('stylesheet_directory'); ?>/dhtml.js" language="javascript" type="text/javascript"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/slider.js" language="javascript" type="text/javascript"></script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php //comments_popup_script(); // off by default ?>

<?php wp_head(); ?>
</head>

<body>
<div id="main">
	<div class="header">
        <div id="header_bg"><img  src="<?php bloginfo('stylesheet_directory'); ?>/slideshow/header1.jpg" id="Picture" alt="" /></div>
        	
			<?php   //Open images directory
                
                $pth = get_bloginfo('stylesheet_directory')."/slideshow/";
    
                $dirname = pathinfo(__FILE__, PATHINFO_DIRNAME)."/slideshow";
                $dir = @ dir($dirname);
                //List files in images directory
                while (($file = $dir->read()) !== false)
                  {
                      if(substr("$file",-4,4)== ".jpg" || substr("$file",-4,4)== ".gif" || substr("$file",-4,4)== ".png" )
						   {// echo "filename: " . $file . "<br />";
							 $imgStr .= $pth.''.$file.";";  
						   }
                  }
                
                $dir->close();
                
             ?> <script type="text/javascript">
                     RunSlideShow("Picture","header_bg","<?php echo rtrim($imgStr,";"); ?>",6);
               </script>
               
        <div class="contact"><p>Ohio Bluebird Society, PMB 111, 343 W. Milltown Road, Wooster, OH 44691 &nbsp;<img src="<?php bloginfo('stylesheet_directory'); ?>/images/bullet.jpg" alt="" />&nbsp; 330.466.6926 &nbsp;<img src="<?php bloginfo('stylesheet_directory'); ?>/images/bullet.jpg" alt="" />&nbsp; <a href="mailto:info@ohiobluebirdsociety.org">info@ohiobluebirdsociety.org</a></p></div>
    </div><!-- close header -->
		

    <div class="content">
    	<div class="content_bottom">