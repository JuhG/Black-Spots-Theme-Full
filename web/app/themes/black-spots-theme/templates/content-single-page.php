<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('templates/page', 'header'); ?>

    <div class="rte">
        <?php the_content(); ?>
    </div>

    <?php wp_link_pages(array(
        'before' => '<nav class="page-nav"><p>' . __('Pages:', 'black-spots-theme'),
        'after' => '</p></nav>'
    )); ?>

<?php endwhile; ?>
