<?php
/*
Plugin Name: Demo Admin Page
Plugin URI: http://en.bainternet.info
Description: My Admin Page Class usage demo
Version: 1.2.8
Author: Bainternet, Ohad Raz
Author URI: http://en.bainternet.info
*/



  //include the main class file
  require_once("admin-page-class/admin-page-class.php");
  
  
  /**
   * configure your admin page
   */
  $config = array(    
    'menu'           => 'settings',             //sub page to settings page
    'page_title'     => __('Demo Admin Page','positive'),       //The name of this page 
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
      'options_1' =>  __('Simple Options','positive'),
      'options_2' =>  __('Fancy Options','positive'),
      'options_3' => __('Editor Options','positive'),
      'options_4' => __('WordPress Options','positive'),
      'options_5' =>  __('Advanced Options','positive'),
      'options_6' =>  __('Field Validation','positive'),
      'options_7' =>  __('Import Export','positive'),
    )
  ));
  
  /**
   * Open admin page first tab
   */
  $options_panel->OpenTab('options_1');

  /**
   * Add fields to your admin page first tab
   * 
   * Simple options:
   * input text, checbox, select, radio 
   * textarea
   */
  //title
  $options_panel->Title(__("Simple Options","apc"));
  //An optionl descrption paragraph
  $options_panel->addParagraph(__("This is a simple paragraph","apc"));
  //text field
  $options_panel->addText('text_field_id', array('name'=> __('My Text ','positive'), 'std'=> 'text', 'desc' => __('Simple text field description','positive')));
  //textarea field
  $options_panel->addTextarea('textarea_field_id',array('name'=> __('My Textarea ','positive'), 'std'=> 'textarea', 'desc' => __('Simple textarea field description','positive')));
  //checkbox field
  $options_panel->addCheckbox('checkbox_field_id',array('name'=> __('My Checkbox ','positive'), 'std' => true, 'desc' => __('Simple checkbox field description','positive')));
  //select field
  $options_panel->addSelect('select_field_id',array('selectkey1'=>'Select Value1','selectkey2'=>'Select Value2'),array('name'=> __('My select ','positive'), 'std'=> array('selectkey2'), 'desc' => __('Simple select field description','positive')));
  //radio field
  $options_panel->addRadio('radio_field_id',array('radiokey1'=>'Radio Value1','radiokey2'=>'Radio Value2'),array('name'=> __('My Radio Filed','positive'), 'std'=> array('radiokey2'), 'desc' => __('Simple radio field description','positive')));
  /**
   * Close first tab
   */   
  $options_panel->CloseTab();


  /**
   * Open admin page Second tab
   */
  $options_panel->OpenTab('options_2');
  /**
   * Add fields to your admin page 2nd tab
   * 
   * Fancy options:
   *  typography field
   *  image uploader
   *  Pluploader
   *  date picker
   *  time picker
   *  color picker
   */
  //title
  $options_panel->Title(__('Fancy Options','positive'));
  //Typography field
  $options_panel->addTypo('typography_field_id',array('name' => __("My Typography","apc"),'std' => array('size' => '14px', 'color' => '#000000', 'face' => 'arial', 'style' => 'normal'), 'desc' => __('Typography field description','positive')));
  //Image field
  $options_panel->addImage('image_field_id',array('name'=> __('My Image ','positive'),'preview_height' => '120px', 'preview_width' => '440px', 'desc' => __('Simple image field description','positive')));
  //PLupload field
  $options_panel->addPlupload('plupload_field_ID',array('name' => __('PlUpload Field','positive'), 'multiple' => true, 'desc' => __('Simple multiple image field description','positive')));  
  //date field
  $options_panel->addDate('date_field_id',array('name'=> __('My Date ','positive'), 'desc' => __('Simple date picker field description','positive')));
  //Time field
  $options_panel->addTime('time_field_id',array('name'=> __('My Time ','positive'), 'desc' => __('Simple time picker field description','positive')));
  //Color field
  $options_panel->addColor('color_field_id',array('name'=> __('My Color ','positive'), 'desc' => __('Simple color picker field description','positive')));
  
  /**
   * Close second tab
   */ 
  $options_panel->CloseTab();



  /**
   * Open admin page 3rd tab
   */
  $options_panel->OpenTab('options_3');
  /**
   * Add fields to your admin page 3rd tab
   * 
   * Editor options:
   *   WYSIWYG (tinyMCE editor)
   *  Syntax code editor (css,html,js,php)
   */
  //title
  $options_panel->Title(__("Editor Options","apc"));
  //wysiwyg field
  $options_panel->addWysiwyg('wysiwyg_field_id',array('name'=> __('My wysiwyg Editor ','positive'), 'desc' => __('wysiwyg field description','positive')));
  //code editor field
  $options_panel->addCode('code_field_id',array('name'=> __('Code Editor ','positive'),'syntax' => 'php', 'desc' => __('code editor field description','positive')));
  /**
   * Close 3rd tab
   */ 
  $options_panel->CloseTab();


  /**
   * Open admin page 4th tab
   */
  $options_panel->OpenTab('options_4');
  
  /**
   * Add fields to your admin page 4th tab
   * 
   * WordPress Options:
   *   Taxonomies dropdown
   *  posts dropdown
   *  Taxonomies checkboxes list
   *  posts checkboxes list
   *  
   */
  //title
  $options_panel->Title(__("WordPress Options","apc"));
  //taxonomy select field
  $options_panel->addTaxonomy('taxonomy_field_id',array('taxonomy' => 'category'),array('name'=> __('My Taxonomy Select','positive'),'class' => 'no-fancy','desc' => __('This field has a <pre>.no-fancy</pre> class which disables the fancy select2 functions','positive') ));
  //posts select field
  $options_panel->addPosts('posts_field_id',array('post_type' => 'post'),array('name'=> __('My Posts Select','positive'), 'desc' => __('posts select field description','positive')));
  //Roles select field
  $options_panel->addRoles('roles_field_id',array(),array('name'=> __('My Roles Select','positive'), 'desc' => __('roles select field description','positive')));
  //taxonomy checkbox field
  $options_panel->addTaxonomy('taxonomy2_field_id',array('taxonomy' => 'category','type' => 'checkbox_list'),array('name'=> __('My Taxonomy Checkboxes','positive'), 'desc' => __('taxonomy checkboxes field description','positive')));
  //posts checkbox field
  $options_panel->addPosts('posts2_field_id',array('post_type' => 'post','type' => 'checkbox_list'),array('name'=> __('My Posts Checkboxes','positive'), 'class' => 'no-toggle','desc' => __('This field has a <pre>.no-toggle</pre> class which disables the fancy Iphone like toggle','positive')));
  //Roles checkbox field
  $options_panel->addRoles('roles2_field_id',array('type' => 'checkbox_list' ),array('name'=> __('My Roles Checkboxes','positive'), 'desc' => __('roles checboxes field description','positive')));


  /**
   * Close 4th tab
   */
  $options_panel->CloseTab();
  /**
   * Open admin page 5th tab
   */
  $options_panel->OpenTab('options_5');
  //title
  $options_panel->Title(__("Advanced Options","apc"));

  //sortable field
   $options_panel->addSortable('sortable_field_id',array('1' => 'One','2'=> 'Two', '3' => 'three', '4'=> 'four'),array('name' => __('My Sortable Field','positive'), 'desc' => __('Sortable field description','positive')));

  /*
   * To Create a reapeater Block first create an array of fields
   * use the same functions as above but add true as a last param
   */
  $repeater_fields[] = $options_panel->addText('re_text_field_id',array('name'=> __('My Text ','positive')),true);
  $repeater_fields[] = $options_panel->addTextarea('re_textarea_field_id',array('name'=> __('My Textarea ','positive')),true);
  $repeater_fields[] = $options_panel->addImage('image_field_id',array('name'=> __('My Image ','positive')),true);
  $repeater_fields[] = $options_panel->addCheckbox('checkbox_field_id',array('name'=> __('My Checkbox  ','positive')),true);
  
  /*
   * Then just add the fields to the repeater block
   */
  //repeater block
  $options_panel->addRepeaterBlock('re_',array('sortable' => true, 'inline' => true, 'name' => __('This is a Repeater Block','positive'),'fields' => $repeater_fields, 'desc' => __('Repeater field description','positive')));
  
  /**
   * To Create a Conditional Block first create an array of fields (just like a repeater block
   * use the same functions as above but add true as a last param
   */
  $Conditinal_fields[] = $options_panel->addText('con_text_field_id',array('name'=> __('My Text ','positive')),true);
  $Conditinal_fields[] = $options_panel->addTextarea('con_textarea_field_id',array('name'=> __('My Textarea ','positive')),true);
  $Conditinal_fields[] = $options_panel->addImage('con_image_field_id',array('name'=> __('My Image ','positive')),true);
  $Conditinal_fields[] = $options_panel->addCheckbox('con_checkbox_field_id',array('name'=> __('My Checkbox  ','positive')),true);
  
  /**
   * Then just add the fields to the repeater block
   */
  //conditinal block 
  $options_panel->addCondition('conditinal_fields',
      array(
        'name'   => __('Enable conditinal fields? ','positive'),
        'desc'   => __('<small>Turn ON if you want to enable the <strong>conditinal fields</strong>.</small>','positive'),
        'fields' => $Conditinal_fields,
        'std'    => false
      ));
  /**
   * Close 5th tab
   */
  $options_panel->CloseTab();
  

  /**
   * Open admin page 6th tab
   * field validation 
   * `email`            => validate email
   * `alphanumeric`     => validate alphanumeric
   * `url`              => validate url
   * `length`           => check for string length
   * `maxlength`        => check for max string length
   * `minlength`        => check for min string length
   * `maxvalue`         => check for max numeric value
   * `minvalue`         => check for min numeric value
   * `numeric`          => check for numeric value
   */
  $options_panel->OpenTab('options_6');
  //email validation
  $options_panel->addText('email_text_field_id',
    array(
      'name'     => __('My Email validation ','positive'),
      'std'      => 'test@domain.com',
      'desc'     => __("Field with email validation","apc"),
      'validate' => array(
          'email' => array('param' => '','message' => __("must be a valid email address","apc"))
      )
    )
  );

  //alphanumeric validation
  $options_panel->addText('an_text_field_id',
    array(
      'name'     => __('My alpha numeric validation ','positive'),
      'std'      => 'abcd1234',
      'desc'     => __("Field with alpa numeric validation, try entring something like #$","apc"),
      'validate' => array(
          'alphanumeric' => array('param' => '','message' => __("must be a valid alpha numeric chars only","apc"))
      )
    )
  );


  // string length exceeds maximum length validation
  $options_panel->addText('max_text_field_id',
    array(
      'name'     => __('My Max length of string validation ','positive'),
      'std'      => 'abcdefghi',
      'desc'     => __("Field with max string lenght validation,So try entering a longer string","apc"),
      'validate' => array(
          'maxlength' => array('param' => 10,'message' => __("must be not exceed 10 chars long","apc"))
      )
    )
  );

  // string length exceeds maximum length validation
  $options_panel->addText('min_text_field_id',
    array(
      'name'     => __('My Min length of string validation ','positive'),
      'std'      => 'abcdefghi',
      'desc'     => __("Field with min string lenght validation, So try entering a shorter string","apc"),
      'validate' => array(
          'minlength' => array('param' => 8,'message' => __("must be a minimum length of 8 chars long","apc"))
      )
    )
  );



  // check for exactly length of string validation
  $options_panel->addText('exact_text_field_id',
    array(
      'name'     => __('My exactly length of string validation ','positive'),
      'std'      => 'abcdefghij',
      'desc'     => __("Field with exact string lenght validation, So try entering a shorter or longer string","apc"),
      'validate' => array(
          'length' => array('param' => 10,'message' => __("must be exactly 10 chars long","apc"))
      )
    )
  );

  //is_numeric
  $options_panel->addText('n_text_field_id',
    array(
      'name'     => __('My numeric validation ','positive'),
      'std'      => 1,
      'desc'     => __("Field with numeric value validation","apc"),
      'validate' => array(
          'numeric' => array('param' => '','message' => __("must be numeric value","apc"))
      )
    )
  );

  //min numeric value
  $options_panel->addText('nmin_text_field_id',
    array(
      'name'     => __('My Min numeric validation ','positive'),
      'std'      => 9,
      'desc'     => __("Field with min numeric value validation","apc"),
      'validate' => array(
          'minvalue' => array('param' => 8,'message' => __("must be numeric with a min value of 8","apc"))
      )
    )
  );

  //max numeric value
  $options_panel->addText('nmax_text_field_id',
    array(
      'name'     => __('My Max numeric validation ','positive'),
      'std'      => 9,
      'desc'     => __("Field with max numeric value validation","apc"),
      'validate' => array(
          'maxvalue' => array('param' => 10,'message' => __("must be numeric with a Max value of 10","apc"))
      )
    )
  );

  //is_url validation
  $options_panel->addText('url_text_field_id',
    array(
      'name'     => __('My URL validation ','positive'),
      'std'      => 'http://en.bainternet.info',
      'desc'     => __("Field with url value validation","apc"),
      'validate' => array(
          'url' => array('param' => '','message' => __("must be a valid URL","apc"))
      )
    )
  );

  /**
   * Close 6th tab
   */
  $options_panel->CloseTab();

  /**
   * Open admin page 7th tab
   */
  $options_panel->OpenTab('options_7');
  
  //title
  $options_panel->Title(__("Import Export","apc"));
  
  /**
   * add import export functionallty
   */
  $options_panel->addImportExport();

  /**
   * Close 7th tab
   */
  $options_panel->CloseTab();
  $options_panel->CloseTab();

  //Now Just for the fun I'll add Help tabs
  $options_panel->HelpTab(array(
    'id'      =>'tab_id',
    'title'   => __('My help tab title','positive'),
    'content' =>'<p>'.__('This is my Help Tab content','positive').'</p>'
  ));
  $options_panel->HelpTab(array(
    'id'       => 'tab_id2',
    'title'    => __('My 2nd help tab title','positive'),
    'callback' => 'help_tab_callback_demo'
  ));
  
  //help tab callback function
  function help_tab_callback_demo(){
    echo '<p>'.__('This is my 2nd Help Tab content from a callback function','positive').'</p>';
  }