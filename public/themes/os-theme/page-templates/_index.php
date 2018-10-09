<?php if ( ! defined( 'ABSPATH' ) ) exit( 'restricted access' );

layout( '_header' );
?>

<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ): the_post();
		global $post;
		//component( 'post-item', [
		//	'post'         => $post,
		//	'type'         => 'minor',
		//	'class'        => 'post-item col-sm-12 col-md-6 col-lg-4 px-0 px-sm-4 minor-post text-left',
		//	'border_class' => 'border border-top-0',
		//] );
	endwhile; ?>
	<?php posts()->pagination() ?>

<?php else: ?>
    <p>No posts found!</p>
<?php endif; ?>

<?php
layout( '_footer' );