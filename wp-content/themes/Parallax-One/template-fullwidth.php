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
// =============================
// CASHIER APP - PROTOTYPE
// =============================
	if ($pagename == "cashier") {
		require_once(ABSPATH . 'wp-config.php');
		$connection_4w = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
		mysqli_select_db($connection_4w, DB_NAME);

		// Find branch ID from URL
		$url = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
		$patharray = (array) explode( '/', trim( $url, '/' ));
		$city = $patharray[0];
		$activity = $patharray[1];

		$sql= "SELECT * FROM 4w_branches WHERE LOWER(city) = '" . $city . "' AND LOWER(activity) = '" . $activity . "'";
		$result = $connection_4w->query($sql);
		$row = mysqli_fetch_assoc($result);
		$branch_id = $row['id'];

?>
	<div class="cashier">
		<form action="/cashier_app.php" id="cashier">
			<div class="cashier-upper">
				<label for="branch">Branch</label>
				<select name="branch" form="cashier">
<?php
					$sql= "SELECT * FROM 4w_branches";
					$result = $connection_4w->query($sql);
					while ($row = mysqli_fetch_assoc($result)) {
						echo '<option value=\"'. $row['id'] . '" ' . (($branch_id == $row['id']) ? "selected" : "") . '>' . $row['activity'] . "4Water " . $row['city'] . '</option>';
					}
?>
				</select>
				<label for="date">Date</label>
				<input type="text" name="date" value="2017-09-26" />
				<label for="time">Time</label>
				<input type="text" name="time" value="2017-09-26" />
				<label for="class">Class</label>
				<select name="class" form="cashier">
<?php
					$sql= "SELECT DISTINCT(class_type) FROM 4w_branch_classes WHERE branch_id = " . $branch_id;
					$result = $connection_4w->query($sql);
					while ($row = mysqli_fetch_assoc($result)) {
						echo '<option value=\"'. $row['class_type'] . '">' . $row['class_type'] . '</option>';
					}
?>
				</select>
				<label for="level">Level</label>
				<select name="level" form="cashier">
<?php
					$sql= "SELECT DISTINCT(level) FROM 4w_branch_classes WHERE branch_id = " . $branch_id;
					$result = $connection_4w->query($sql);
					while ($row = mysqli_fetch_assoc($result)) {
						echo '<option value=\"'. $row['level'] . '">' . $row['level'] . '</option>';
					}
?>
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
