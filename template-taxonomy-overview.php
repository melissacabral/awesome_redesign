<?php /* 
Template Name: Taxonomy Thumbnails
*/
//edit these to match the stuff you registered in your custom post type plugin
$post_type = 'product';
$taxonomy = 'brand'; ?>

<?php get_header(); ?>
<?php         

// Gets every term in this taxonomy
$terms = get_terms( $taxonomy );

//go through each term in this taxonomy one at a time
foreach( $terms as $term ) : 

    //get ONE post assigned to this term
    $custom_loop = new WP_Query( array(
        'post_type' => $post_type,
        'taxonomy' => $taxonomy,
        'term' => $term->slug,
        'showposts' => 1,
        ) );
    
    //LOOP
    if( $custom_loop->have_posts() ): 
        while( $custom_loop->have_posts() ) : $custom_loop->the_post(); ?>

<article>
    
    <?php echo 'the term is: ' . $term->slug; ?>

    <h2><?php the_title(); ?></h2>

    <?php the_post_thumbnail(); ?>

   
</article>

<?php 
        endwhile; 
    endif;
endforeach;
?>
<?php get_sidebar() ?>
<?php get_footer() ?>