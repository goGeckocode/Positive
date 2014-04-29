<?php
/*
Admin Theme Options
Description: Create custom Admin Pages. Inpired in Admin Page Class by Ohad Raz (http://en.bainternet.info)
Version: 1.0
Author: GeckoCode
Author URI: http://geckocode.es
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
*/


//include the main class file
require_once("admin-page-class/admin-page-class.php");
  
  
  /**
   * configure your admin page
   */
  $config = array(    
    'menu'           => array(),          //sub page to settings page
    'page_title'     => __('Opciones Positive', 'positive-backend'),       //The name of this page 
    'capability'     => 'edit_themes',    // The capability needed to view the page 
    'option_group'   => 'theme_options',  //the name of the option to create in the database
    'id'             => 'admin_page',     // meta box id, unique per page
    'fields'         => array(),          // list of fields (can be added by field arrays)
    'local_images'   => false,            // Use local or hosted images (meta box images for add/remove)
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
      'options_1' => __('General', 'positive-backend'),
      'options_2' => __('Cabecera', 'positive-backend'),
      'options_3' => __('Redes Sociales', 'positive-backend')
    )
  ));

  /* =============================================================================
      GENERAL
      ========================================================================== */

  $options_panel->OpenTab('options_1');
  // front page
  $options_panel->addPosts('ps_page_home', array('post_type' => 'page'), array('name'=> __('P&aacute;gina de inicio', 'positive-backend'),'std'=>'','desc'=>__('Selecctiona una de las p&aacute;ginas creadas. Si no hay ninguna seleccionada se mostrar&aacute;n las entradas.', 'positive-backend') ));
  // blog page
  $options_panel->addPosts('ps_page_blog', array('post_type' => 'page'), array('name'=> __('P&aacute;gina de entradas', 'positive-backend'),'std'=>'','desc'=>__('Selecciona la p&aacute;gina en la que mostrar el listado de entradas. <br>Solo disponible si se ha seleccionado una p&aacute;gina de inicio arriba. No puede ser la misma que la p&aacute;gina de inicio.', 'positive-backend') ));
  $options_panel->addImage('ps_blog_image',array('name'=> __('Imagen de cabecera', 'positive-backend'),'preview_height' => 'auto', 'preview_width' => 'auto', 'desc' => __('Selecciona la imagen de cabecera de la página de entradas', 'positive-backend')));
  // events page
   $options_panel->addPosts('ps_page_events', array('post_type' => 'page'), array('name'=> __('P&aacute;gina de eventos', 'positive-backend'),'std'=>'','desc'=>__('Selecciona la p&aacute;gina en la que mostrar el listado de eventos. <br>No puede ser la misma que ninguna de las anteriores.', 'positive-backend') ));
   $options_panel->addImage('ps_events_image',array('name'=> __('Imagen de cabecera', 'positive-backend'),'preview_height' => 'auto', 'preview_width' => 'auto', 'desc' => __('Selecciona la imagen de cabecera de la página de eventos', 'positive-backend')));
   // comunicacion page
   $options_panel->addPosts('ps_page_comunicacion', array('post_type' => 'page'), array('name'=> __('P&aacute;gina de comunicacion', 'positive-backend'),'std'=>'','desc'=>__('Selecciona la p&aacute;gina en la que mostrar el listado de comunicacion. <br>No puede ser la misma que ninguna de las anteriores.', 'positive-backend') ));
   $options_panel->addImage('ps_comunicacion_image',array('name'=> __('Imagen de cabecera', 'positive-backend'),'preview_height' => 'auto', 'preview_width' => 'auto', 'desc' => __('Selecciona la imagen de cabecera de la página de comunicacion', 'positive-backend')));

  // Close third tab
  $options_panel->CloseTab();

  /* =============================================================================
      HEADER
      ========================================================================== */
  $options_panel->OpenTab('options_2');
   //Logo
  $options_panel->addImage('ps_header_logo',array('name'=> __('Logotipo', 'positive-backend'),'preview_height' => 'auto', 'preview_width' => 'auto', 'desc' => __('Sube tu logotipo para mostrar en la cabecera en lugar del nombre de tu sitio', 'positive-backend')));

  //favicon
  $options_panel->addImage('ps_favicon',array('name'=> __('Favicon', 'positive-backend'),'preview_height' => 'auto', 'preview_width' => 'auto', 'desc' => __('Icono a mostrar en las pesta&ntilde;as del navegador. <br>Requisitos: tamaño de 16x16 p&iacute;xeles, formato PNG.', 'positive-backend')));
  
  //Show social network
  $options_panel->addCheckbox('ps_header-net',array('name'=> __('Mostrar redes sociales', 'positive-backend'), 'std' => true, 'desc' => __('Seleccionar para mostrar los botones de redes sociales en la cabecera', 'positive-backend')));
  
  //Show select language
  $options_panel->addCheckbox('ps_header_lang',array('name'=> __('Display languages selector in the header', 'positive-backend'), 'std'=>false, 'desc' => __('Check to display languages selector in the header. Only available with the Transposh plugin', 'positive-backend')));

  //Custom top header menu
  // titulo
  $menu_top_header[] = $options_panel->addText( 'ps_menu_top_header_name', array('inline' => true, 'name'=> __('T&iacute;tulo', 'positive-backend')),true);
  // estilo
  $menu_top_header[] = $options_panel->addSelect( 'ps_menu_top_header_icon', array('i-news'=> __('Icono noticias', 'positive-backend'),'i-mail'=> __('Icono email', 'positive-backend')), array('name'=> __('Estilo', 'positive-backend'),'inline' => true),true);
  // pagina
  $menu_top_header[] = $options_panel->addPosts('ps_menu_top_header_page', array('post_type' => 'page'), array('name'=> __('Seleccionar p&aacute;gina...', 'positive-backend'),'std'=>'', 'desc'=>__('Selecctiona una p&aacute;gina a la que enlazar.', 'positive-backend'), 'inline' => true),true);
  // url
  $menu_top_header[] = $options_panel->addText('ps_menu_top_header_url', array('inline' => true, 'name'=> __('... o especifica la URL', 'positive-backend'), 'std'=> '#'),true);
  $options_panel->addRepeaterBlock('ps_menu_top_header',array('sortable' => true, 'name' => __('Men&uacute; de accesos directos', 'positive-backend'),'fields' => $menu_top_header, 'desc' => __('Configura el men&uacute; en la barra superior de la cabecera. Este no es el men&uacute; principal, para administrar los men&uacute;s ir a Apariencia > Men&uacute;s.', 'positive-backend')));

  // Close first tab
  $options_panel->CloseTab();

  /* =============================================================================
      SOCIAL
      ========================================================================== */

  $options_panel->OpenTab('options_3');
  
  $social_network[] = $options_panel->addSelect( 'ps_social_network_name', array('facebook'=>'Facebook','twitter'=>'Twitter','vimeo'=>'Vimeo'), array('name'=> __('Redes sociales', 'positive-backend'),'inline' => true),true);
  $social_network[] = $options_panel->addText('ps_social_network_url', array('inline' => true, 'name'=> __('URL', 'positive-backend'),'std'=> ''),true);
  $options_panel->addRepeaterBlock('ps_network',array('sortable' => true, 'name' => __('Configura aqui tu lista de redes sociales.', 'positive-backend'),'fields' => $social_network));

  // Close second tab
  $options_panel->CloseTab();