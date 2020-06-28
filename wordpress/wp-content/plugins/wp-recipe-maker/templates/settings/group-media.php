<?php
$media = array(
	'id' => 'media',
	'icon' => 'painting',
	'name' => __( 'Media', 'wp-recipe-maker' ),
	'subGroups' => array(
		array(
			'name' => __( 'Lightbox', 'wp-recipe-maker' ),
			'description' => __( 'Use a lightbox plugin and enable clickable images to have your recipe and/or instruction images open in a lightbox after clicking on them.', 'wp-recipe-maker' ),
			'documentation' => 'https://help.bootstrapped.ventures/article/176-clickable-images-for-lightbox-integration',
			'settings' => array(
				array(
					'id' => 'recipe_image_clickable',
					'name' => __( 'Clickable Recipe Image', 'wp-recipe-maker' ),
					'type' => 'toggle',
					'default' => false,
				),
				array(
					'id' => 'instruction_image_clickable',
					'name' => __( 'Clickable Instruction Images', 'wp-recipe-maker' ),
					'type' => 'toggle',
					'default' => false,
				),
				array(
					'id' => 'clickable_image_size',
					'name' => __( 'Clickable Images Size', 'wp-recipe-maker' ),
					'description' => __( 'Image size to link to for the clickable images.', 'wp-recipe-maker' ) . ' ' . __( 'Type the name of a thumbnail size or the exact size you want.', 'wp-recipe-maker' ) . ' ' . __( 'For example:', 'wp-recipe-maker' ) . ' full or 1000x1000',
					'type' => 'text',
					'default' => 'full',
				),
			),
		),
		array(
			'name' => __( 'Video', 'wp-recipe-maker' ),
			'settings' => array(
				array(
					'id' => 'video_autoplay',
					'name' => __( 'Autoplay Video', 'wp-recipe-maker' ),
					'description' => __( 'Set the autoplay option for uploaded (not embedded) videos.', 'wp-recipe-maker' ),
					'type' => 'dropdown',
					'options' => array(
						'none' => __( 'No recipe videos', 'wp-recipe-maker' ),
						'main' => __( 'The main recipe video', 'wp-recipe-maker' ),
						'instruction' => __( 'The instruction videos', 'wp-recipe-maker' ),
						'all' => __( 'All recipe videos', 'wp-recipe-maker' ),
					),
					'default' => 'none',
				),
				array(
					'id' => 'video_loop',
					'name' => __( 'Loop Video', 'wp-recipe-maker' ),
					'description' => __( 'Set the loop option for uploaded (not embedded) videos.', 'wp-recipe-maker' ),
					'type' => 'dropdown',
					'options' => array(
						'none' => __( 'No recipe videos', 'wp-recipe-maker' ),
						'main' => __( 'The main recipe video', 'wp-recipe-maker' ),
						'instruction' => __( 'The instruction videos', 'wp-recipe-maker' ),
						'all' => __( 'All recipe videos', 'wp-recipe-maker' ),
					),
					'default' => 'none',
				),
			),
		),
	),
);
