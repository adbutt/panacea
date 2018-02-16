<?php
/**
 * Default hero template file.
 *
 * This is the default hero image for page templates, called
 * 'slide'. Strictly panacea specific.
 *
 * @package panacea
 */

// Slide settings
if ( is_front_page() ) :
	$slide_class = ' slide-front';
else :
	$slide_class = ' slide-' . get_post_type();
endif;

// Featured image
if ( has_post_thumbnail() ) :
	$featured_image = esc_url( wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) );
else :
	$featured_image = esc_url( get_template_directory_uri() . '/public/img/default.jpg' );
endif;
?>

<div class="slide<?php echo $slide_class; ?>" style="background-image:url('<?php echo $featured_image; ?>');">
  <div class="shade"></div>
</div>
