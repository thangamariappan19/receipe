<?php
$integrations = array(
	'id' => 'integrations',
	'icon' => 'plug',
	'name' => __( 'Integrations', 'wp-recipe-maker' ),
	'settings' => array(
		array(
			'id' => 'integration_mediavine_ad',
			'name' => __( 'Add extra Mediavine ad unit', 'wp-recipe-maker' ),
			'description' => __( 'Enable to automatically output an extra ad unit after the recipe ingredients block.', 'wp-recipe-maker' ),
			'type' => 'toggle',
			'default' => false,
		),
	),
);
