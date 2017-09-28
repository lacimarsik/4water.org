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

// @return closest_lesson [Array] Array containing: Timestamp of the closest lesson, Class type, Level
// TODO: Create struct for lessons
function get_closest_lesson($connection_4w, $branch_id) {
	// Get the array of next lessons from the "next monday" (tuesday, ...) depending on what days the branch has lessons
	// Array will be in the form "Class type, Level" => Timestamp
	$array_of_next_lessons = array();
	$sql= "SELECT * FROM 4w_branch_classes WHERE branch_id = " . $branch_id;
	$result = $connection_4w->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
		$array_of_next_lessons[$row['class_type'] . "," . $row['level']] = strtotime('next ' . strtolower($row['day']) . ' ' . $row['time']);
	}
	asort($array_of_next_lessons);
	reset($array_of_next_lessons);
	// Return only the closest lesson as: Timestamp, Class type, Level
	$class_type_level = explode(",", key($array_of_next_lessons));
	$timestamp = $array_of_next_lessons[key($array_of_next_lessons)];
	$class_type = $class_type_level[0];
	$level = $class_type_level[1];
	$result_array = array();
	array_push($result_array, $timestamp);
	array_push($result_array, $class_type);
	array_push($result_array, $level);
	return $result_array;
}

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

		// Find current date and time (use if exact time of cashiering is needed)
		//date_default_timezone_set('Europe/' . $row['city']);
		//$date = date('Y-m-d', time());
		//$time = date('H:i:s', time());
		// Get next lesson
		$closest_lesson = get_closest_lesson($connection_4w, $branch_id);
		$closest_lesson_date = date('Y-m-d', $closest_lesson[0]);
		$closest_lesson_time = date('H:i:s', $closest_lesson[0]);
		$closest_lesson_class_type = $closest_lesson[1];
		$closest_lesson_level = $closest_lesson[2];
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
						echo '<option value="'. $row['id'] . '" ' . (($branch_id == $row['id']) ? "selected" : "") . '>' . $row['activity'] . "4Water " . $row['city'] . '</option>';
					}
?>
				</select>
				<label for="date">Date</label>
				<input type="text" name="date" value="<?php echo $closest_lesson_date; ?>" />
				<label for="time">Time</label>
				<input type="text" name="time" value="<?php echo $closest_lesson_time; ?>" />
				<label for="class_type">Class</label>
				<select name="class_type" form="cashier">
<?php
					$sql= "SELECT DISTINCT(class_type) FROM 4w_branch_classes WHERE branch_id = " . $branch_id;
					$result = $connection_4w->query($sql);
					while ($row = mysqli_fetch_assoc($result)) {
						echo '<option value="'. $row['class_type'] . '" ' . (($closest_lesson_class_type == $row['class_type']) ? "selected" : "") . '>' . $row['class_type'] . '</option>';
					}
?>
				</select>
				<label for="level">Level</label>
				<select name="level" form="cashier">
<?php
					$sql= "SELECT DISTINCT(level) FROM 4w_branch_classes WHERE branch_id = " . $branch_id;
					$result = $connection_4w->query($sql);
					while ($row = mysqli_fetch_assoc($result)) {
						echo '<option value="'. $row['level'] . '" ' . (($closest_lesson_level == $row['level']) ? "selected" : "") . '>' . $row['level'] . '</option>';
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
