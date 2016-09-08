<header class="banner">
	<div class="header-container container">

		<?php if (has_nav_menu('primary_navigation')): ?>

			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary-header-navigation">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

		<?php endif; ?>

		<div class="nav-container">

			<?php if (has_nav_menu('primary_navigation')): ?>

				<nav class="nav-primary">
					<?php wp_nav_menu(array(
						'theme_location'  => 'primary_navigation',
						'menu_class'      => 'nav navbar-nav',
						'depth'           => 2,
						'container_id'    => 'primary-header-navigation',
						'container_class' => 'collapse navbar-collapse',
						'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
						'walker' => new wp_bootstrap_navwalker()
					)); ?>
				</nav>

			<?php endif; ?>

		</div>

		<div class="title-container">

			<div class="header-main">

				<?php if ( $icon = get_option( 'site_icon' ) ): ?>
					<div class="site-icon">
						<a href="<?php echo esc_url(home_url('/')); ?>">
							<?php echo wp_get_attachment_image( $icon, 'icon', true ); ?>
						</a>
					</div>
				<?php endif; ?>

				<?php
				/**
				 * Main title
				 */
				if ( is_home() && ! get_option('page_for_posts', true) ): ?>
					<h1 class="master-title">
				<?php else: ?>
					<p class="master-title">
				<?php endif ?>

					<a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>

				<?php if ( is_home() && ! get_option('page_for_posts', true) ): ?>
					</h1>
				<?php else: ?>
					</p>
				<?php endif ?>

			</div>

		</div>

	</div>


    <?php
    /**
     * Custom header image
     */

    $header_img = '';
    $header_height = '';
    if ( is_singular() && has_post_thumbnail() && ! is_singular('product') ): ?>
        <?php $header_img = get_the_post_thumbnail( '', 'full_screen' ); ?>
    <?php elseif ( $header_img = get_header_image_tag() ): ?>
        <?php if ( ! is_home() && get_theme_mod('header_only_home') ) $header_img = ''; ?>
    <?php endif; ?>

    <?php if ( $header_img ): ?>
    	<div class="header-image container">
            <?php echo $header_img; ?>
    	</div>

        <?php
        /**
         * Preset the height to avoid the "content jump"
         *
         * Since we're in the header, the scrollbar is not loaded yet
         * That's why we need that ratio
         */
        ?>
        <script>
            (function ($) {
                var width = $(window).width();
                var ratio = ( width - 17 ) / width;
                var $headerBottom = $('.header-image');
                var $headerImage = $headerBottom.find('img');
                $headerBottom.css({
                    height: $headerImage.height() * ratio
                });
            })(jQuery);
        </script>
    <?php endif; ?>

</header>
