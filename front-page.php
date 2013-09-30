<?php get_header(); ?>

<div id="content">
	<?php //custom home featured image banner
	if( function_exists('rad_slider') ):
		rad_slider();
	else:
		the_post_thumbnail( 'awesome-home-banner' );
	endif;
	?>

	<?php 
	//get the values from our options plugin
	$value = get_option('rad_options');

	//show/hide the quote based on the settings
	if( $value['show-quote'] == 1 ):
	 ?>	
	<blockquote class="home-quote">
		<p><?php echo $value['quote']; ?></p>
		<cite>&ndash; <?php echo $value['quote-source']; ?></cite>
	</blockquote>
	<?php 
	endif; //show quote
	?>
		

	<?php 
	//THE LOOP.
	if( have_posts() ): 
		while( have_posts() ):
			the_post(); ?>

		<article id="post-<?php the_ID() ?>" <?php post_class( 'clearfix' ); ?>>
			<div class="entry-content cf clearfix">
				<?php the_content(); ?>
			</div>

		</article><!-- end post -->
		<?php 
		endwhile;
	else: ?>
		<h2>Sorry, no posts found</h2>
	<?php endif; //END OF LOOP. ?>

</div><!-- end content -->

<?php get_sidebar( 'frontpage' ); //loads sidebar-frontpage.php ?> 
<?php get_footer(); ?>  