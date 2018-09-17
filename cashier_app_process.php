<?php
// =============================
// CASHIER APP - V1.0 Process part

// Summary part: cashier_app_process.php (in the theme folder)
// Form part: cashier_app_process.php (in the theme folder)

// OUTLINE
// 1. FUNCTIONS
// 2. AJAX / FORM HANDLING
// 3. INITIALIZATION
// 4. SUCCESS PAGE
// =============================

if (!isset($_POST['cashier'])) {
	exit;
}

require_once('wp-config.php');
$connection_4w = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysqli_select_db($connection_4w, DB_NAME);

// =============================
// 1. FUNCTIONS
// =============================
// TODO: Refactor us to a service to avoid duplication among form/process/summary

function getArrayOfPrices($post) {
	$prices_array = array();
	foreach ($post as $key => $val) {
		if (substr($key, 0, 5) == 'price') {
			$prices_array[substr($key, 5)] = $val;
		}
	}
	return $prices_array;
}

function countsExist($post, $connection) {
	$sql= "SELECT * FROM 4w_accounting WHERE date = '" . $post['date'] . "' AND time = '" . $post['time']
		. "' AND branch_id = '" . $post['branch_id'] . "' AND class_type = '" . $post['class_type'] . "' AND level = '" . $post['level'] . "';";
	$result = $connection->query($sql);
	return $result;
}

function getCurrentBranchUrl($post, $connection, $suffix) {
	$sql= "SELECT * FROM 4w_branches WHERE id = '" . $post['branch_id'] . "';";
	$result = $connection->query($sql);
	$row = mysqli_fetch_assoc($result);
	return '/' . strtolower($row['city']) . '/' . strtolower($row['activity']) . '/' . $suffix;
}

function get_last_lesson($connection, $branch_id) {
	// Get the array of lessons depending on what days the branch has lessons
	// Array will be in the form "Class type, Level" => Timestamp
	$array_of_next_lessons = array();
	$sql= "SELECT * FROM 4w_branch_classes WHERE branch_id = " . $branch_id;
	$result = $connection->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
		if ((date('l') == $row['day']) && (date('H:i:s') > $row['time'])) {
			// if the lesson is today, and didn't yet start
			$day_as_string = strtolower($row['day']) . 'this week';
		} else {
			$day_as_string = 'last ' . strtolower($row['day']);
		}
		$array_of_next_lessons[$row['class_type'] . "," . $row['level']] = strtotime($day_as_string . ' ' . $row['time']);
	}
	arsort($array_of_next_lessons);
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

function get_closest_lesson($connection, $branch_id) {
	// Get the array of next lessons from the "next monday" (tuesday, ...) depending on what days the branch has lessons
	// Array will be in the form "Class type, Level" => Timestamp
	$array_of_next_lessons = array();
	$sql= "SELECT * FROM 4w_branch_classes WHERE branch_id = " . $branch_id;
	$result = $connection->query($sql);
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

// =============================
// 2. AJAX / FORM HANDLING
// =============================

$form_submitted = (isset($_POST['increment']) || isset($_POST['decrement']) || isset($_POST['submitform'])) && !isset($_POST['resuls']);

if ($form_submitted) {
	$prices_array = getArrayOfPrices($_POST);
	$result = countsExist($_POST, $connection_4w);
	if ($result->num_rows > 0) {
		foreach ($prices_array as $price_id => $count) {
			$sql = "UPDATE 4w_accounting SET count = '" . $count . "', volunteer_name = '" . $_POST['name'] . "' WHERE price_type_id = '" . $price_id
				. "' AND date = '" . $_POST['date'] . "' AND time = '" . $_POST['time']  . "' AND branch_id = '" . $_POST['branch_id']
				. "' AND class_type = '" . $_POST['class_type'] . "' AND level = '" . $_POST['level'] . "';";
			$result = $connection_4w->query($sql);
		}
	} else {
		foreach ($prices_array as $price_id => $count) {
			$sql = "INSERT INTO 4w_accounting (date, time, branch_id, class_type, level, price_type_id, count, volunteer_name) VALUES "
				. "('" . $_POST['date'] . "', '" . $_POST['time'] . "', '" . $_POST['branch_id'] . "', '" . $_POST['class_type'] . "', '"
				. $_POST['level'] . "', '" . $price_id . "', '" . $count . "', '" . $_POST['name'] . "');";
			$result = $connection_4w->query($sql);
		}
	}
}

$get_data = isset($_POST['get_data']);

if ($get_data) {
	$result = countsExist($_POST, $connection_4w);
	if ($result->num_rows > 0) {
		$volunteer_name = "";
		$return_json = array();
		$return_json['prices_array'] = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$return_json['volunteer_name'] = $row['volunteer_name'];
			$return_json['prices_array'][$row['price_type_id']] = $row['count'];
		}
		echo json_encode($return_json);
		return;
	} else {
		return;
	}
}

// =============================
// 3. INITIALIZATION
// =============================

$summary_url = getCurrentBranchUrl($_POST, $connection_4w, "summary")

// =============================
// 4. SUCCESS PAGE
// =============================
?>
<style>
	@font-face {
		font-family: 'Avenir';
		src: url(fonts/Avenir.ttc);
		src: url(fonts/Avenir-Book.woff) format('woff');
		src: url(fonts/Avenir-Book.ttf) format('truetype');
	}

	body {
		font-family: 'Avenir', 'Open Sans', Helvetica Neue, sans-serif !important;
		background-color: #3a98cb !important;
		color: white !important;
		font-weight: 500;
		text-align: center;
		margin: auto;
	}

	div.message {
		text-align: center;
		margin: 80px auto;
		width: 400px;
		font-size: 2em;
		font-weight: bold;
	}

	a.btn {
		font-family: 'Avenir', 'Open Sans', Helvetica Neue, sans-serif !important;
	}
</style>
<link rel='stylesheet' id='parallax-one-bootstrap-style-css'  href='http://4waterdev.org/prague/language/wp-content/themes/Parallax-One/css/bootstrap.min.css?ver=3.3.1' type='text/css' media='all' />
<div class="container">
	<div class="message">
		Hooray!
		<br />
		Your counts were saved!
		<br />
	</div>
	<a class="btn btn-info btn-lg" href="<?php echo $summary_url ?>">Continue to the summary</a>
</div>


