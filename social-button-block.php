<?php
/**
 * Plugin Name:       Social Button Block
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       social-button-block
 *
 * @package           create-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * ソーシャルブックマークを出力する
 * @param Array $attributes
 * @param String $content 
 * @reference
 * editor - Gutenberg dynamic block render_callback gives null for $post - WordPress Development Stack Exchange
 * https://wordpress.stackexchange.com/questions/391406/gutenberg-dynamic-block-render-callback-gives-null-for-post
 */
function render_social_button_block( $attributes, $content, $block ) {

	// var_dump($block->context['postId']);
	// var_dump($block);
	
	$tw_acc = "icoro";
	$wrapper_attributes = get_block_wrapper_attributes();

	$tw_href = "";
	$fb_href = "";
	$hb_href = "";
	$ln_href = "";
	$pk_href = "";

	if ( isset( $block->context['postId'] ) ) {
		$post_id = $block->context['postId'];

		$encoded_title = urlencode( get_the_title( $post_id ) );
		$encoded_url = urlencode( get_the_permalink( $post_id ) );

		$tw_href = "href=\"https://twitter.com/share?url={$encoded_url}&text={$encoded_title}&via={$tw_acc}&related={$tw_acc}\"";
		$fb_href = "href=\"http://www.facebook.com/share.php?u={$encoded_url}\"";
		$hb_href = "href=\"http://b.hatena.ne.jp/add?mode=confirm&url={$encoded_url}&title={$encoded_title}\"";
		$ln_href = "href=\"https://social-plugins.line.me/lineit/share?url={$encoded_url}\"";
		$pk_href = "href=\"http://getpocket.com/edit?url={$encoded_url}&title={$encoded_title}\"";
	}

	$bookmark =
		"<ul {$wrapper_attributes}>" .
		"<li><a {$tw_href} rel=\"nofollow noopener\" target=\"blank\" class=\"share-tw\">Twitter</a></li>" .
		"<li><a {$fb_href} rel=\"nofollow noopener\" target=\"blank\" class=\"share-fb\">Facebook</a></li>" .
		"<li><a {$hb_href} rel=\"nofollow noopener\" target=\"blank\" class=\"share-hb\">はてな</a></li>" .
		"<li><a {$ln_href} rel=\"nofollow noopener\" target=\"blank\" class=\"share-ln\">LINE</a></li>" .
		"<li><a {$pk_href} rel=\"nofollow noopener\" target=\"blank\" class=\"share-pk\">Pocket</a></li>" .
		"</ul>";

	return $bookmark;
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function social_button_block_social_button_block_block_init() {
	// var_dump( $postId );
	register_block_type(
		__DIR__ . '/build',
		array(
			'render_callback' => 'render_social_button_block'
			// 'render_callback' => 'render_social_button_block',
			// 'uses_context' => [ 'postId' ]
		)
	);
}
add_action( 'init', 'social_button_block_social_button_block_block_init' );
