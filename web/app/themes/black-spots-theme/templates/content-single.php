<?php while (have_posts()) : the_post(); ?>

    <article <?php post_class(); ?>>

        <section class="single-content">

            <header>
                <h1 class="entry-title">
                    <?php the_title(); ?>
                </h1>
                <?php get_template_part('templates/entry-meta'); ?>
            </header>

            <div class="entry-content rte">
              <?php the_content(); ?>
            </div>

            <footer>
              <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'black-spots-theme'), 'after' => '</p></nav>']); ?>

              <?php if (has_tag()): ?>
                <div class="single-tags">
                    <div class="dashicons dashicons-tag"></div>
                    <?php the_tags(''); ?>
                </div>
              <?php endif ?>

            </footer>

            <?php
            $prev = get_previous_post();
            $next = get_next_post();
            if ( $prev || $next ):
            ?>
            <div class="single-related">

                <?php if ($next): ?>
                    <div class="single-next">
                        <a href="<?php echo get_permalink($next) ?>">
                            <div class="dashicons dashicons-arrow-left-alt"></div>
                            <h4>
                                <?php echo $next->post_title ?>
                            </h4>
                        </a>
                    </div>
                <?php endif ?>

                <?php if ($prev): ?>
                    <div class="single-prev">
                        <a href="<?php echo get_permalink($prev) ?>">
                            <div class="dashicons dashicons-arrow-right-alt"></div>
                            <h4>
                                <?php echo $prev->post_title ?>
                            </h4>
                        </a>
                    </div>
                <?php endif ?>

            </div>
            <?php endif; ?>

        </section>

        <?php comments_template('/templates/comments.php'); ?>

    </article>
<?php endwhile; ?>
