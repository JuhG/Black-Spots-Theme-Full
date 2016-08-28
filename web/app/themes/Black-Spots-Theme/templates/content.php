<?php
use Roots\Sage\Image;
?>

<article <?php post_class(); ?>>
	<?php if ( $img = Image\get() ): ?>
		<div class="entry-image">
			<a href="<?php echo get_permalink(); ?>">
				<?php echo $img ?>
			</a>
		</div>
	<?php endif ?>
	<header>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php get_template_part('templates/entry-meta'); ?>
	</header>
	<div class="entry-summary rte clearfix">
		<?php the_excerpt(); ?>
	</div>

	<div class="read-more">
		<a class="btn btn-primary" href="<?php echo get_permalink() ?>">
			<?php _e( 'Continue', 'black_spots' ); ?>
		</a>
	</div>
</article>
