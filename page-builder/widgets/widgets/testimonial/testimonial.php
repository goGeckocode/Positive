<?php

class SiteOrigin_Panels_Widget_Testimonial extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Testimonial (PB)', 'positive-panels'),
			array(
				'description' => __('Displays a bullet list of elements', 'positive-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(
				'name' => array(
					'type' => 'text',
					'label' => __('Name', 'positive-panels'),
				),
				'location' => array(
					'type' => 'text',
					'label' => __('Location', 'positive-panels'),
				),
				'image' => array(
					'type' => 'text',
					'label' => __('Image', 'positive-panels'),
				),
				'text' => array(
					'type' => 'textarea',
					'label' => __('Text', 'positive-panels'),
				),
				'url' => array(
					'type' => 'text',
					'label' => __('URL', 'positive-panels'),
				),
				'new_window' => array(
					'type' => 'checkbox',
					'label' => __('Open In New Window', 'positive-panels'),
				),
			)
		);
	}
}