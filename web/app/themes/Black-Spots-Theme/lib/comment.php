<?php

namespace Roots\Sage\Comment;

class Black_Spots_Comment extends \Walker_Comment {
		var $tree_type = 'comment';
		var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );
 
		// constructor – wrapper for the comments list
		function __construct() { ?>

			<section class="comments-list">

		<?php }

		// start_lvl – wrapper for child comments list
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>
			
			<section class="child-comments comments-list">

		<?php }
	
		// end_lvl – closing wrapper for child comments list
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>

			</section>

		<?php }

		// start_el – HTML for comment template
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

				<figure class="gravatar"><?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'], '', 'Author’s gravatar' ); ?></figure>

				<div class="comment-meta post-meta" role="complementary">

					<p class="comment-author fn">
						<?php if (get_comment_author_url()): ?>
							<a class="comment-author-link" href="<?php comment_author_url(); ?>" itemprop="author"><?php comment_author(); ?></a>
						<?php else: ?>
							<?php comment_author(); ?>
						<?php endif; ?>
					</p>

					<time class="comment-meta-item" datetime="<?php comment_date('Y-m-d') ?>T<?php comment_time('H:iP') ?>" itemprop="datePublished"><a href="#comment-<?php comment_ID() ?>" itemprop="url"><?php printf( _x( '%s ago', '%s = human-readable time difference', 'your-text-domain' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></a></time>

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

		// end_el – closing HTML for comment template
		function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

			</article>

		<?php }

		// destructor – closing wrapper for the comments list
		function __destruct() { ?>

			</section>
		
		<?php }

	}

/**
 * Changing the date format to a twitterlike format
 */ 
function convert_to_time_ago( $orig_time ) {
	global $post;
	$orig_time = strtotime( $post->post_date ); 
	return human_time_diff( $orig_time, current_time( 'timestamp' ) ).' '.__( 'ago' );
}
// add_filter( 'get_the_date', __NAMESPACE__ . '\\convert_to_time_ago' , 10, 1 );
// add_filter( 'the_date', __NAMESPACE__ . '\\convert_to_time_ago' , 10, 1 );
// add_filter( 'get_the_time', __NAMESPACE__ . '\\convert_to_time_ago' , 10, 1 );
// add_filter( 'the_time', __NAMESPACE__ . '\\convert_to_time_ago' , 10, 1 );