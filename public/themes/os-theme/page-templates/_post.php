<?php if ( ! defined( 'ABSPATH' ) ) exit( 'restricted access' );

layout( '_header' );
while ( have_posts() ): the_post();
	?>
    <main class="row">
        <div class="col px-0">
			<?php the_content() ?>
        </div>
    </main>

<?php
endwhile;
layout( '_footer' );