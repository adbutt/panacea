<?php
/**
 *  Panacea custom functions.
 *
 *  @package panacea
 */

if ( ! function_exists( 'panacea_entry_footer' ) ) {
	/**
	 *  Show categories, tags, comment and edit links after post.
	 */
	function panacea_entry_footer() {
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma', 'panacea' ) );
			if ( $categories_list ) : ?>
				<p class="cat"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'panacea' ) ); ?></p>
			<?php	endif;

			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'panacea' ) );
			if ( $tags_list ) {
				the_tags( '<ul class="tags"><li>', '</li><li>', '</li></ul>' );
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">
			<svg width="16" height="16" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1408 768q0 139-94 257t-256.5 186.5-353.5 68.5q-86 0-176-16-124 88-278 128-36 9-86 16h-3q-11 0-20.5-8t-11.5-21q-1-3-1-6.5t.5-6.5 2-6l2.5-5 3.5-5.5 4-5 4.5-5 4-4.5q5-6 23-25t26-29.5 22.5-29 25-38.5 20.5-44q-124-72-195-177t-71-224q0-139 94-257t256.5-186.5 353.5-68.5 353.5 68.5 256.5 186.5 94 257zm384 256q0 120-71 224.5t-195 176.5q10 24 20.5 44t25 38.5 22.5 29 26 29.5 23 25q1 1 4 4.5t4.5 5 4 5 3.5 5.5l2.5 5 2 6 .5 6.5-1 6.5q-3 14-13 22t-22 7q-50-7-86-16-154-40-278-128-90 16-176 16-271 0-472-132 58 4 88 4 161 0 309-45t264-129q125-92 192-212t67-254q0-77-23-152 129 71 204 178t75 230z"/></svg> ';
			comments_popup_link( sprintf( wp_kses( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'panacea' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf( _x( 'Edit %s', '%s: Name of current post', 'panacea' ), the_title( '<span class="screen-reader-text">"', '"</span>', false ) ),
			'<p class="edit-link">',
			'</p>'
		);
	}
}

if ( ! function_exists( 'panacea_comments' ) ) {
	/**
	 *  Custom comments function.
	 */
	function panacea_comments( $comment, $args, $depth ) {
		// $GLOBALS['comment'] = $comment; ?>

		<li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div id="comment-<?php comment_ID(); ?>">
				<?php echo get_avatar( $comment, '62' ); ?>
				<h4 class="comment-author"><?php echo get_comment_author_link(); ?></h4>

				<?php if ( '0' === $comment->comment_approved ) : ?>
					<p><em><?php _e( 'Your comment is awaiting approval.', 'panacea' ); ?></em></p>
				<?php endif; ?>

				<p class="comment-time">
					<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
						<svg width="16" height="16" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1520 1216q0-40-28-68l-208-208q-28-28-68-28-42 0-72 32 3 3 19 18.5t21.5 21.5 15 19 13 25.5 3.5 27.5q0 40-28 68t-68 28q-15 0-27.5-3.5t-25.5-13-19-15-21.5-21.5-18.5-19q-33 31-33 73 0 40 28 68l206 207q27 27 68 27 40 0 68-26l147-146q28-28 28-67zm-703-705q0-40-28-68l-206-207q-28-28-68-28-39 0-68 27l-147 146q-28 28-28 67 0 40 28 68l208 208q27 27 68 27 42 0 72-31-3-3-19-18.5t-21.5-21.5-15-19-13-25.5-3.5-27.5q0-40 28-68t68-28q15 0 27.5 3.5t25.5 13 19 15 21.5 21.5 18.5 19q33-31 33-73zm895 705q0 120-85 203l-147 146q-83 83-203 83-121 0-204-85l-206-207q-83-83-83-203 0-123 88-209l-88-88q-86 88-208 88-120 0-204-84l-208-208q-84-84-84-204t85-203l147-146q83-83 203-83 121 0 204 85l206 207q83 83 83 203 0 123-88 209l88 88q86-88 208-88 120 0 204 84l208 208q84 84 84 204z"/></svg>
						<time><?php printf( __( '%1$s at %2$s', 'panacea' ), get_comment_date(), get_comment_time() ); ?></time>
					</a>
				</p>

				<?php comment_text();

				comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
				edit_comment_link( __( '&mdash; Edit', 'panacea' ), ' ', '' ) ?>

			</div>
		</li>
	<?php }
}
/**
 * OPERATION CLEAN-UP
 */

//Disable Emoji's

function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

   /**
    * Filter function used to remove the tinymce emoji plugin.
    *
    * @param array $plugins
    * @return array Difference betwen the two arrays
    */
   function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
    return array();
    }
   }

   /**
    * Remove emoji CDN hostname from DNS prefetching hints.
    *
    * @param array $urls URLs to print for resource hints.
    * @param string $relation_type The relation type the URLs are printed for.
    * @return array Difference betwen the two arrays.
    */
   function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
    /** This filter is documented in wp-includes/formatting.php */
    $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

   $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }

   return $urls;
   }

//Deregister wp-embed.js

   function my_deregister_scripts(){
    wp_deregister_script( 'wp-embed' );
    }
    add_action( 'wp_footer', 'my_deregister_scripts' );

//Clean WP Header
remove_action ('wp_head', 'rsd_link'); //Disable XML-RPC RSD link
remove_action( 'wp_head', 'wlwmanifest_link'); //Remove wlwmanifest link
remove_action( 'wp_head', 'wp_shortlink_wp_head'); //Remove shortlink
remove_action('wp_head', 'rest_output_link_wp_head', 10); //Remove api.w.org relation link
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10); //Remove api.w.org relation link
remove_action('template_redirect', 'rest_output_link_header', 11, 0); //Remove api.w.org relation link
remove_action( 'wp_head', 'feed_links_extra', 3 ); //remove feed links
remove_action( 'wp_head', 'feed_links', 2 ); //remove feed links

//Remove WordPress version number
function panacea_remove_version() {
	return '';
}
add_filter('the_generator', 'panacea_remove_version');

//remove query strings from static resources (js/css version no's)
function panacea_cleanup_query_string( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', 'panacea_cleanup_query_string', 15, 1 ); //remove from scripts
add_filter( 'style_loader_src', 'panacea_cleanup_query_string', 15, 1 ); //remove from styles

//Kill RSS Feeds
function wpb_disable_feed() {
    wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
    }

    add_action('do_feed', 'wpb_disable_feed', 1);
    add_action('do_feed_rdf', 'wpb_disable_feed', 1);
    add_action('do_feed_rss', 'wpb_disable_feed', 1);
    add_action('do_feed_rss2', 'wpb_disable_feed', 1);
    add_action('do_feed_atom', 'wpb_disable_feed', 1);
    add_action('do_feed_rss2_comments', 'wpb_disable_feed', 1);
    add_action('do_feed_atom_comments', 'wpb_disable_feed', 1);


#-----------------------------------------------------------------
# Customise Admin Area
#-----------------------------------------------------------------

//Add Workpower Branding to the Admin Footer
function modify_footer_admin () {
    echo 'Created by <a href="http://workpowermedia.com.au" target="_blank">Workpower</a>.&nbsp;';
    echo 'Powered by <a href="http://WordPress.org" target="_blank">WordPress</a>.';
  }
  add_filter('admin_footer_text', 'modify_footer_admin');

  //Move the pages menu icon to the top
  function rrh_change_post_links() {
      global $menu;
      $menu[6] = $menu[5];
      $menu[5] = $menu[20];
      unset($menu[20]);
  }
  add_action('admin_menu', 'rrh_change_post_links');