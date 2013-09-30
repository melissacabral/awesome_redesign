<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<meta name="viewport" content="width=device-width" />

	<title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title>

	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/styles/reset.css" />

	<?php 
//Necessary in <head> for JS and plugins to work. 
//I like it before style.css loads so the theme stylesheet is more specific than all others.
	wp_head();  ?>

	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- HTML5 shiv -->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

</head>

<body <?php body_class(); ?>>
	
		<header role="banner">


			<div class="top-bar clearfix">
				<h1 class="site-name">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="AwesomeCo" rel="home"> 
						<?php bloginfo('name'); ?> 
					</a>
				</h1>
				<h2 class="site-description"> <?php bloginfo('description'); ?> </h2>
				
				<?php wp_nav_menu( array(
					'theme_location' => 'main_menu',
					'container' => 'nav',
					) ); ?>
			</div>
				
			<?php wp_nav_menu( array(
					'theme_location' => 'utilities',
					'container' => 'false',
					'menu_class' => 'utilities',
				) ); ?>

			<?php get_search_form(); ?>
			
		</header>    <!-- end header -->

		<?php 
//only do the breadcrumb if the function exists
		if(function_exists('dimox_breadcrumbs')):
			dimox_breadcrumbs(); 
		endif; 
		?>