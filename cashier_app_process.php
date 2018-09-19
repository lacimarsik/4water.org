<?php
// =============================
// CASHIER APP - V1.0 Process part

// Form part: cashier_app_process.php (in the theme folder)
// Summary part: cashier_app_process.php (in the theme folder)

// Javascript part: cashier_app.js (in the theme folder)

// OUTLINE
// 1. FUNCTIONS
// 2. INITIALIZATION
// 3. AJAX / FORM HANDLING
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

function countsExist($post, $connection, $current_season) {
	$sql= "SELECT * FROM 4w_accounting WHERE date = '" . $post['date'] . "' AND time = '" . $post['time']
		. "' AND branch_id = '" . $post['branch_id'] . "' AND class_type = '" . $post['class_type'] . "' AND level = '" . $post['level'] . "' AND season = '" . $current_season . "';";
	$result = $connection->query($sql);
	return $result;
}

function getCurrentBranchUrl($post, $connection, $suffix) {
	$sql= "SELECT * FROM 4w_branches WHERE id = '" . $post['branch_id'] . "';";
	$result = $connection->query($sql);
	$row = mysqli_fetch_assoc($result);
	return '/' . strtolower($row['city']) . '/' . strtolower($row['activity']) . '/' . $suffix;
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

// Find branch ID from POST variable
$branch_id = $_POST['branch_id'];

// Find proper timezone
$timezone = findTimezone($connection_4w, $branch_id);
date_default_timezone_set($timezone);

// Find current season
$current_season = findCurrentSeason($connection_4w, $branch_id);

// Find URL for the link
$summary_url = getCurrentBranchUrl($_POST, $connection_4w, "summary");

// =============================
// 3. AJAX / FORM HANDLING
// =============================

$form_submitted = (isset($_POST['increment']) || isset($_POST['decrement']) || isset($_POST['submitform'])) && !isset($_POST['resuls']);

if ($form_submitted) {
	$prices_array = getArrayOfPrices($_POST);
	$result = countsExist($_POST, $connection_4w, $current_season);
	if ($result->num_rows > 0) {
		foreach ($prices_array as $price_id => $count) {
			$sql = "UPDATE 4w_accounting SET count = '" . $count . "', volunteer_name = '" . $_POST['name'] . "' WHERE price_type_id = '" . $price_id
				. "' AND date = '" . $_POST['date'] . "' AND time = '" . $_POST['time']  . "' AND branch_id = '" . $_POST['branch_id']
				. "' AND class_type = '" . $_POST['class_type'] . "' AND level = '" . $_POST['level'] . "' AND season = '" . $current_season . "';";
			$result = $connection_4w->query($sql);
		}
	} else {
		foreach ($prices_array as $price_id => $count) {
			$sql = "INSERT INTO 4w_accounting (date, time, branch_id, class_type, level, price_type_id, count, volunteer_name, season) VALUES "
				. "('" . $_POST['date'] . "', '" . $_POST['time'] . "', '" . $_POST['branch_id'] . "', '" . $_POST['class_type'] . "', '"
				. $_POST['level'] . "', '" . $price_id . "', '" . $count . "', '" . $_POST['name'] . "', '" . $current_season . "');";
			$result = $connection_4w->query($sql);
		}
	}
}

$get_data = isset($_POST['get_data']);

if ($get_data) {
	$result = countsExist($_POST, $connection_4w, $current_season);
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
<div class="container bootstrap">
	<div class="message">
		Hooray!
		<br />
		Your counts were saved!
		<br />
	</div>
	<a class="btn btn-info btn-lg continue" href="<?php echo $summary_url ?>">Continue to the summary</a>
</div>


