<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/dynamic-layout.css" type="text/css" media="screen" />

<?php wp_head(); ?>

</head>
<body>

<header id="header-main">
    <?php $data = get_option('demo_options');//metemos en $data todos los valores de Options Theme ?>
    <div class="top-header">
	   <div class="span-6">
            <div class="top-header-lf">
                <?php // SOCIAL NETWORK ?>
                <?php if ($data['ps_header-net']==1){ 
                    if($data['ps_network']) { ?>
                        <ul class="social-network">
                        <?php foreach ($data['ps_network'] as $red) {
                            echo '<li class="'.$red['ps_social_network_name'].'"><a target="_blank" title="'.$red['ps_social_network_name'].'" href="'.$red['ps_social_network_url'].'">'.$red['ps_social_network_name'].'</a></li>';
                        }?>
                        </ul>
                <?php }
                } ?>
                <?php // IDIOMAS ?>
                <?php if ($data['ps_header_lang']=='header_lang_show'){ ?>
                    <p class="idiomas">Idiomas</p>
                <?php } ?>
            </div><!-- top-header-lf -->
            <div class="top-header-rg">
                <?php // MENU SUPERIOR ?>
                <?php if ($data['ps_menu_top_header']){?>
                    <nav class="menu-top">
                        <ul>
                        <?php foreach ($data['ps_menu_top_header'] as $menu) {
                            echo '<li><a class="positive-icon '.$menu['ps_menu_top_header_icon'].'" title="'.$menu['ps_menu_top_header_name'].'" href="'.$menu['ps_menu_top_header_url'].'">'.$menu['ps_menu_top_header_name'].'</a></li>';
                        }?>
                        </ul>
                    </nav>
                <?php } ?>
                <?php // Searchform ?>
                <?php get_search_form(); ?>
            </div><!-- top-header-rg -->
        </div><!-- .span-6 -->
    </div><!-- .top-header -->
    <div class="span-6">
        <?php // LOGO ?>
        <?php if( is_home() ){ ?>
            <h1 id="logo">
                <?php if ($data['ps_header_logo']) echo'<img src="'. $data['ps_header_logo']['src'].'">'; ?>
                <span><?php bloginfo('name');?></span>
            </h1>
        <?php } else { ?>
            <div id="logo"><a href="<?php echo get_option('home'); ?>">
               <?php if ($data['ps_header_logo']) echo'<img src="'. $data['ps_header_logo']['src'].'">'; ?>
                <span><?php bloginfo('name');?></span>
            </a></div>
        <?php } ?>
        <?php wp_nav_menu( array('header-menu' => 'Header Menu', 'container' => 'nav', 'container_id' => 'menu-main', )); ?>
    </div><!-- .span-6 -->
</header>