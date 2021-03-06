<?php
/**
 * Template name: Full Width
 *
 * @package parallax-one
 */
	get_header(); 
?>

	</div>
	<!-- /END COLOR OVER IMAGE -->
</header>
<!-- /END HOME / HEADER  -->

<div class="content-wrap">
	<div class="container">

		<div id="primary" class="content-area col-md-12">
			<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

<?php
	if (($pagename == "cashier") || ($pagename == "summary")) {
		?>
		<style>
			h1.entry-title, div.colored-line-left {
				display: none;
			}
		</style>
		<?php
		if ($pagename == "cashier") {
			include 'cashier_app/cashier_app_form.php';
		} else {
			include 'cashier_app/cashier_app_summary.php';
		}
	}
?>
			</main><!-- #main -->
		</div><!-- #primary -->

	</div>
</div><!-- .content-wrap -->

<?php get_footer(); ?>
