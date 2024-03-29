<?php
// =============================
// CASHIER APP - V1.01 Form part

// Form part: cashier_app_form.php (in the theme folder)
// Process part: cashier_app_process.php (in the root folder)
// Summary part: cashier_app_summary.php (in the theme folder)

// Javascript part: cashier_app.js (in the theme folder)

// OUTLINE
// 1. FUNCTIONS
// 2. INITIALIZATION
// 3. FORM
// =============================

require_once(ABSPATH . 'wp-config.php');
$connection_4w = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysqli_select_db($connection_4w, DB_NAME);

// =============================
// 1. FUNCTIONS
// =============================
// TODO: Refactor us to a service to avoid duplication among form/process/summary

function getCurrentBranchUrl($branch_id, $connection, $suffix) {
	$sql= "SELECT * FROM 4w_branches WHERE id = '" . $branch_id . "';";
	$result = $connection->query($sql);
	$row = mysqli_fetch_assoc($result);
	return '/' . strtolower($row['city']) . '/' . strtolower($row['activity']) . '/' . $suffix;
}

// @return closest_lesson [Array] Array containing: Timestamp of the closest lesson, Class type, Level
// TODO: Create struct for lessons
function get_closest_lesson($connection_4w, $branch_id, $current_season) {
	// Get the array of next lessons from the "next monday" (tuesday, ...) depending on what days the branch has lessons
	// Array will be in the form "Class type, Level" => Timestamp
	$array_of_next_lessons = array();
	$sql= "SELECT * FROM 4w_branch_classes WHERE branch_id = " . $branch_id . ' AND season = "' . $current_season . '"';
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

// @param $nextlast Either 'next' or 'last' depending if we want previous lessons or coming lessons
//
// @return closest_lessons [Array] Array of 1 week of lessons, in the form: ["Salsa,Advanced"] = ["Next Monday", Timestamp]
// TODO: Create struct for lessons
function get_closest_lessons($connection_4w, $branch_id, $current_season, $nextlast) {
	// Get the array of next lessons from the "next monday" (tuesday, ...) depending on what days the branch has lessons
	// Array will be in the form "Class type, Level" => Timestamp
	$array_of_next_lessons = array();
	$array_of_next_lessons_string = array();
	$sql= "SELECT * FROM 4w_branch_classes WHERE branch_id = " . $branch_id . ' AND season = "' . $current_season . '"';
	$result = $connection_4w->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
		if ((date('l') == $row['day']) && (date('H:i:s') < $row['time'])) {
			// if the lesson is today, and didn't yet start => use "this week"
			// But let's skip it if we want "last" lessons
			if ($nextlast == 'last') {
				continue;
			}
			$day_as_string = strtolower($row['day']) . ' this week';
		} else if (date('l') == $row['day'])  {
			// if the lesson is today, and is over already => "use this week"
			// But let's skip it if we want "next" lessons
			if ($nextlast == 'next') {
				continue;
			}
			$day_as_string = strtolower($row['day']) . ' this week';
		} else {
			$day_as_string = $nextlast . ' ' . strtolower($row['day']);
		}
		$array_of_next_lessons[$row['class_type'] . "," . $row['level']] = strtotime($day_as_string . ' ' . $row['time']);
		$array_of_next_lessons_string[$row['class_type'] . "," . $row['level']] = $day_as_string;
	}
	asort($array_of_next_lessons);
	reset($array_of_next_lessons);
	$return_array = array();
	foreach ($array_of_next_lessons as $key => $value) {
		$tuple = array();
		array_push($tuple, $array_of_next_lessons_string[$key]);
		array_push($tuple, $array_of_next_lessons[$key]);
		array_push($return_array, $tuple);
	}
	return $return_array;
}

// gets branch ID by parsing URL, e.g. prague/language -> searches 4w_branches table by city and activity
function findBranchIdFromUrl($connection_4w) {
	$url = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
	$patharray = (array) explode( '/', trim( $url, '/' ));
	$city = $patharray[0];
	$activity = $patharray[1];
	$sql= "SELECT * FROM 4w_branches WHERE LOWER(city) = '" . $city . "' AND LOWER(activity) = '" . $activity . "'";
	$result = $connection_4w->query($sql);
	$row = mysqli_fetch_assoc($result);
	return $row['id'];
}

// gets current season of the branch
function findCurrentSeason($connection_4w, $branch_id) {
	$sql= "SELECT * FROM 4w_branches WHERE id = " . $branch_id;
	$result = $connection_4w->query($sql);
	$row = mysqli_fetch_assoc($result);
	return $row['current_season'];
}

// finds a proper timezone
function findTimezone($connection_4w, $branch_id) {
	$sql= "SELECT * FROM 4w_branches WHERE id = '" . $branch_id . "';";
	$result = $connection_4w->query($sql);
	$row = mysqli_fetch_assoc($result);
	return $row['timezone'];
}

// =============================
// 2. INITIALIZATION
// =============================

	// Find branch ID from URL
	$branch_id = findBranchIdFromUrl($connection_4w);

	// URLs
	$cashier_url = getCurrentBranchUrl($branch_id, $connection_4w, "cashier");
	$summary_url = getCurrentBranchUrl($branch_id, $connection_4w, "summary");

	// Find proper timezone
	$timezone = findTimezone($connection_4w, $branch_id);
	date_default_timezone_set($timezone);

	// Find current season
	$current_season = findCurrentSeason($connection_4w, $branch_id);

	// Set proper timezone
	date_default_timezone_set($timezone);

	// Get next lesson
	$closest_lesson = get_closest_lesson($connection_4w, $branch_id, $current_season);
	$closest_lesson_date = date('Y-m-d', $closest_lesson[0]);
	$closest_lesson_time = date('H:i:s', $closest_lesson[0]);
	$closest_lesson_class_type = $closest_lesson[1];
	$closest_lesson_level = $closest_lesson[2];

	// Get surrounding lessons
	$array_of_dates = array();
	$array_of_string_days = array();
	$closest_lessons = get_closest_lessons($connection_4w, $branch_id, $current_season, "last");
	foreach ($closest_lessons as $key => $value) {
		if (!in_array(ucwords($value[0]), $array_of_string_days)) {
			array_push($array_of_dates, date('Y-m-d', $value[1]));
			array_push($array_of_string_days, ucwords($value[0]));
		}
	}
	$closest_lessons = get_closest_lessons($connection_4w, $branch_id, $current_season, "next");
	foreach ($closest_lessons as $key => $value) {
		if (!in_array(ucwords($value[0]), $array_of_string_days)) {
			array_push($array_of_dates, date('Y-m-d', $value[1]));
			array_push($array_of_string_days, ucwords($value[0]));
		}
	}

	// Normal situation: show closest lesson
	$filled_date = $closest_lesson_date;
	$filled_time = $closest_lesson_time;
	$filled_class_type = $closest_lesson_class_type;
	$filled_level = $closest_lesson_level;

	// But if Edit button was used from the Report page, use the desired lesson
	if (isset($_POST['return'])) {
		$filled_date =  date('Y-m-d', $_POST['datetime']);
		$filled_time =  date('H:i:s', $_POST['datetime']);
		$filled_class_type = $_POST['class'];
		$filled_level = $_POST['level'];
	}

// =============================
// 3. FORM
// =============================
?>
	<img src="../wp-content/themes/Parallax-One/cashier_app/img/Logo.jpg" style="width: 150px;" />
	<a class="btn btn-info" href="<?php echo $cashier_url; ?>">Cashier</a>
	<a class="btn btn-default" href="<?php echo $summary_url; ?>">Summary</a>
	<div class="cashier">
		<br />
		<link rel="stylesheet" href="../wp-content/themes/Parallax-One/cashier_app/cashier_app.css?ver=1.01">
		<form action="/cashier_app_process.php" id="cashier" method="post">
			<p>Welcome, dear cashier. On this page you count the number of sold 1-time entries, vouchers, and how many people came on already-paid vouchers.</p>
			<p>Please check the class, level, date and time.</p>
			<div class="cashier-upper col-md-12">
				<input type="hidden" name="cashier" />
				<input type="hidden" name="submitform" />
				<div style="display: none;" class="form-group col-md-4">
					<label for="branch_id">Branch</label>
					<select id="branch_id" name="branch_id" class="js-start" form="cashier">
<?php
						$sql= 'SELECT * FROM 4w_branches WHERE current_season = "' . $current_season . '"';;
						$result = $connection_4w->query($sql);
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'. $row['id'] . '" ' . (($branch_id == $row['id']) ? "selected" : "") . '>' . $row['activity'] . "4Water " . $row['city'] . '</option>';
						}
?>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="class_type">Class</label>
					<select id="class_type" name="class_type" class="js-start" form="cashier">
						<?php
						$sql= "SELECT DISTINCT(class_type) FROM 4w_branch_classes WHERE branch_id = " . $branch_id. ' AND season = "' . $current_season . '"';
						$result = $connection_4w->query($sql);
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'. $row['class_type'] . '" ' . (($filled_class_type == $row['class_type']) ? "selected" : "") . '>' . $row['class_type'] . '</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="level">Level</label>
					<select id="level" name="level" class="js-start" form="cashier">
						<?php
						$sql= "SELECT DISTINCT(level) FROM 4w_branch_classes WHERE branch_id = " . $branch_id . ' AND season = "' . $current_season . '"';
						$result = $connection_4w->query($sql);
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'. $row['level'] . '" ' . (($filled_level == $row['level']) ? "selected" : "") . '>' . $row['level'] . '</option>';
						}
						?>
					</select>
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-4">
					<label for="date">Day</label>
					<select id="date" name="date" class="js-start" form="cashier">
						<?php
						$sql= "SELECT DISTINCT(time) FROM 4w_branch_classes WHERE branch_id = " . $branch_id . ' AND season = "' . $current_season . '"';
						$result = $connection_4w->query($sql);
						for ($i = 0; $i < sizeof($array_of_dates); $i++) {
							echo '<option value="'. $array_of_dates[$i] . '" ' . (($filled_date == $array_of_dates[$i]) ? "selected" : "") . '>' . str_replace("This Week", "", str_replace("Next","", $array_of_string_days[$i]) . ' ' . date("d F", strtotime($array_of_dates[$i]))) . '</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="time">Time</label>
					<select id="time" name="time" class="js-start" form="cashier">
						<?php
						$sql= "SELECT DISTINCT(time) FROM 4w_branch_classes WHERE branch_id = " . $branch_id . ' AND season = "' . $current_season . '"';
						$result = $connection_4w->query($sql);
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<option value="'. $row['time'] . '" ' . (($filled_time == $row['time']) ? "selected" : "") . '>' . $row['time'] . '</option>';
						}
						?>
					</select>
				</div>
			</div>
			<p>Please select your name to start. <strong>note: use 'Already had a voucher' if you only stamp the voucher, without money. In that case, it does not matter if the voucher person was student/non-student. We only ask for it when we sell the voucher & collect money (first buttons) :)</strong></p>
			<div class="form-group col-md-6">
				<label for="name">Cashier</label>
				<select id="name" name="name" form="cashier" class="js-start">
					<?php
					$sql= "SELECT * FROM 4w_volunteers WHERE branch_id = " . $branch_id . " AND active = 1";
					$result = $connection_4w->query($sql);
					while ($row = mysqli_fetch_assoc($result)) {
						echo '<option value="'. $row['first'] . ' ' . $row['last'] . '">' . $row['first'] . ' ' . $row['last'] . '</option>';
					}
					?>
				</select>
			</div>
			<div class="cashier-count col-md-12">
				<script type="text/javascript" src="../wp-content/themes/Parallax-One/cashier_app/cashier_app.js?ver=1.0"></script>
<?php
				$sql= "SELECT * FROM 4w_branch_prices WHERE branch_id = " . $branch_id . ' AND season = "' . $current_season . '"';
				$result = $connection_4w->query($sql);
				while ($row = mysqli_fetch_assoc($result)) {
?>
				<div class="prices-iterator">
					<div class="price-type col-md-3">
						<label for="price-type-price<?php echo $row['id']; ?>"><?php echo '(' . $row['price'] . ' ' . $row['currency'] . ') ' . $row['price_type']; ?></label>
					</div>
					<div class="price-entry col-md-9">
						<button disabled="disabled" style="background-color: grey;" id="price<?php echo $row['id']; ?>-minus" type="button" class="js-minus price-button">-</button>
						<span class="wrapper">
						<input disabled="disabled" type="text" class="price" id="price<?php echo $row['id']; ?>" name="price<?php echo $row['id']; ?>" value="0" />
						<button id="price<?php echo $row['id']; ?>-plus" disabled="disabled" style="background-color: grey;" type="button" class="js-plus price-button">+</button></span>
					</div>
				</div>
				<div class="clearfix smallpadding"></div>
<?php
				}
?>
			</div>
			<div class="clearfix"></div>
			<br />
			<p>When done counting <strong>for the class</strong> (i.e. Beginners class), please submit. You can then continue counting the class that follows.</p>
			<div class="cashier-submit col-md-12">
				<div class="form-group">
					<input class="submit-button" disabled="disabled" style="background-color: grey;" type="submit">
				</div>
			</div>
			<p><strong>Season 2021/2022</strong> Please make sure that before each student pays, they scan this QR code / or go manually to <em>4water.org/prague/dance/covid-form</em></p>
			<div class="cashier-submit col-md-12">
				<div class="form-group">
					<img src="http://4water.org/prague/dance/wp-content/uploads/sites/3/2021/10/QR.png" />
				</div>
			</div>
		</form>
	</div>
