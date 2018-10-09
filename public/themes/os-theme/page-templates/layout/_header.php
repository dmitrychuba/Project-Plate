<?php if ( ! defined( 'ABSPATH' ) ) exit( 'restricted access' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title>
		<?php
		wp_title( ' | ', true, 'right' );
		bloginfo( 'name' );
		?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="main-wrapper">
    <!--[if lt IE 7]>
    <p class="browsehappy">
        You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
    </p>
    <![endif]-->
    <header>
        <div class="d-flex justify-content-between">

            <a class="logo" href="<?php bloginfo( 'url' ) ?>"></a>

            <nav class="nav-bar">
                <?php theme()->menu( [
                    'id'    => 'primaryNav',
                    'name'  => 'primary',
                    'class' => 'list-unstyled menu-style',
                ] ); ?>
            </nav>

        </div>
    </header>

    <div id="contentContainer" class="<?php the_page_class( 'container-fluid' ) ?>">
