<?php
//unlock sleeping features
add_theme_support( 'post-thumbnails' );
add_theme_support( 'custom-background' );
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
add_theme_support( 'automatic-feed-links' );

//gives you the ability to add editor-style.css to control the edit screen
add_editor_style();

//set up custom image sizes
//name, width, height, crop (bool)
add_image_size( 'awesome-home-banner', 960, 330, true );

/** 
 * required - content width
 */
if ( ! isset( $content_width ) ) $content_width = 700;

/**
 * Make the excerpts a different length
 * @since ver. 0.1 
 * @return int - number of words in the excerpt
 */
function mmc_excerpt_length(){
	return 60; 
}
add_filter( 'excerpt_length', 'mmc_excerpt_length' );

/**
 * change the [...] to a usable button after excerpts
 * @since ver. 0.1
 */
function mmc_read_more(){
	return '&hellip; <a href="' . get_permalink() . '" class="readmore">Read More</a>';
}
add_filter( 'excerpt_more', 'mmc_read_more' );

/**
 * Make User Experience better when replying to comments
 * the comment form will move to the post you are replying to
 * @since ver. 0.1
 */
add_action( 'wp_print_scripts', 'mmc_comment_reply' );
function mmc_comment_reply(){
	//make sure we are on a page that needs the comment-reply script
	if( !is_admin() AND is_singular() AND comments_open() AND 
		get_option('thread_comments') ):

		wp_enqueue_script( 'comment-reply' );
	endif;
}

/**
 * Helper function for showing full content on singular views 
 * and short content on all other views
 * @since ver. 0.1
 */
function mmc_smart_content(){
	if( is_singular() ):
		the_content();
		wp_link_pages( array(
			'before' => '<div class="pagination">This post has more pages: ',
			'after'=> '</div>',
			'next_or_number' => 'next',
			'nextpagelink' => 'Keep Reading',
			) );
	else:
		the_excerpt(); //first few words of the post or custom excerpt
	endif;
}

/**
 * Set up all the Navigation Menu Areas the site needs
 * @since ver 0.1
 */
add_action( 'init', 'mmc_setup_menus' );
function mmc_setup_menus(){
	register_nav_menus( array(
			'main_menu' => 'Main Navigation Bar',
			'utilities' => 'Utility Area',
			'footer_menu' => 'Footer Menu Area',
 		) );
}

/**
 * Set Up Widget Areas (Dynamic Sidebars)
 * @since ver. 0.1
 */
add_action( 'widgets_init', 'mmc_register_sidebars' );
function mmc_register_sidebars(){
	register_sidebar( array(
		'name'			=> 'Blog Sidebar',
		'id'			=> 'blog-sidebar',
		'description' 	=> 'These widgets will appear on all blog and archive views',
		'before_widget' => '<section id="%1$s" class="widget cf %2$s">',
		'after_widget' 	=> '</section>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
		) );
	register_sidebar( array(
		'name'			=> 'Home Area',
		'id'			=> 'home-area',
		'description' 	=> 'These Widgets show up near the bottom of the home page',
		'before_widget' => '<section id="%1$s" class="widget cf %2$s">',
		'after_widget' 	=> '</section>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
		) );
	register_sidebar( array(
		'name'			=> 'Page Sidebar',
		'id'			=> 'page-sidebar',
		'description' 	=> 'These widgets will appear on all pages that have a sidebar',
		'before_widget' => '<section id="%1$s" class="widget cf %2$s">',
		'after_widget' 	=> '</section>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
		) );
	register_sidebar( array(
		'name'			=> 'Footer Area',
		'id'			=> 'footer-area',
		'description' 	=> 'appears on the bottom of every view',
		'before_widget' => '<section id="%1$s" class="widget cf %2$s">',
		'after_widget' 	=> '</section>',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
		) );
}//end mmc_register_sidebars

/**
 * Comments.php callback function	
 */
//this will control what each comment looks like when wp_list_comments() runs. 
function mmc_custom_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		
		<?php //customize HTML output below this line  ?>
		
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment->comment_author_email, $args['avatar_size'] ); ?>
			<span class="fn"><?php comment_author_link(); ?></span>
		</div>
		
<?php 
//special message if the comment is awaiting admin approval
if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>		
<?php endif; ?>

		<?php comment_text() ?>

		<div class="comment-meta commentmetadata">
			<span class="comment-date"><?php comment_date('F j, Y'); ?></span>
			<span class="comment-link"><a href="<?php comment_link(); ?>">link</a></span>
			<span class="edit-comment"><?php edit_comment_link(); ?></span>
			<?php
			if( comments_open() ): ?>
			<span class="comment-reply-button">
			<?php comment_reply_link( array_merge( $args, array(
				'depth' => $depth,
				'max_depth' => $args['max_depth']
			) ) ); ?></span>
			<?php endif; ?>
		</div>

		
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
}

/**
 * Dimox Breadcrumbs
 * http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
 * Since ver 0.1
 * Add this to any template file by calling dimox_breadcrumbs()
 * Changes: MC added taxonomy support
 */
function dimox_breadcrumbs(){
  /* === OPTIONS === */
	$text['home']     = 'Home'; // text for the 'Home' link
	$text['category'] = 'Archive by Category "%s"'; // text for a category page
	$text['tax'] 	  = 'Archive for "%s"'; // text for a taxonomy page
	$text['search']   = 'Search Results for "%s" Query'; // text for a search results page
	$text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
	$text['author']   = 'Articles Posted by %s'; // text for an author page
	$text['404']      = 'Error 404'; // text for the 404 page

	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter   = ' &raquo; '; // delimiter between crumbs
	$before      = '<span class="current">'; // tag before the current crumb
	$after       = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$homeLink = get_bloginfo('url') . '/';
	$linkBefore = '<span typeof="v:Breadcrumb">';
	$linkAfter = '</span>';
	$linkAttr = ' rel="v:url" property="v:title"';
	$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

	if (is_home() || is_front_page()) {

		if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

	} else {

		echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

		
		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

		} elseif( is_tax() ){
			$thisCat = get_category(get_query_var('cat'), false);
			if ( isset( $thisCat->parent ) && $thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['tax'], single_cat_title('', false)) . $after;
		
		}elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;

		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
			$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
			echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_page() && !$post->post_parent ) {
			if ($showCurrent == 1) echo $before . get_the_title() . $after;

		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo $delimiter;
			}
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;

		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</div>';

	}
} // end dimox_breadcrumbs()
//DO NOT CLOSE PHP