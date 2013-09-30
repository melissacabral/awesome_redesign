<?php get_header(); ?>
    
    <div id="content">
	<?php 
	//THE LOOP.
	if( have_posts() ):  ?>

<h2 class="archive-title">All Products by <?php single_cat_title(); ?></h2>

    <?php
		while( have_posts() ):
		the_post(); ?>
	
        <article id="post-<?php the_ID() ?>" <?php post_class( 'clearfix' ); ?>>
             <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'thumb' ) ); ?>

             <h2 class="entry-title"> <a href="<?php the_permalink(); ?>"> 
				<?php the_title(); ?> 
			</a></h2>       

            <div class="entry-content">
                <?php //the_meta(); //show all custom fields ?>
                Price: $<?php echo get_post_meta( $post->ID, 'Price', true ); ?>
                <?php mmc_smart_content(); //from functions.php ?>
                <?php the_terms( $post->ID, 'brand', '<p>Brand: ', ', ', '</p>' ); ?>
            </div>
       
        
		<?php comments_template(); ?>
		 </article><!-- end post -->
      <?php 
	  endwhile;
	  else: ?>
	  <h2>Sorry, no posts found</h2>
	  <?php endif; //END OF LOOP. ?>
	          
        
        <div id="nav-below" class="pagination">
        <?php //run the pagenavi function if it exists
        if( function_exists('wp_pagenavi') ):
            wp_pagenavi(); 
        else:
            //do the normal pagination if the plugin is missing
            next_posts_link( '&laquo; Older Posts' ); 
            previous_posts_link( 'Newer Posts &raquo;' );  
        endif; ?>
        </div><!-- end #nav-below --> 
        
    </div><!-- end content -->
    
<?php get_sidebar('shop');  //includes sidebar-shop.php ?> 
<?php get_footer(); ?>  