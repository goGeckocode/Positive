<?php

class SiteOrigin_Panels_Widget_Animated_Image extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Animated Image (PB)', 'positive-panels'),
			array(
				'description' => __('An image that animates in when it enters the screen.', 'positive-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(
				'image' => array(
					'type' => 'text',
					'label' => __('Image URL', 'positive-panels'),
				),
				'animation' => array(
					'type' => 'select',
					'label' => __('Animation', 'positive-panels'),
					'options' => array(
						'fade' => __('Fade In', 'positive-panels'),
						'slide-up' => __('Slide Up', 'positive-panels'),
						'slide-down' => __('Slide Down', 'positive-panels'),
						'slide-left' => __('Slide Left', 'positive-panels'),
						'slide-right' => __('Slide Right', 'positive-panels'),
					)
				),
			)
		);
	}

	function enqueue_scripts(){
		static $enqueued = false;
		if(!$enqueued) {
			wp_enqueue_script('siteorigin-widgets-'.$this->origin_id.'-onscreen', POSITIVE_PANELS_URL.'js/onscreen.js', array('jquery'), POSITIVE_PANELS_VERSION);
			wp_enqueue_script('siteorigin-widgets-'.$this->origin_id, POSITIVE_PANELS_URL.'js/main.js', array('jquery'), POSITIVE_PANELS_VERSION);
			$enqueued = true;
		}

	}
}