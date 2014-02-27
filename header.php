<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<?php wp_head(); ?>

</head>
<body>

<div id="header">
	<div class="wrapper">
        <?php if( is_home() ){ ?>
            <h1 id="logo"><?php bloginfo('name'); ?></h1>
        <?php } else { ?>
            <div id="logo"><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></div>
        <?php } ?>
         	
        <?php wp_nav_menu( array('menu' => 'Menu principal' )); ?>
    </div>
</div>