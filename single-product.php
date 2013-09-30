<?php get_header(); ?>
    
    <div id="content">
	<?php 
	//THE LOOP.
	if( have_posts() ): 
		while( have_posts() ):
		the_post(); ?>
	
        <article id="post-<?php the_ID() ?>" <?php post_class( 'clearfix' ); ?>>
            
            <h2 class="entry-title"> <a href="<?php the_permalink(); ?>"> 
				<?php the_title(); ?> 
			</a></h2>           
            
             <?php the_post_thumbnail( 'medium', array( 'class' => 'thumb alignright' ) ); ?>
                               
            <div class="entry-content">
                <?php the_meta(); ?>
                <?php the_terms( $post->ID, 'brand', '<p>Brand: ', ', ', '</p>' ); ?>
                <?php mmc_smart_content(); //from functions.php ?>
            </div>       
        
		 </article><!-- end post -->
      <?php 
	  endwhile;
	  else: ?>
	  <h2>Sorry, no posts found</h2>
	  <?php endif; //END OF LOOP. ?>
	          
        
        <div id="nav-below" class="pagination"> 
            <?php previous_post_link();  //older post?>
            <?php next_post_link(); //newer post?>          
        </div><!-- end #nav-below --> 
        
    </div><!-- end content -->
    

<?php get_footer(); ?>  