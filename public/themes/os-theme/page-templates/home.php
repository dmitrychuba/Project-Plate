<?php if ( ! defined( 'ABSPATH' ) ) exit( 'restricted access' );
/* Template Name: Home */
layout( '_header' );
while ( have_posts() ): the_post();
	?><?php
endwhile;
layout( '_footer' );
