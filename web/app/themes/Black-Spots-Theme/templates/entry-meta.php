<?php
use Roots\Sage\Extras;
?>
<div class="entry-meta">

	<?php
	/**
	 * Categories
	 */
	if ( get_the_category() ): ?>
		<?php the_category() ?>
		<span class="separator">//</span>
	<?php endif ?>

	<?php
	/**
	 * Author, if more than one
	 */
	$user_query = new WP_User_Query( array( 'role__not_in' => array( 'Subscriber' ) ) );
	$users_count = (int) $user_query->get_total();
	if ( $users_count > 1 ): ?>
		<p class="byline author vcard"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a></p>
		<span class="separator">//</span>
	<?php endif ?>

	<?php echo Extras\convert_to_time_ago('get_post_time', 'updated'); ?>
	
</div>