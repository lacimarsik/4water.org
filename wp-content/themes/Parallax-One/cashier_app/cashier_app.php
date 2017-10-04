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
			$prices_array[substr($key, 5, 1)] = $val;
		}
	}
	return $prices_array;
}

function countsExist($post, $connection) {
	$sql= "SELECT COUNT(*) FROM 4w_accounting WHERE date = '" . $post['date'] . "' AND time = '" . $post['time']
		. "' AND branch_id = '" . $post['branch_id'] . "' AND class_type = '" . $post['class_type'] . "' AND level = '" . $post['level'] . "';";
	$result = $connection->query($sql);
	return ($result > 0);
}

// =============================
// 2. AJAX / FORM HANDLING
// =============================

if (isset($_POST['increment']) || isset($_POST['decrement']) || isset($_POST['submitform'])) {
	$prices_array = getArrayOfPrices($_POST);
	if (countsExist($_POST, $connection_4w)) {
		foreach ($prices_array as $price_id => $count) {
			$sql = "UPDATE 4w_accounting SET count = '" . $count . "', volunteer_name = '" . $_POST['name'] . "' WHERE price_type_id = '" . $price_id . "';";
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
	<script>
		if (!window.jQuery) {
			document.write('<script src="http://4water.org/wp-content/themes/Parallax-One/js/jquery-1.11.3.js"><\/script>');
		}
	</script>
	<script src="http://4water.org/wp-content/themes/Parallax-One/js/angular.min.js"></script>
	<title>Cashier - Success | 4Water</title>
	<meta name="description" itemprop="description"
	      content="Welcome, dear cashier. On this page you count the number of attendees and add new email subscriptions (when someone buys 10-time pass). When you are done your"/>
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

$sql= "SELECT * FROM 4w_accounting a JOIN 4w_branch_prices p ON a.price_type_id = p.id JOIN 4w_branches b ON a.branch_id = b.id;";
$result = $connection_4w->query($sql);

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
				</article>
				<table class="report">
					<thead style="font-weight: bold; border-botom: 1px solid black;">
						<tr>
							<td>Branch</td><td>Class</td><td>Level</td><td>Date</td><td>Time</td><td>Price Type</td><td>Price</td><td>Count</td><td>Money made</td><td>Cashier</td>
						</tr>
					</thead>
<?php
	while ($row = mysqli_fetch_assoc($result)) {
		echo '<tr>';
		echo '<td>' . $row['activity'] . '4Water ' . $row['city'] . '</td>';
		echo '<td>' . $row['class_type'] . '</td>';
		echo '<td>' . $row['level'] . '</td>';
		echo '<td>' . $row['date'] . '</td>';
		echo '<td>' . $row['time'] . '</td>';
		echo '<td>' . $row['price_type'] . '</td>';
		echo '<td>' . $row['price'] . ' ' . $row['currency'] . '</td>';
		echo '<td>' . $row['count'] . '</td>';
		echo '<td>' . intval($row['price']) * intval($row['count']) . ' ' . $row['currency'] . '</td>';
		echo '<td>' . $row['volunteer_name'] . '</td>';
		echo '</tr>';
	}
?>
				</table>
			</main>
		</div>
	</div>
</body>