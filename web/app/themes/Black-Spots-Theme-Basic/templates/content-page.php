<div class="rte">
	<?php the_content(); ?>
</div>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'black_spots'), 'after' => '</p></nav>']); ?>
