<?php if ( ! defined( 'ABSPATH' ) ) exit( 'restricted access' );

layout( '_header' );
//while ( have_posts() ): the_post();
?>
    <div class="page-template-default page">
        <div class="row">
            <div class="page-content col-8 p-5 mx-auto">
                <h1 class="page-title text-uppercase text-secondary mb-5">Page not found</h1>
                <div class="content-body">
                    <h3 class="text-muted">The link you clicked may be broken or the page may have been removed.</h3>
                    <p class="text-muted text-lowercase">VISIT THE <a href="<?php echo home_url() ?>">HOMEPAGE</a> OR <a href="<?php echo home_url( 'contact' ) ?>">CONTACT US</a> ABOUT THE PROBLEM</p>
                </div>
            </div>
        </div>
    </div>
<?php
//endwhile;
layout( '_footer' );