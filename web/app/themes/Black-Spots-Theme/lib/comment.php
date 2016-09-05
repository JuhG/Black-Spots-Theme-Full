<?php

namespace Roots\Sage\Comment;
use Roots\Sage\Extras;

class Black_Spots_Comment extends \Walker_Comment {
	var $tree_type = 'comment';
	var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

	function __construct() { ?>

		<section class="comments-list">

	<?php }

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 2; ?>
		
		<section class="child-comments comments-list">

	<?php }

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 2; ?>

		</section>

	<?php }

	function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;
		$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); 

		if ( 'article' == $args['style'] ) {
			$tag = 'article';
			$add_below = 'comment';
		} else {
			$tag = 'article';
			$add_below = 'comment';
		} ?>

		<article <?php comment_class(empty( $args['has_children'] ) ? '' :'parent') ?> id="comment-<?php comment_ID() ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment">

			<figure class="gravatar"><?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'], '', 'Author\'s gravatar' ); ?></figure>

			<div class="comment-meta post-meta" role="complementary">

				<p class="comment-author fn">
					<?php if (get_comment_author_url()): ?>
						<a class="comment-author-link" href="<?php comment_author_url(); ?>" itemprop="author"><?php comment_author(); ?></a>
					<?php else: ?>
						<?php comment_author(); ?>
					<?php endif; ?>
					<span class="if-author"><?php _e('Author', 'black_spots') ?></span>
				</p>

				<?php echo Extras\convert_to_time_ago( 'get_comment_time', 'comment-meta-item' ); ?>

				<?php edit_comment_link('<p class="comment-meta-item">Edit this comment</p>','',''); ?>

				<?php if ($comment->comment_approved == '0') : ?>
					<p class="comment-meta-item">Your comment is awaiting moderation.</p>
				<?php endif; ?>

			</div>

			<div class="comment-content post-content" itemprop="text">

				<div class="comment-reply-wrapper">
					<?php comment_reply_link(array_merge( $args, array(
						'add_below' => $add_below,
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
					)), $comment->comment_ID) ?>
				</div>

				<div class="comment-text">
					<?php comment_text() ?>
				</div>

			</div>

	<?php }

	function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

		</article>

	<?php }

	function __destruct() { ?>

		</section>
	
	<?php }

}

function bs_remove_url_field ( $fields ) {
	$fields['url'] = '';
	return $fields;
}
add_filter( 'comment_form_default_fields', __NAMESPACE__ . '\\bs_remove_url_field' );