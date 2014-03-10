<?php
/*
Plugin Name: Positive
Version: 1.2.8
*/



  //include the main class file
  require_once("admin-page-class/admin-page-class.php");
  
  
  /**
   * configure your admin page
   */
  $config = array(    
    'menu'           => array(),             //sub page to settings page
    'page_title'     => __('Positive options','apc'),       //The name of this page 
    'capability'     => 'edit_themes',         // The capability needed to view the page 
    'option_group'   => 'demo_options',       //the name of the option to create in the database
    'id'             => 'admin_page',            // meta box id, unique per page
    'fields'         => array(),            // list of fields (can be added by field arrays)
    'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => get_stylesheet_directory_uri() . '/includes/admin-page-class'        //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );  
  
  /**
   * instantiate your admin page
   */
  $options_panel = new BF_Admin_Page_Class($config);
  $options_panel->OpenTabs_container('');
  
  /**
   * define your admin page tabs listing
   */
  $options_panel->TabsListing(array(
    'links' => array(
      'options_1' =>  __('Cabecera','apc'),
      'options_2' => __('Redes sociales','apc'),
    )
  ));
  /* =============================================================================
      Open admin page first tab
      ========================================================================== */
  $options_panel->OpenTab('options_1');
  //title
  $options_panel->Title(__("","apc"));
   //Logo
  $options_panel->addImage('ps_header_logo',array('name'=> __('Mi logo ','apc'),'preview_height' => '120px', 'preview_width' => 'auto', 'desc' => __('Sube aqui el logo de tu web','apc')));
  //Show social network
  $options_panel->addCheckbox('ps_header-net',array('name'=> __('Redes sociales','apc'), 'std' => true, 'desc' => __('Quieres incluir la redes sociales a tu cabecera? Marca ON','apc')));
  //Show slect language
  $options_panel->addRadio('ps_header_lang',array('header_lang_show'=>'Mostrar','header_lang_noshow'=>'Ocultar'),array('name'=> __('Mostrar idiomas','apc'), 'std'=> array('header_lang_noshow'), 'desc' => __('Quieres mostrar el selector de idiomas?','apc')));

  $menu_top_header[] = $options_panel->addText( 'ps_menu_top_header_name', array('inline' => true, 'name'=> __('NOMBRE','apc')),true);
  $menu_top_header[] = $options_panel->addSelect( 'ps_menu_top_header_icon', array('i-news'=>'Icono News','i-actividades'=>'icono actividades','i-contacto'=>'icono contacto','btn'=>'mostrar como boton'), array('name'=> __('ICONO','apc'),'inline' => true),true);
  $menu_top_header[] = $options_panel->addText('ps_menu_top_header_url', array('inline' => false, 'name'=> __('URL','apc'), 'std'=> '#'),true);
  $options_panel->addRepeaterBlock('ps_menu_top_header',array('sortable' => true, 'name' => __('Configura aqui el menu en el Top de la cabecera.','apc'),'fields' => $menu_top_header, 'desc' => __('Repeater field description','apc')));

  // Close first tab
  $options_panel->CloseTab();

  /* =============================================================================
      Open admin page second tab
      ========================================================================== */

  $options_panel->OpenTab('options_2');
  //title
  $options_panel->Title(__("","apc"));
  
  $social_network[] = $options_panel->addSelect( 'ps_social_network_name', array('facebook'=>'Facebook','twitter'=>'twitter','linkedin'=>'linkedin','rss'=>'rss'), array('name'=> __('Redes sociales','apc'), 'std'=> array('twitter'),'inline' => true),true);
  $social_network[] = $options_panel->addText('ps_social_network_url', array('inline' => true, 'name'=> __('URL','apc'),'std'=> '#'),true);
  $options_panel->addRepeaterBlock('ps_network',array('sortable' => true, 'name' => __('Configura aqui tu lista de redes sociales.','apc'),'fields' => $social_network, 'desc' => __('Repeater field description','apc')));

  // Close second tab
  $options_panel->CloseTab();

