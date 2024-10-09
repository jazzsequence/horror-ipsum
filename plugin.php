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

function horror_lorem_ipsum_texts()
{
	return [
		'The shadows lengthened as the cold wind whispered secrets of forgotten souls.',
		'A scream echoed in the darkness, leaving only a chilling silence in its wake.',
		'Blood-red moonlight bathed the haunted woods, revealing eyes watching from the gloom.',
		'The old mansion creaked with every step, as if alive and breathing in the darkness.',
		'A sinister laughter rang out from nowhere, a promise of terror yet to come.',
		'In the fog, figures moved slowly, their faces blank and eyes empty.',
		'The chill in the air deepened, the whispering voices drawing nearer.',
		'Footsteps followed her, though she walked alone on the abandoned road.',
		'The ancient graveyard came alive under the lightning\'s flash, casting skeletal shadows.',
		'A door slammed shut upstairs, though the house had been empty for years.'
	];
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
