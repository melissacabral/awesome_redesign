<?php 
//hide the comments if the post is password protected
if( post_password_required() ):
	echo 'Enter the password to see the comments on this post';
	return; //stop the rest of this file from running
endif;

//separate comments by type
$comments_by_type = &separate_comments($comments);
//var to hold the number of comments only
$comment_count = count($comments_by_type['comment']);
//var to hold the number of trackbacks and pingbacks
$trackback_count = count($comments_by_type['pings']); 
 ?>

<section id="comments">
	<h3 id="comments-title">
		<?php echo $comment_count; ?> Comments so far

		<?php if( $trackback_count > 0 ): ?>
			| <?php echo $trackback_count; ?> sites link here
		<?php endif; ?>

		<?php if( comments_open() ): ?>
			 | <a href="#respond">Leave a Comment</a>
		<?php endif; ?>
	</h3>

	<div class="commentlist">
		<?php wp_list_comments( array(
			'type' => 'comment',
			'style' => 'div',
			'avatar_size' => 70,
			'callback' => 'mmc_custom_comment',
		) ); ?>
	</div>

<?php //show pagination if the pagination option is set AND there's more than one page of comments to show 
if( get_option( 'page_comments' ) AND get_comment_pages_count() > 1 ):?>
	<div class="pagination">
		<?php previous_comments_link(); ?>
		<?php next_comments_link(); ?>
	</div>
<?php 
endif; //pagination ?>

	<?php comment_form(); ?>

</section>

<?php //only show trackbacks if there are trackbacks to show!
if( $trackback_count > 0 ): ?>
<section id="trackbacks">
	<h3>Sites that Link Here</h3>
	<ol>
		<?php wp_list_comments( array(
			'type' => 'pings', //trackbacks and pings
			'page' => 1, //prevent pagination from clashing with comment pagination
			'per_page' => 100,
		) ); ?>
	</ol>
</section>
<?php 
endif; ?>