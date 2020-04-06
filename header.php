<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Portal_Donasi
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site container">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'portal-donasi' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="row">
			<div class="col-4">
				<div class="site-branding">
					<?php
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					$logo_image = wp_get_attachment_image_src( $custom_logo_id , 'full' );

					?>
					<img src="<?php echo $logo_image[0]; ?>" class="site-logo" alt="" />
					<h1><?php echo get_bloginfo( 'name' ); ?></h1>
				</div><!-- .site-branding -->
			</div>
			<div class="col-8">
				<nav id="site-navigation" class="main-navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'portal-donasi' ); ?></button>
					<?php
					wp_nav_menu( array(
						'menu'           => 'Main Menu'
					) );
					?>
				</nav><!-- #site-navigation -->
			</div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
