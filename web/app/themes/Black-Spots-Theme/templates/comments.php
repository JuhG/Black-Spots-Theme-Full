<?php
use Roots\Sage\Comment;

if (post_password_required()) {
  return;
}
?>

<section id="comments" class="comments">
  <?php if (have_comments()) : ?>
    <h3 class="comments-title"><?php printf(_nx('One response to &ldquo;%2$s&rdquo;', '%1$s responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'black_spots'), number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>'); ?></h3>

    <ol class="comment-list">
      <?php wp_list_comments(array(
        // 'avatar_size' => 64,
        'style' => 'ol',
        'short_ping' => true,
        'walker' => new Comment\Black_Spots_Comment()
      )); ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
      <nav>
        <ul class="pager">
          <?php if (get_previous_comments_link()) : ?>
            <li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'black_spots')); ?></li>
          <?php endif; ?>
          <?php if (get_next_comments_link()) : ?>
            <li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'black_spots')); ?></li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>
  <?php endif; // have_comments() ?>

  <?php if (!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments')) : ?>
    <div class="alert alert-warning">
      <?php _e('Comments are closed.', 'black_spots'); ?>
    </div>
  <?php endif; ?>

  <?php comment_form(array(
    'comment_notes_before' => ''
  )); ?>
</section>