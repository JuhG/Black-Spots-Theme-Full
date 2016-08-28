<?php while (have_posts()) : the_post(); ?>

    <article <?php post_class(); ?>>
        
        <?php if ( false && has_post_thumbnail() ):
            $thumb_id = get_post_thumbnail_id();
            $thumb_url = wp_get_attachment_image_src($thumb_id,'full_screen');
            ?>
            <div class="entry-image">
                <a class="fluidbox" href="<?php echo $thumb_url[0]; ?>">
                  <?php the_post_thumbnail(); ?>
                </a>
            </div>
        <?php endif ?>

        <section class="single-content">

            <header>
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <?php get_template_part('templates/entry-meta'); ?>
            </header>

            <div class="entry-content rte">
              <?php the_content(); ?>
            </div>

            <footer>
              <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'black_spots'), 'after' => '</p></nav>']); ?>

              <?php if (has_tag()): ?>
                <div class="dashicons dashicons-tag"></div>
                <?php the_tags(''); ?>
              <?php endif ?>

            </footer>

        </section>

        <?php comments_template('/templates/comments.php'); ?>

    </article>
<?php endwhile; ?>
