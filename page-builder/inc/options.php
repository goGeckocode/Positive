<?php

/**
 * Get the settings
 *
 * @param string $key Only get a specific key.
 * @return mixed
 */
function siteorigin_panels_setting(){

	static $settings;

	$settings = array(
		'post-types' => array('page'),	// Post types that can be edited using panels.
		'bundled-widgets' => true,		// Include bundled widgets.
		//'responsive' => true,			// Should we use a responsive layout
		'copy-content' => true,			// Should we copy across content
		'animations' => false,			// Do we need animations
	);

	return $settings;
}
