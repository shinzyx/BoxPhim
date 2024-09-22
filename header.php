<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="theme-color" content="#141414">
  
<?php 
        // Display header code
        $header_code = get_theme_mod( 'header_code' );
        if ( ! empty( $header_code ) ) {
            echo wp_kses_post( $header_code );
        }
        ?>

</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <?php get_template_part("template-parts/header"); ?>
  <main id="main-site">
    <div class="container reponpro pad10">
    <?php sphim_breadcrumb(); ?>