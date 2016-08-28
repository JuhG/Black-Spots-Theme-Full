<header class="banner">
	<div class="header-container">

		<?php if (has_nav_menu('primary_navigation')): ?>

			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary-header-navigation">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

		<?php endif; ?>

		<div class="nav-container container">

			<?php
			/*
			// Social media icons + search button
			// Disabled at the moment

			<div class="header-search">
				Search
			</div>

			<div class="header-socials">
				Facebook
				Twitter
			</div>
			*/
			?>

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

		<div class="title-container container">
			
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

					<a href="<?php echo esc_url(home_url('/')); ?>">
						<?php bloginfo('name'); ?>
					</a>

				<?php if ( is_home() && ! get_option('page_for_posts', true) ): ?>
					</h1>
				<?php else: ?>
					</p>
				<?php endif ?>
				
			</div>

		</div>
	
	</div>
		
	<div class="header-image container">

		<?php
		/**
		 * Custom header image
		 */

		if ( is_singular() && has_post_thumbnail() ): ?>
            <?php the_post_thumbnail( 'full_screen' ); ?>
		<?php elseif ( $img = get_header_image() ): ?>
			<img src="<?php echo $img; ?>" alt="<?php echo( get_bloginfo( 'title' ) ); ?>" />
		<?php endif; ?>
		
	</div>

</header>
