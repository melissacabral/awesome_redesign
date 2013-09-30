<aside id="sidebar">
	<section class="widget">
		<h3>
			<a href="<?php echo get_post_type_archive_link( 'product' ); ?>">
				View ALL Products
			</a>
		</h3>
	</section>

	<section class="widget">
		<h3>Filter by Brand:</h3>
		<ul>
			<?php wp_list_categories( array(
				'taxonomy' => 'brand',
				'title_li' => '',
			) ); ?>
		</ul>
	</section>
	<section class="widget">
		<h3>Filter by Feature:</h3>
		<ul>
			<?php wp_list_categories( array(
				'taxonomy' => 'feature',
				'title_li' => '',
			) ); ?>
		</ul>
	</section>
</aside>