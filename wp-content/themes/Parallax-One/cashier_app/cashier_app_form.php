<?php

// =============================
// CASHIER APP - PROTOTYPE (Form part)
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
		if ((date('l') == $row['day']) && (date('H:i:s') < $row['time'])) {
			// if the lesson is today, and didn't yet start
			$day_as_string = strtolower($row['day']) . 'this week';
		} else {
			$day_as_string = 'next ' . strtolower($row['day']);
		}
		$array_of_next_lessons[$row['class_type'] . "," . $row['level']] = strtotime($day_as_string . ' ' . $row['time']);
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
		<br />
		<link rel="stylesheet" href="../wp-content/themes/Parallax-One/cashier_app/cashier_app.css">
		<form action="/index.php" id="cashier" method="post">
			<div class="cashier-upper col-md-12">
				<input type="hidden" name="cashier" />
				<input type="hidden" name="submitform" />
				<div class="form-group col-md-4">
					<label for="branch_id">Branch</label>
					<select id="branch_id" name="branch_id" form="cashier">
<?php
						$sql= "SELECT * FROM 4w_branches";
						$result = $connection_4w->query($sql);
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'. $row['id'] . '" ' . (($branch_id == $row['id']) ? "selected" : "") . '>' . $row['activity'] . "4Water " . $row['city'] . '</option>';
						}
?>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="class_type">Class</label>
					<select id="class_type" name="class_type" form="cashier">
						<?php
						$sql= "SELECT DISTINCT(class_type) FROM 4w_branch_classes WHERE branch_id = " . $branch_id;
						$result = $connection_4w->query($sql);
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'. $row['class_type'] . '" ' . (($closest_lesson_class_type == $row['class_type']) ? "selected" : "") . '>' . $row['class_type'] . '</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="level">Level</label>
					<select id="level" name="level" form="cashier">
						<?php
						$sql= "SELECT DISTINCT(level) FROM 4w_branch_classes WHERE branch_id = " . $branch_id;
						$result = $connection_4w->query($sql);
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'. $row['level'] . '" ' . (($closest_lesson_level == $row['level']) ? "selected" : "") . '>' . $row['level'] . '</option>';
						}
						?>
					</select>
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-4">
					<label for="date">Date</label>
					<input id="date" type="text" name="date" value="<?php echo $closest_lesson_date; ?>" />
				</div>
				<div class="form-group col-md-4">
					<label for="time">Time</label>
					<input id="time" type="text" name="time" value="<?php echo $closest_lesson_time; ?>" />
				</div>
				<div class="cashier-below col-md-4">
					<label for="name">Cashier</label>
					<select id="name" name="name" form="cashier">
						<?php
						$sql= "SELECT * FROM 4w_volunteers WHERE branch_id = " . $branch_id;
						$result = $connection_4w->query($sql);
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'. $row['first'] . ' ' . $row['last'] . '">' . $row['first'] . ' ' . $row['last'] . '</option>';
						}
						?>
					</select>
				</div>
			</div>
			<br />
			<div class="cashier-count col-md-12">
				<script type="text/javascript" src="../wp-content/themes/Parallax-One/cashier_app/cashier_app.js"></script>
<?php
				$sql= "SELECT * FROM 4w_branch_prices WHERE branch_id = " . $branch_id . " AND class_type = '" . $closest_lesson_class_type . "'";
				$result = $connection_4w->query($sql);
				while ($row = mysqli_fetch_assoc($result)) {
?>
				<div class="prices-iterator">
					<div class="price-type col-md-3">
						<label for="price-type-price<?php echo $row['id']; ?>"><?php echo $row['price_type']; ?></label>
					</div>
					<div class="price-entry col-md-9">
						<button id="price<?php echo $row['id']; ?>-minus" type="button" class="js-minus price-button">-</button><input type="text" class="price" id="price<?php echo $row['id']; ?>" name="price<?php echo $row['id']; ?>" value="0" /><button id="price<?php echo $row['id']; ?>-plus" type="button" class="js-plus price-button">+</button>
					</div>
				</div>
				<div class="clearfix smallpadding"></div>
<?php
				}
?>
			</div>
			<div class="cashier-submit col-md-12">
				<div class="form-group col-md-4">
					<input type="submit">
				</div>
			</div>
		</form>
	</div>