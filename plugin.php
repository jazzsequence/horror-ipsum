<?php

/**
 * Plugin Name: Horror Lorem Ipsum Generator
 * Description: A horror-themed Lorem Ipsum generator with a Gutenberg block for adding spooky filler text.
 * Version: 1.0.0
 * Author: Chris
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function horror_ipsum_texts() {
	$ipsum = file_get_contents( plugin_dir_path( __FILE__ ) . 'assets/json/quotes.json' );
	return json_decode( $ipsum, true );
}

// Register the block script.
function horror_lorem_ipsum_register_block()
{
	wp_register_script(
		'horror-lorem-ipsum-block',
		plugins_url('assets/js/block.js', __FILE__),
		array('wp-blocks', 'wp-element', 'wp-block-editor'),
		filemtime(plugin_dir_path(__FILE__) . 'assets/js/block.js')
	);

	// Localize the script to pass PHP data to JavaScript.
	wp_localize_script(
		'horror-lorem-ipsum-block',
		'horrorLipsumData',
		array(
			'texts' => horror_lorem_ipsum_texts(),
		)
	);

	register_block_type('horror-lorem-ipsum/random-paragraph', array(
		'editor_script' => 'horror-lorem-ipsum-block',
	));
}
add_action('init', 'horror_lorem_ipsum_register_block');

// Enqueue the CSS for the block.
function horror_lorem_ipsum_enqueue_styles()
{
	wp_enqueue_style(
		'horror-lorem-ipsum-style',
		plugins_url('assets/css/style.css', __FILE__),
		array(),
		filemtime(plugin_dir_path(__FILE__) . 'assets/css/style.css')
	);
}
add_action('enqueue_block_editor_assets', 'horror_lorem_ipsum_enqueue_styles');
