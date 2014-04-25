<?php global $theme_data; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/dynamic-layout.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/responsive.css" type="text/css" media="screen" />

<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<header id="header-main">
    <div class="top-header">
	   <div class="span-6">
            <div class="top-header-lf">
                <?php // SOCIAL NETWORK
                if($theme_data['ps_header-net']==1) positive_social_buttons();?>
            </div><!-- top-header-lf -->
            <div class="top-header-rg">
                <a class="join" href="<?php echo get_permalink(285); ?>"><?php _e('&Uacute;nete a nosotros', 'positive')?></a>
                <?php // IDIOMAS
                if($theme_data['ps_header_lang']==1 && function_exists("transposh_widget")) {
                    the_widget('transposh_plugin_widget', 
                        array(
                            'title' => __('Languages','positive'), 
                            'widget_file' => 'geckocode/tpw_geckocode.php'
                        ), 
                        array(
                            'before_widget' => '<nav class="languages">',
                            'after_widget' => '</nav>',
                            'before_title' => '<p class="positive-icon positive-icon-right i-flag">',
                            'after_title' => '</p>'
                        )
                    );
                } ?>
                <?php // MENU SUPERIOR ?>
                <?php if ($theme_data['ps_menu_top_header']){?>
                    <nav class="menu-top">
                        <ul>
                        <?php foreach ($theme_data['ps_menu_top_header'] as $menu) {
                            $link = ( $menu['ps_menu_top_header_page'] ? 
                                get_permalink($menu['ps_menu_top_header_page']) : 
                                $menu['ps_menu_top_header_url'] );

                            if($link) echo '<li><a class="positive-icon '.$menu['ps_menu_top_header_icon'].'" title="'.$menu['ps_menu_top_header_name'].'" href="'.$link.'">'.$menu['ps_menu_top_header_name'].'</a></li>';
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
        <?php if(is_front_page() || (get_option('show_on_front') =='posts' && is_home()) ){ ?>
            <h1 id="logo">
                <?php if ($theme_data['ps_header_logo']) echo'<img src="'. $theme_data['ps_header_logo']['src'].'">'; ?>
                <span><?php bloginfo('name');?></span>
            </h1>
        <?php } else { ?>
            <div id="logo"><a href="<?php echo get_option('home'); ?>">
               <?php if ($theme_data['ps_header_logo']) echo'<img src="'. $theme_data['ps_header_logo']['src'].'">'; ?>
                <span><?php bloginfo('name');?></span>
            </a></div>
        <?php } ?>
        <?php wp_nav_menu( array('theme_location'=>'header-menu', 'container' => 'nav', 'container_id' => 'menu-main', )); ?>
        <nav id="mobile-nav">
            <span class="toggle"><?php _e('Toggle menu','positive') ?></span>
            <?php wp_nav_menu( array('theme_location'=>'mobile-menu', 'container' => false)); ?>
        </nav>
    </div><!-- .span-6 -->
</header>