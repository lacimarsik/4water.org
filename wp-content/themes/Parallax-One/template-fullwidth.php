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
	// CASHIER APP - PROTOTYPE //
	if ($pagename == "cashier") {
?>
	<div class="cashier">
		<form action="/action_page.php" id="cashier">
			<div class="cashier-upper">
				<label for="city">Location</label>
				<select name="city" form="cashier">
					<option value="Berlin">Berlin</option>
					<option value="Cardiff">Cardiff</option>
					<option value="Copenhagen">Copenhagen</option>
					<option value="Glasgow">Glasgow</option>
				</select>
				<label for="date">Date</label>
				<input type="text" name="date" value="2017-09-26" />
				<label for="time">Time</label>
				<input type="text" name="time" value="2017-09-26" />
				<label for="lesson">Lesson</label>
				<select name="lesson" form="cashier">
					<option value="Salsa">Salsa</option>
					<option value="Bachata">Bachata</option>
				</select>
				<label for="level">Level</label>
				<select name="level" form="cashier">
					<option value="Beginners">Beginners</option>
					<option value="Advanced">Advanced</option>
				</select>
			</div>
			<div class="cashier-below">
				<label for="name">Volunteer</label>
				<input type="text" name="name" value="" />
			</div>
			<div class="cashier-count">
				<div class="price-type">
					<label for="price-type-1">Adult 1-time</label>
					<button class="js-minus minus">-</button><input type="text" name="name" value="0" /><button class="js-plus plus">+</button>
				</div>
				<div class="price-type">
					<label for="price-type-2">Student 1-time</label>
					<button class="js-minus minus">-</button><input type="text" name="name" value="0" /><button class="js-plus plus">+</button>
				</div>
			</div>
			<input type="submit">
		</form>
	</div>
<?php
	};
?>
			</main><!-- #main -->
		</div><!-- #primary -->

	</div>
</div><!-- .content-wrap -->

<?php get_footer(); ?>
