<?php get_header(); ?>

    <div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			
		<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
				the_content();
			// End the loop.
			endwhile;


		// If no content, include the "No posts found" template.
		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>