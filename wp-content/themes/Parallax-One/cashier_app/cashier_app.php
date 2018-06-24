<?php
// =============================
// CASHIER APP - PROTOTYPE //
// =============================

require_once('wp-config.php');
$connection_4w = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysqli_select_db($connection_4w, DB_NAME);

// =============================
// 1. FUNCTIONS
// =============================

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

function getCurrentBranchUrl($post, $connection) {
	$sql= "SELECT * FROM 4w_branches WHERE id = '" . $post['branch_id'] . "';";
	$result = $connection->query($sql);
	$row = mysqli_fetch_assoc($result);
	return '/' . strtolower($row['city']) . '/' . strtolower($row['activity']) . '/cashier';
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

$form_submitted = isset($_POST['increment']) || isset($_POST['decrement']) || isset($_POST['submitform']);

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
// 3. DUMMY HEADER TAKEN FROM 4water.org
// =============================
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js" type="text/javascript"></script>

	<script>
		if (!window.jQuery) {
			document.write('<script src="http://4water.org/wp-content/themes/Parallax-One/js/jquery-1.11.3.js"><\/script>');
		}
	</script>
	<script src="http://4water.org/wp-content/themes/Parallax-One/js/angular.min.js"></script>
	<title>Cashier - Success | 4Water</title>
	<meta name="description" itemprop="description"
	      content="Welcome, dear cashier. On this page you count the number of attendees and add new email subscriptions (when someone buys 10-time pass). When you are done your"/>
	<link rel="stylesheet" href="/wp-content/themes/Parallax-One/cashier_app/cashier_app.css">
	<script src="/wp-content/themes/Parallax-One/cashier_app/highcharts/js/highcharts.js"></script>
	<script src="/wp-content/themes/Parallax-One/cashier_app/highcharts/js/modules/data.js"></script>
	<script src="/wp-content/themes/Parallax-One/cashier_app/highcharts/js/modules/exporting.js"></script>
	<link href="/wp-content/themes/Parallax-One/cashier_app/css/charts.css"  rel="stylesheet" type='text/css' />

	<link rel='stylesheet' id='menu-image-css'
	      href='http://4water.org/wp-content/plugins/menu-image/menu-image.css?ver=1.1' type='text/css' media='all'/>
	<link rel='stylesheet' id='parallax-one-bootstrap-style-css'
	      href='http://4water.org/wp-content/themes/Parallax-One/css/bootstrap.min.css?ver=3.3.1' type='text/css'
	      media='all'/>
	<link rel='stylesheet' id='parallax-one-style-css'
	      href='http://4water.org/wp-content/themes/Parallax-One/style.css?ver=1.0.0' type='text/css' media='all'/>
	<script type='text/javascript' src='http://4water.org/wp-includes/js/jquery/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript'
	        src='http://4water.org/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
	<link rel='https://api.w.org/' href='http://4water.org/wp-json/'/>
	<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://4water.org/xmlrpc.php?rsd"/>
	<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://4water.org/wp-includes/wlwmanifest.xml"/>
	<meta name="generator" content="WordPress 4.4.3"/>
	<!--[if lt IE 9]>
	<script src="http://4water.org/wp-content/themes/Parallax-One/js/html5shiv.min.js"></script>
	<![endif]-->
	<style type="text/css">.recentcomments a {
			display: inline !important;
			padding: 0 !important;
			margin: 0 !important;
		}</style>
	<style type="text/css">
		.sf-widget-wrapper h3.widget-title {
			font-size: 14px;
			margin: 0;
		}

		.sf-widget-wrapper .sf-widget-text {
			line-height: 18px;
			padding-left: 8px;
			font-size: 10px;
		}

		.sf-widget-wrapper .sf-widget-text .sf-widget-emphasize {
			font-style: normal;
		}
	</style>
</head>
<body class="home blog">

<header class="header header-style-one" data-stellar-background-ratio="0.5" id="home">
	<!-- COLOR OVER IMAGE -->
	<div class="overlay-layer-nav sticky-navigation-open">
		<!-- STICKY NAVIGATION -->
		<div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation appear-on-scroll"
		     role="navigation">
			<!-- CONTAINER -->
			<div class="container">
				<!-- NAVBAR HEADER -->
				<div class="navbar-header">
					<!-- LOGO (SMALL SCREENS ONLY) -->
					<div class="logo-small-screens">
						<a href="http://4water.org/" class="navbar-brand" title="4Water"><img
								src="http://4water.org/wp-content/uploads/sites/1/2016/08/4Water_menu-1.png"
								alt="4Water"></a>
						<div class="header-logo-wrap paralax_one_only_customizer"><h1 class='site-title'><a
									href='http://4water.org/' title='4Water' rel='home'>4Water</a></h1>
							<h2 class='site-description'>We exchange skills to raise money for WaterAid</h2></div>
					</div>
					<!-- /END LOGO (SMALL SCREENS ONLY) -->
					<!-- COLLAPSED MENU -->
					<div class="collapsed-menu-wrapper">
						<button type="button" class="navbar-toggle" data-toggle="collapse"
						        data-target="#stamp-navigation">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<!-- HEADER WIDGET (SMALL SCREENS ONLY) -->
						<div class="header-widget-small-screens">
							<div id="widget_sp_image-4" class="widget widget_sp_image"><a href="http://4water.org" id=""
							                                                              target="_blank"
							                                                              class="widget_sp_image-image-link"
							                                                              title="4Water" rel=""><img
										width="80" height="26" alt="4Water" class="attachment-80x26"
										style="max-width: 100%;"
										src="http://www.4water.org/wp-content/uploads/sites/1/2016/08/4Water_menu.png"/></a>
							</div>
						</div>
						<!-- /END HEADER WIDGET (SMALL SCREENS ONLY) -->
					</div>
					<!-- /END COLLAPSED MENU -->
				</div>
				<!-- /END NAVBAR HEADER -->

				<!-- MENU -->
				<div class="navbar-collapse collapse" id="stamp-navigation">
					<ul id="menu-4water-menu" class="nav navbar-nav navbar-right main-navigation">
						<li id="menu-item-123"
						    class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-123">
							<a href="http://4water.org" class='menu-image-title-hide menu-image-not-hovered'><span
									class="menu-image-title">4Water</span><img width="475" height="238"
							                                                   src="http://4water.org/wp-content/uploads/sites/1/2016/08/4Water_menu-1.png"
							                                                   class="menu-image menu-image-title-hide"
							                                                   alt="4Water_menu"
							                                                   srcset="http://4water.org/wp-content/uploads/sites/1/2016/08/4Water_menu-1-300x150.png 300w, http://4water.org/wp-content/uploads/sites/1/2016/08/4Water_menu-1-24x12.png 24w, http://4water.org/wp-content/uploads/sites/1/2016/08/4Water_menu-1-36x18.png 36w, http://4water.org/wp-content/uploads/sites/1/2016/08/4Water_menu-1-48x24.png 48w, http://4water.org/wp-content/uploads/sites/1/2016/08/4Water_menu-1.png 475w"
							                                                   sizes="(max-width: 475px) 100vw, 475px"/></a>
						</li>
						<li id="menu-item-121"
						    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-121">
							<a href="#" class='menu-image-title-after'><span
									class="menu-image-title">Choose a city</span></a>
							<ul class="sub-menu">
								<li id="menu-item-158"
								    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-158">
									<a href="http://4water.org/berlin" class='menu-image-title-after'><span
											class="menu-image-title">Berlin</span></a>
									<ul class="sub-menu">
										<li id="menu-item-197"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-197">
											<a href="http://4water.org/berlin"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Berlin4Water</span><img width="2530"
											                                                         height="784"
											                                                         src="http://4water.org/wp-content/uploads/sites/1/2017/09/BERLIN4WATER.png"
											                                                         class="menu-image menu-image-title-hide"
											                                                         alt="Berlin4Water Logo"
											                                                         srcset="http://4water.org/wp-content/uploads/sites/1/2017/09/BERLIN4WATER-300x93.png 300w, http://4water.org/wp-content/uploads/sites/1/2017/09/BERLIN4WATER-1024x317.png 1024w, http://4water.org/wp-content/uploads/sites/1/2017/09/BERLIN4WATER.png 2530w"
											                                                         sizes="(max-width: 2530px) 100vw, 2530px"/></a>
										</li>
										<li id="menu-item-205"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-205">
											<a href="http://4water.org/berlin/salsa"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Salsa4Water</span><img width="784"
											                                                        height="467"
											                                                        src="http://4water.org/wp-content/uploads/sites/1/2017/09/salsa4Water_logo_indent-1.png"
											                                                        class="menu-image menu-image-title-hide"
											                                                        alt="salsa4Water_logo_indent"
											                                                        srcset="http://4water.org/wp-content/uploads/sites/1/2017/09/salsa4Water_logo_indent-1-300x179.png 300w, http://4water.org/wp-content/uploads/sites/1/2017/09/salsa4Water_logo_indent-1.png 784w"
											                                                        sizes="(max-width: 784px) 100vw, 784px"/></a>
										</li>
									</ul>
								</li>
								<li id="menu-item-180"
								    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-180">
									<a href="http://4water.org/cardiff/dance" class='menu-image-title-after'><span
											class="menu-image-title">Cardiff</span></a>
									<ul class="sub-menu">
										<li id="menu-item-181"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-181">
											<a href="http://4water.org/cardiff/dance"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Salsa4Water</span><img width="475"
											                                                        height="238"
											                                                        src="http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2.png"
											                                                        class="menu-image menu-image-title-hide"
											                                                        alt="Salsa4Water_menu"
											                                                        srcset="http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2-300x150.png 300w, http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2-24x12.png 24w, http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2-36x18.png 36w, http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2-48x24.png 48w, http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2.png 475w"
											                                                        sizes="(max-width: 475px) 100vw, 475px"/></a>
										</li>
									</ul>
								</li>
								<li id="menu-item-53"
								    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-53">
									<a href="http://4water.org/copenhagen/dance" class='menu-image-title-after'><span
											class="menu-image-title">Copenhagen</span></a>
									<ul class="sub-menu">
										<li id="menu-item-47"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-47">
											<a href="http://4water.org/copenhagen/dance"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Dance4Water</span><img width="475"
											                                                        height="238"
											                                                        src="http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu.png"
											                                                        class="menu-image menu-image-title-hide"
											                                                        alt="Dance4Water_menu"
											                                                        srcset="http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-300x150.png 300w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-24x12.png 24w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-36x18.png 36w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-48x24.png 48w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu.png 475w"
											                                                        sizes="(max-width: 475px) 100vw, 475px"/></a>
										</li>
									</ul>
								</li>
								<li id="menu-item-52"
								    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-52">
									<a href="http://4water.org/glasgow/dance" class='menu-image-title-after'><span
											class="menu-image-title">Glasgow</span></a>
									<ul class="sub-menu">
										<li id="menu-item-124"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-124">
											<a href="http://4water.org/glasgow/dance"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Dance4Water</span><img width="475"
											                                                        height="238"
											                                                        src="http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu.png"
											                                                        class="menu-image menu-image-title-hide"
											                                                        alt="Dance4Water_menu"
											                                                        srcset="http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-300x150.png 300w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-24x12.png 24w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-36x18.png 36w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-48x24.png 48w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu.png 475w"
											                                                        sizes="(max-width: 475px) 100vw, 475px"/></a>
										</li>
										<li id="menu-item-56"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-56">
											<a href="http://4water.org/glasgow/language/"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Language4Water</span><img width="475"
											                                                           height="238"
											                                                           src="http://4water.org/wp-content/uploads/sites/1/2016/08/Language4Water_menu.png"
											                                                           class="menu-image menu-image-title-hide"
											                                                           alt="Language4Water_menu"
											                                                           srcset="http://4water.org/wp-content/uploads/sites/1/2016/08/Language4Water_menu-300x150.png 300w, http://4water.org/wp-content/uploads/sites/1/2016/08/Language4Water_menu-24x12.png 24w, http://4water.org/wp-content/uploads/sites/1/2016/08/Language4Water_menu-36x18.png 36w, http://4water.org/wp-content/uploads/sites/1/2016/08/Language4Water_menu-48x24.png 48w, http://4water.org/wp-content/uploads/sites/1/2016/08/Language4Water_menu.png 475w"
											                                                           sizes="(max-width: 475px) 100vw, 475px"/></a>
										</li>
									</ul>
								</li>
								<li id="menu-item-54"
								    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-54">
									<a href="http://4water.org/kuwait/dance" class='menu-image-title-after'><span
											class="menu-image-title">Kuwait</span></a>
									<ul class="sub-menu">
										<li id="menu-item-125"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-125">
											<a href="http://4water.org/kuwait/dance"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Dance4Water</span><img width="475"
											                                                        height="238"
											                                                        src="http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu.png"
											                                                        class="menu-image menu-image-title-hide"
											                                                        alt="Dance4Water_menu"
											                                                        srcset="http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-300x150.png 300w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-24x12.png 24w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-36x18.png 36w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-48x24.png 48w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu.png 475w"
											                                                        sizes="(max-width: 475px) 100vw, 475px"/></a>
										</li>
									</ul>
								</li>
								<li id="menu-item-50"
								    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-50">
									<a href="http://4water.org/linkoping/dance" class='menu-image-title-after'><span
											class="menu-image-title">Linköping</span></a>
									<ul class="sub-menu">
										<li id="menu-item-126"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-126">
											<a href="http://4water.org/linkoping/dance"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Dance4Water</span><img width="475"
											                                                        height="238"
											                                                        src="http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu.png"
											                                                        class="menu-image menu-image-title-hide"
											                                                        alt="Dance4Water_menu"
											                                                        srcset="http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-300x150.png 300w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-24x12.png 24w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-36x18.png 36w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-48x24.png 48w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu.png 475w"
											                                                        sizes="(max-width: 475px) 100vw, 475px"/></a>
										</li>
									</ul>
								</li>
								<li id="menu-item-49"
								    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-49">
									<a href="http://4water.org/lyon/dance" class='menu-image-title-after'><span
											class="menu-image-title">Lyon</span></a>
									<ul class="sub-menu">
										<li id="menu-item-127"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-127">
											<a href="http://4water.org/lyon/dance"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Salsa4Water</span><img width="475"
											                                                        height="238"
											                                                        src="http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2.png"
											                                                        class="menu-image menu-image-title-hide"
											                                                        alt="Salsa4Water_menu"
											                                                        srcset="http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2-300x150.png 300w, http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2-24x12.png 24w, http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2-36x18.png 36w, http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2-48x24.png 48w, http://4water.org/wp-content/uploads/sites/1/2016/09/salsa4water_aligned_2.png 475w"
											                                                        sizes="(max-width: 475px) 100vw, 475px"/></a>
										</li>
										<li id="menu-item-55"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-55">
											<a href="http://4water.org/lyon/climbing"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Climbing4Water</span><img width="475"
											                                                           height="238"
											                                                           src="http://4water.org/wp-content/uploads/sites/1/2016/08/Climbing4Water_menu.png"
											                                                           class="menu-image menu-image-title-hide"
											                                                           alt="Climbing4Water_menu"
											                                                           srcset="http://4water.org/wp-content/uploads/sites/1/2016/08/Climbing4Water_menu-300x150.png 300w, http://4water.org/wp-content/uploads/sites/1/2016/08/Climbing4Water_menu-24x12.png 24w, http://4water.org/wp-content/uploads/sites/1/2016/08/Climbing4Water_menu-36x18.png 36w, http://4water.org/wp-content/uploads/sites/1/2016/08/Climbing4Water_menu-48x24.png 48w, http://4water.org/wp-content/uploads/sites/1/2016/08/Climbing4Water_menu.png 475w"
											                                                           sizes="(max-width: 475px) 100vw, 475px"/></a>
										</li>
									</ul>
								</li>
								<li id="menu-item-51"
								    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-51">
									<a href="http://4water.org/manchester/yoga" class='menu-image-title-after'><span
											class="menu-image-title">Manchester</span></a>
									<ul class="sub-menu">
										<li id="menu-item-128"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-128">
											<a href="http://4water.org/manchester/yoga"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Yoga4Water</span><img width="475"
											                                                       height="238"
											                                                       src="http://4water.org/wp-content/uploads/sites/1/2017/02/Yoga4Water_menu.png"
											                                                       class="menu-image menu-image-title-hide"
											                                                       alt="Yoga4Water_menu"
											                                                       srcset="http://4water.org/wp-content/uploads/sites/1/2017/02/Yoga4Water_menu-300x150.png 300w, http://4water.org/wp-content/uploads/sites/1/2017/02/Yoga4Water_menu-24x12.png 24w, http://4water.org/wp-content/uploads/sites/1/2017/02/Yoga4Water_menu-36x18.png 36w, http://4water.org/wp-content/uploads/sites/1/2017/02/Yoga4Water_menu-48x24.png 48w, http://4water.org/wp-content/uploads/sites/1/2017/02/Yoga4Water_menu.png 475w"
											                                                       sizes="(max-width: 475px) 100vw, 475px"/></a>
										</li>
									</ul>
								</li>
								<li id="menu-item-48"
								    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-48">
									<a href="http://4water.org/prague/dance" class='menu-image-title-after'><span
											class="menu-image-title">Prague</span></a>
									<ul class="sub-menu">
										<li id="menu-item-129"
										    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-129">
											<a href="http://4water.org/prague/dance"
											   class='menu-image-title-hide menu-image-not-hovered'><span
													class="menu-image-title">Dance4Water</span><img width="475"
											                                                        height="238"
											                                                        src="http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu.png"
											                                                        class="menu-image menu-image-title-hide"
											                                                        alt="Dance4Water_menu"
											                                                        srcset="http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-300x150.png 300w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-24x12.png 24w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-36x18.png 36w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu-48x24.png 48w, http://4water.org/wp-content/uploads/sites/1/2016/08/Dance4Water_menu.png 475w"
											                                                        sizes="(max-width: 475px) 100vw, 475px"/></a>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li id="menu-item-140"
						    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-140"><a
								href="#call-to-action" class='menu-image-title-after'><span class="menu-image-title">Contribute</span></a>
						</li>
						<li id="menu-item-141"
						    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-141"><a
								href="#why-us" class='menu-image-title-after'><span
									class="menu-image-title">Water</span></a></li>
						<li id="menu-item-36"
						    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-36"><a
								href="#contactinfo" class='menu-image-title-after'><span class="menu-image-title">Contact</span></a>
						</li>
					</ul>
				</div>
				<!-- /END MENU -->
				<!-- HEADER WIDGET MEDIUM SCREENS -->
				<div class="header-widget-medium-screens">
					<div id="widget_sp_image-3" class="widget widget_sp_image"><a href="http://4water.org" id=""
					                                                              target="_blank"
					                                                              class="widget_sp_image-image-link"
					                                                              title="4Water" rel=""><img width="80"
					                                                                                         height="26"
					                                                                                         alt="4Water"
					                                                                                         class="attachment-80x26"
					                                                                                         style="max-width: 100%;"
					                                                                                         src="http://www.4water.org/wp-content/uploads/sites/1/2016/08/4Water_menu.png"/></a>
					</div>
				</div>
				<!-- /END HEADER WIDGET MEDIUM SCREENS -->
				<!-- HEADER WIDGET -->
				<div class="header-widget">
					<div id="widget_sp_image-2" class="widget widget_sp_image"><a href="http://4water.org" id=""
					                                                              target="_self"
					                                                              class="widget_sp_image-image-link"
					                                                              title="4Water" rel=""><img width="80"
					                                                                                         height="26"
					                                                                                         alt="4Water"
					                                                                                         class="attachment-80x26"
					                                                                                         style="max-width: 100%;"
					                                                                                         src="http://www.4water.org/wp-content/uploads/sites/1/2016/08/4Water_menu.png"/></a>
					</div>
					<div class="sf-widget-wrapper">
						<div id="simple_fundraising_widget-2" class="widget widget_simple_fundraising_widget">
							<div class="sf-widget-text">
								<em class="sf-widget-emphasize">
									£105,354.00 </em>
								raised to date
							</div>
						</div>
					</div>
				</div>
				<!-- /END HEADER WIDGET -->
			</div>
			<!-- /END CONTAINER -->
		</div>
		<!-- /END STICKY NAVIGATION -->

	</div>
	<!-- /END COLOR OVER IMAGE -->
</header>
<?php
// =============================
// 4. CASHIER APP VIEW
// =============================
?>
<div class="content-wrap">
	<div class="container">

		<div id="primary" class="content-area col-md-12">
			<main id="main" class="site-main" role="main">
				<article id="post-38" class="post-38 page type-page status-publish hentry">
					<header class="entry-header">
						<h1 class="entry-title single-title">Cashier</h1>
						<div class="colored-line-left"></div>
						<div class="clearfix"></div>
						<div class="cashier-done">Thank you for cashiering! Below are the counts and money made.</div>
				</article>
<?php

// Set proper timezone
$sql= "SELECT * FROM 4w_branches WHERE id = '" . $_POST['branch_id'] . "';";
$result = $connection_4w->query($sql);
$row = mysqli_fetch_assoc($result);
$timezone = $row['timezone'];
date_default_timezone_set($timezone);

$last_lesson = get_last_lesson($connection_4w, $_POST['branch_id']);

$sql= "SELECT * FROM 4w_accounting a JOIN 4w_branch_prices p ON a.price_type_id = p.id JOIN 4w_branches b ON a.branch_id = b.id WHERE b.id = " . $_POST['branch_id']. " AND a.date = '" . date('Y-m-d', $last_lesson[0]) . "'";
$result = $connection_4w->query($sql);

$total = 0;
$students = 0;
$students_manual = 0;
$currency = "";
$volunteer_name = "";

if (date('Y-m-d', $last_lesson[0]) == date('Y-m-d')) {
?>
				<h2 class="report-heading">Today</h2>
<?php
} else {
?>
				<h2 class="report-heading">Last class</h2>
<?php
}

?>
				<table class="table table-striped">
<?php
					while ($row = mysqli_fetch_assoc($result)) {
						$currency = $row['currency'];
						$volunteer_name = $row['volunteer_name'];
						$total += intval($row['price']) * intval($row['count']);
						if ($row['totals'] != "yes") {
							$students += intval($row['count']);
						} else {
							$students_manual = ($students_manual < $row['count']) ? $row['count'] : $students_manual;
						}
						echo '<tr>';
						echo '<td><strong class="bold">' . $row['price_type'] . '</strong></td>';
						echo '<td><span>' . $row['count'] . '</span></td>';
						echo '<td><span>' . intval($row['price']) * intval($row['count']) . ' ' . $row['currency'] . '</span></td>';
						echo '</tr>';
					}
?>
				<?php $total_students = ($students_manual > $students) ? $students_manual : $students; ?>
				<tr class="success"><td><strong class="medium bold">Totals</strong></td><td><span class="medium"><?php echo $total_students; ?></span></td><td><span class="medium"><?php echo $total; ?> <?php echo $currency; ?></span></td></tr>
				</table>
				<p>Counted by: <strong class="bold"><?php echo $volunteer_name; ?></strong></p>
<?php
				if ($form_submitted) {
					$last_lesson = get_last_lesson($connection_4w, $_POST['branch_id']);
					$branch_url = getCurrentBranchUrl($_POST, $connection_4w); ?>
					<form action="<?php echo $branch_url; ?>" id="return-form" method="post">
						<input type="hidden" name="return" value="true">
						<input type="hidden" name="datetime" value="<?php echo $last_lesson[0]; ?>">
						<input type="hidden" name="class" value="<?php echo $last_lesson[1]; ?>">
						<input type="hidden" name="level" value="<?php echo $last_lesson[2]; ?>">
						<input class="submit-button" type="submit" value="Edit last class (<?php echo $last_lesson[1] . ' ' . $last_lesson[2] . ')'; ?>">
					</form>
<?php
				}
?>
				<script type="text/javascript">
					$(function() {
							Highcharts.setOptions( {
									lang: {
										decimalPoint: ",", thousandsSep: " "
									}
								}
							);
							Highcharts.getData=function(table, options) {
								var sliceNames=[];
								$("th", table).each(function(i) {
										if(i>0) {
											sliceNames.push(this.innerHTML)
										}
									}
								);
								options.series=[];
								$("tr", table).each(function(i) {
										var tr=this;
										$("th, td", tr).each(function(j) {
												if(j>0) {
													if(i==0) {
														options.series[j-1]= {
															name: this.innerHTML, data: []
														}
													}
													else {
														if(i==1) {
															options.series[j-1].data.push( {
																	sliced: true, selected: true, name: sliceNames[i-1], y: parseFloat(this.innerHTML)
																}
															)
														}
														else {
															options.series[j-1].data.push( {
																	name: sliceNames[i-1], y: parseFloat(this.innerHTML)
																}
															)
														}
													}
												}
											}
										)
									}
								)
							}
						}

					);
					$(function() {
							Highcharts.setOptions( {
									colors: ["#3bb479", "#4a99e3"]
								}
							);
							var table=document.getElementById("datatable_for_chart1");
							$("#chart1").highcharts( {
									data: {
										table: table
									}
									, chart: {
										type: "column"
									}
									, title: {
										text: table.caption.innerHTML
									}
									, xAxis: {}
									, yAxis: {
										title: {
											text: "<?php echo $currency; ?>"
										}
										, stackLabels: {
											enabled:true, style: {
												fontWeight: "bold", color: (Highcharts.theme&&Highcharts.theme.textColor)||"gray"
											}
											, formatter:function() {
												return Highcharts.numberFormat(this.total, "0")+" <?php echo $currency; ?>"
											}
										}
										, labels: {
											formatter:function() {
												return this.value
											}
										}
									}
									, tooltip: {
										formatter:function() {
											if(this.series.name=="Students") {
												return"Students: "+Highcharts.numberFormat(this.y, "2f")+" <?php echo $currency; ?><br/>"+"<b>All: "+Highcharts.numberFormat(this.point.stackTotal, "2f")+" <?php echo $currency; ?></b>"
											}
											else {
												return"Non-Students: "+Highcharts.numberFormat(this.y, "2f")+" <?php echo $currency; ?><br/>"+"<b>All: "+Highcharts.numberFormat(this.point.stackTotal, "2f")+" <?php echo $currency; ?></b>"
											}
										}
									}
									, plotOptions: {
										column: {
											stacking:"normal", dataLabels: {
												enabled:true, color:(Highcharts.theme&&Highcharts.theme.dataLabelsColor)||"white", style: {
													textShadow: "0 0 3px black, 0 0 3px black"
												}
												, formatter:function() {
													return Highcharts.numberFormat(this.point.y, "0")+" <?php echo $currency; ?>"
												}
											}
										}
									}
									, series:[ {
										pointWidth: 50
									}
										, {
											pointWidth: 50
										}
									]
								}
							)

						Highcharts.setOptions( {
								colors: ["#4a99e3", "#3bb479", "#434348", "#f9913d", "#7b62b5", "#db4646", "#abb479"]
							}
						);
						var table=document.getElementById("datatable_for_chart2");
						$("#chart2").highcharts( {
								data: {
									table: table
								}
								, chart: {
									type: "column"
								}
								, title: {
									text: table.caption.innerHTML
								}
								, xAxis: {}
								, yAxis: {
									title: {
										text: "Attended"
									}
									, stackLabels: {
										enabled:true, style: {
											fontWeight: "bold", color: (Highcharts.theme&&Highcharts.theme.textColor)||"gray"
										}
										, formatter:function() {
											return Highcharts.numberFormat(this.total, "0")
										}
									}
									, labels: {
										formatter:function() {
											return this.value
										}
									}
								}
								, tooltip: {
									formatter:function() {
										return "<b>Week "+(this.x + 1)+"</b><br/>"+"<b>"+this.series.name+": "+Highcharts.numberFormat(this.y, "2f")+"</b>"
									}
								}
								, plotOptions: {
									column: {
										stacking:"normal", dataLabels: {
											enabled:true, color:(Highcharts.theme&&Highcharts.theme.dataLabelsColor)||"white", style: {
												textShadow: "0 0 3px black, 0 0 3px black"
											}
											, formatter:function() {
												return ''//Highcharts.numberFormat(this.point.y, "0")
											}
										}
									}
								}
								, series:[ {
										pointWidth: 30
									}
									, {
										pointWidth: 30
									}, {
									pointWidth: 30
								}, {
									pointWidth: 30
								}, {
									pointWidth: 30
								}, {
									pointWidth: 30
								}, {
									pointWidth: 30
								}
								]
							}
						)
						}

					);
					$(function() {
							Highcharts.setOptions( {
									colors: ["#4a99e3", "#3bb479", "#434348", "#f9913d", "#7b62b5", "#db4646"]
								}
							);
						}

					);
				</script>
<?php
$sql= 'SELECT EXTRACT(YEAR_MONTH FROM a.date) as month, sum(case when p.student = 1 then (a.count * p.price) else 0 end) as students_money_made, sum(case when p.student = 0 then (a.count * p.price) else 0 end) as non_students_money_made, p.currency FROM 4w_accounting a JOIN 4w_branch_prices p ON a.price_type_id = p.id JOIN 4w_branches b ON a.branch_id = b.id WHERE a.branch_id = "' . $_POST['branch_id'] . '" GROUP BY month ORDER BY month;';
$result = $connection_4w->query($sql);
?>

				<h2 class="report-heading">Monthly</h2>
					<div id="chart1" class="report-column-small">
					</div>

					<table id="datatable_for_chart1" class="report-datatable">
						<caption>Money collected</caption>
						<thead>
						<tr>
							<th>Month</th>
							<th>Students</th>
							<th>Non-Students</th>
						</tr>
						</thead>
						<tbody>
<?php
						while ($row = mysqli_fetch_assoc($result)) {
?>
							<tr>
								<td><?php echo date('F', mktime(0, 0, 0, substr($row['month'], 4), 10)) . " " . substr($row['month'], 0, 4); ?></td>
								<td><?php echo $row['students_money_made']; ?></td>
								<td><?php echo $row['non_students_money_made']; ?></td>
							</tr>
<?php
						}
$sql= 'SELECT WEEK(date, 1) as week, sum(case when (WEEKDAY(date) = 0) then (a.count) else 0 end) as attendance_monday, sum(case when (WEEKDAY(date) = 1) then (a.count) else 0 end) as attendance_tuesday, sum(case when (WEEKDAY(date) = 2) then (a.count) else 0 end) as attendance_wednesday, sum(case when (WEEKDAY(date) = 3) then (a.count) else 0 end) as attendance_thursday, sum(case when (WEEKDAY(date) = 4) then (a.count) else 0 end) as attendance_friday, sum(case when (WEEKDAY(date) = 5) then (a.count) else 0 end) as attendance_saturday, sum(case when (WEEKDAY(date) = 6) then (a.count) else 0 end) as attendance_sunday FROM 4w_accounting a JOIN 4w_branch_prices p ON a.price_type_id = p.id JOIN 4w_branches b ON a.branch_id = b.id WHERE a.branch_id = "' . $_POST['branch_id'] . '" GROUP BY week ORDER BY week;';
$result = $connection_4w->query($sql);

// @param $week [int]
// @param $year [string]
// @return [date] the first day of the week, given weeknumber and year
function getFirstDayDate($week, $year)
{
	$time = strtotime("1 January $year", time());
	$day = date('w', $time);
	$time += ((7*$week)+1-$day)*24*3600;
	return date('Y-n-j', $time);
}
?>

<h2 class="report-heading">Weekly attendance</h2>
<div id="chart2" class="report-column-small">
</div>

<table id="datatable_for_chart2" class="report-datatable">
	<caption>Attendance</caption>
	<thead>
	<tr>
		<th>Week</th>
		<th>Monday</th>
		<th>Tuesday</th>
		<th>Wednesday</th>
		<th>Thursday</th>
		<th>Friday</th>
		<th>Saturday</th>
		<th>Sunday</th>
	</tr>
	</thead>
	<tbody>
	<?php
	while ($row = mysqli_fetch_assoc($result)) {
		$first_day = strftime("%d.%m", getFirstDayDate($row['week'], '2018'));
		$week_number_from_october = (($row['week'] - 39) > 0) ? ($row['week'] - 39) :  ($row['week'] + 15);
		?>
		<tr>
			<td><?php echo "Week " . $week_number_from_october; ?></td>
			<td><?php echo $row['attendance_monday']; ?></td>
			<td><?php echo $row['attendance_tuesday']; ?></td>
			<td><?php echo $row['attendance_wednesday']; ?></td>
			<td><?php echo $row['attendance_thursday']; ?></td>
			<td><?php echo $row['attendance_friday']; ?></td>
			<td><?php echo $row['attendance_saturday']; ?></td>
			<td><?php echo $row['attendance_sunday']; ?></td>
		</tr>
		<?php
		echo "<!--" . $first_day . "-->";
	}
	?>
						</tbody>
					</table>

				</div>
<?php
	if ($form_submitted) {
		$branch_url = getCurrentBranchUrl($_POST, $connection_4w);
		$closest_lesson = get_closest_lesson($connection_4w, $_POST['branch_id']);
?>
				<div class="report-footer">
				<a href="<?php echo $branch_url; ?>"><button>Cashier next class (<?php echo $closest_lesson[1] . ' ' . $closest_lesson[2] . ')'; ?></button></a>
				</div>
<?php
	}
?>
			</main>
		</div>
	</div>
</body>