<?php
/*
Template Name: Automagic Sitemap

Will automatically generate a sitemap from the wordpress database of posts, pages, and categories. 
*/
 ?>
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

            <section class="onethird">
                <h3>Pages:</h3>
                <ul>
                    <?php wp_list_pages( array(
                        'title_li' => '',
                    ) ); ?>
                </ul>
            </section>

            <section class="onethird">
                <h3>All Blog Posts</h3>
                <ul>
                    <?php wp_get_archives( array(
                        'type' => 'alpha',
                    ) ); ?>
                </ul>
            </section> 

            <section class="onethird">
             <?php $feed_image = get_bloginfo( 'template_directory' ) . '/images/icon_feed.png' ; ?>
                <h3>RSS Feeds</h3>
                <ul>
                    <li><a href="<?php bloginfo( 'rss2_url' ); ?>">Subscribe to All Blog Posts <img src="<?php echo $feed_image; ?>" /></a></li>
                    <li><a href="<?php bloginfo( 'comments_rss2_url' ); ?>">Subscribe to Comments <img src="<?php echo $feed_image; ?>" /></a></li>
                </ul>

                <h3>Blog Categories:</h3>
                <ul>
                    <?php         
                    wp_list_categories( array(
                        'title_li' => '',
                        'feed_image' => $feed_image,
                    ) ); ?>
                </ul>
            </section>                 
           
		 </article><!-- end post -->
      <?php 
	   endwhile;
	  else: ?>
	  <h2>Sorry, no posts found</h2>
	  <?php endif; //END OF LOOP. ?>
        
    </div><!-- end content -->
    
<?php get_footer(); ?>  