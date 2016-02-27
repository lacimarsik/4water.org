<?php
/*
Plugin Name: Intergeo Maps - Google Maps Plugin
Plugin URI: http://plugins.svn.wordpress.org/intergeo-maps/
Description: A simple, easy and quite powerful Google Map tool to create, manage and embed custom Google Maps into your WordPress posts and pages. The plugin allows you to deeply customize look and feel of a map, add overlays like markers, rectangles, circles, polylines and polygons to your map. It could even be integraded with your Google Adsense account and show ad on your maps.
Version: 1.0.2
Author: Themeisle
Author URI: http://themeisle.com
License: GPL v2.0 or later
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

// <editor-fold defaultstate="collapsed" desc="constants">

define( 'INTERGEO_PLUGIN_NAME', 'intergeo' ); // don't change it whatever
define( 'INTERGEO_VERSION',     '1.0.2' );
define( 'INTERGEO_ABSPATH',     dirname( __FILE__ ) );
define( 'INTERGEO_ABSURL',      plugins_url( '/', __FILE__ ) );
// Added by Ash/Upwork
defined('WPLANG') || define( 'WPLANG', '' );
// Added by Ash/Upwork

// Added by Ash/Upwork
if ( class_exists( 'IntergeoMaps_Pro', false ) ){
    define( 'IntergeoMaps_Pro', true);
}
// Added by Ash/Upwork

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="plugin init">

add_filter( 'plugin_action_links', 'intergeo_action_links', 10, 2 );
function intergeo_action_links( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ ) ) {
		array_unshift(
			$links,
			sprintf( '<a href="%s">%s</a>', add_query_arg( 'page', INTERGEO_PLUGIN_NAME, admin_url( 'upload.php' ) ), __( "Maps", INTERGEO_PLUGIN_NAME ) ),
			sprintf( '<a href="%s">%s</a>', admin_url( 'options-media.php' ), __( "Settings", INTERGEO_PLUGIN_NAME ) )
		);
	}
	return $links;
}

add_action( 'admin_init', 'intergeo_admin_init' );
function intergeo_admin_init() {
	load_plugin_textdomain( INTERGEO_PLUGIN_NAME, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	register_post_type( INTERGEO_PLUGIN_NAME );
}

add_action( 'wp_enqueue_scripts', 'intergeo_frontend_enqueue_scripts' );
function intergeo_frontend_enqueue_scripts() {
	wp_register_style( 'intergeo-frontend', INTERGEO_ABSURL . 'css/frontend.css', array(), INTERGEO_VERSION );
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="settings">

add_filter( 'whitelist_options', 'intergeo_whitelist_options' );
function intergeo_whitelist_options( $whitelist ) {
	$whitelist['media'][] = 'intergeo_map_api_key';
	$whitelist['media'][] = 'intergeo_adsense_publisher_id';
	return $whitelist;
}

add_action( 'admin_init', 'intergeo_settings_init' );
function intergeo_settings_init() {
	register_setting( 'media', 'intergeo-settings-map-api-key', 'trim' );
	add_settings_section( 'intergeo-settings-maps', 'Intergeo Google Maps', 'intergeo_settings_init_map', 'media' );
	add_settings_field( 'intergeo_map_api_key', 'Maps API Key', 'intergeo_settings_print_field', 'media', 'intergeo-settings-maps', array(
		'<input type="text" name="%s" value="%s" class="regular-text">',
		'intergeo_map_api_key',
		esc_attr( get_option( 'intergeo_map_api_key' ) ),
	) );

	register_setting( 'media', 'intergeo_adsense_publisher_id', 'trim' );
	add_settings_section( 'intergeo-settings-adsense', 'Intergeo Google Maps AdSense Integration', 'intergeo_settings_init_adsense', 'media' );
	add_settings_field( 'intergeo_adsense_publisher_id', 'AdSense Publisher Id', 'intergeo_settings_print_field', 'media', 'intergeo-settings-adsense', array(
		'<input type="text" name="%s" value="%s" class="regular-text">',
		'intergeo_adsense_publisher_id',
		esc_attr( get_option( 'intergeo_adsense_publisher_id' ) ),
	) );
}

function intergeo_settings_init_map() {
	?><p><?php
	printf( esc_html__( "All Maps API applications should load the Maps API using an API key (however it is still possible to use maps without API key). Using an API key enables you to monitor your application's Maps API usage, and ensures that Google can contact you about your application if necessary. If your application's Maps API usage exceeds the %sUsage Limits%s, you must load the Maps API using an API key in order to purchase additional quota. To create your API key:", INTERGEO_PLUGIN_NAME ), '<a href="https://developers.google.com/maps/documentation/javascript/usage#usage_limits" target="_blank">', '</a>' );
	?></p>
	<ol>
		<li><?php printf( esc_html__( "Visit the APIs Console at %shttps://code.google.com/apis/console%s and log in with your Google Account.", INTERGEO_PLUGIN_NAME ), '<a href="https://code.google.com/apis/console" target="_blank">', '</a>' ) ?></li>
		<li><?php printf( esc_html__( 'Click the %sServices%s link from the left-hand menu.', INTERGEO_PLUGIN_NAME ), '<b>', '</b>' ) ?></li>
		<li><?php printf( esc_html__( 'Activate the %sGoogle Maps API v3%s service.', INTERGEO_PLUGIN_NAME ), '<b>', '</b>' ) ?></li>
		<li><?php printf( esc_html__( 'Click the %1$sAPI Access%2$s link from the left-hand menu. Your API key is available from the %1$sAPI Access%2$s page, in the %1$Simple API Access%2$s section. Maps API applications use the %1$sKey for browser apps%2$s.', INTERGEO_PLUGIN_NAME ), '<b>', '</b>' ) ?></li>
	</ol>
	<?php
}

function intergeo_settings_init_adsense() {
	?><p><?php
		printf( esc_html__( "Adding display ads to your map requires that you have an AdSense account enabled for AdSense for Content. If you don't yet have an AdSense account, %1\$ssign up%3\$s for one. Once you have done so (or if you already have an account) make sure you've also enabled the account with %2\$sAdSense for Content%3\$s.", INTERGEO_PLUGIN_NAME ), '<a href="https://www.google.com/adsense/support/bin/answer.py?answer=10162" target="_blank">', '<a href="https://www.google.com/adsense/support/bin/answer.py?hl=en&answer=17470" target="_blank">', '</a>' )
	?></p><p><?php
		esc_html_e( 'Once you have an Adsense for Content account, you will have received an AdSense for Content (AFC) publisher ID. This publisher ID is used to link any advertising shown to your AdSense account, allowing you to share in advertising revenue when a user clicks on one of the ads shown on your maps.', INTERGEO_PLUGIN_NAME )
	?></p><?php
}

function intergeo_settings_print_field( array $args ) {
	vprintf( array_shift( $args ), $args );
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="common">

function intergeo_enqueue_google_maps_script( $libraries = false ) {
	global $wp_scripts;

	if ( is_array( $libraries ) ) {
		$libraries = implode( ',', $libraries );
	}

	if ( wp_script_is( 'google-maps-v3' ) ) {

		$params = array();
		parse_str( end( explode( '?', $wp_scripts->registered['google-maps-v3']->src ) ), $params );
		$params['libraries'] = implode( ',', array_unique( array_merge( isset( $params['libraries'] ) ? explode( ',', $params['libraries'] ) : array(), explode( ',', $libraries ) ) ) );
		$wp_scripts->registered['google-maps-v3']->src = '//maps.googleapis.com/maps/api/js?' . http_build_query( $params );

	} else {

		$lang = explode( '_', WPLANG ? WPLANG : 'en_US' );
		$params = array(
			'v'         => '3.10',
			'sensor'    => 'false',
			'region'    => isset( $lang[1] ) ? $lang[1] : 'US',
			'language'  => $lang[0],
		);

		if ( !empty( $libraries ) ) {
			$params['libraries'] = $libraries;
		}

		$api_key = get_option( 'intergeo_map_api_key' );
		if ( !empty( $api_key ) ) {
			$params['key'] = $api_key;
		}

		wp_enqueue_script( 'google-maps-v3', '//maps.googleapis.com/maps/api/js?' . http_build_query( $params ), array(), null );

	}
}

function intergeo_check_libraries( $json, $libraries = array() ) {
	if ( isset( $json['layer']['adsense'] ) && $json['layer']['adsense'] && !in_array( 'adsense', $libraries ) ) {
		$libraries[] = 'adsense';
	}

	if ( isset( $json['layer']['panoramio'] ) && $json['layer']['panoramio'] && !in_array( 'panoramio', $libraries ) ) {
		$libraries[] = 'panoramio';
	}

	if ( ( isset( $json['layer']['weather'] ) && $json['layer']['weather'] ) || ( isset( $json['layer']['cloud'] ) && $json['layer']['cloud'] ) ) {
		if ( !in_array( 'weather', $libraries ) ) {
			$libraries[] = 'weather';
		}
	}

	return $libraries;
}

function intergeo_encode( $id ) {
	return strrev( rtrim( call_user_func( 'base64_' . 'encode', $id ), '=' ) );
}

function intergeo_decode( $code ) {
	return intval( call_user_func( 'base64' . '_decode', strrev( $code ) ) );
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="iframe">

// <editor-fold defaultstate="collapsed" desc="rendering">

add_filter( 'media_upload_tabs', 'intergeo_media_upload_tabs' );
function intergeo_media_upload_tabs( $tabs ) {
	$tabs['intergeo_map'] = __( 'Intergeo Maps', INTERGEO_PLUGIN_NAME );
	return $tabs;
}

add_action( 'media_upload_intergeo_map', 'intergeo_map_popup_init' );
function intergeo_map_popup_init() {
	$post_id = filter_input( INPUT_GET, 'post_id', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
	$map_id = filter_input( INPUT_GET, 'map' );

	$send_to_editor = false;
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$shortcode = intergeo_save_map( $map_id, $post_id );
		if ( $post_id ) {
			$send_to_editor = $shortcode;
		} else {
			$args = array(
				'page'    => INTERGEO_PLUGIN_NAME,
				'updated' => date( 'YmdHis' ),
			);
			wp_redirect( add_query_arg( $args, admin_url( 'upload.php' ) ) );
			exit;
		}
	}

	intergeo_enqueue_google_maps_script( 'adsense,panoramio,weather,drawing' );

	wp_enqueue_script( 'intergeo-editor', INTERGEO_ABSURL . 'js/editor.js', array( 'wp-color-picker', 'google-maps-v3', 'jquery' ), INTERGEO_VERSION );
	wp_localize_script( 'intergeo-editor', 'intergeo_options', array(
		'send_to_editor' => $send_to_editor,
		'adsense'        => array( 'publisher_id' => get_option( 'intergeo_adsense_publisher_id' ) ),
		'ajaxurl'        => admin_url( 'admin-ajax.php' ),
		'nonce'          => wp_create_nonce( 'editor_popup' . filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP ) ),
		'l10n'           => array(
			'marker' => __( 'marker', INTERGEO_PLUGIN_NAME ),
			'error' => array(
				'style'      => __( 'Styles are broken. Please, fix it and try again.', INTERGEO_PLUGIN_NAME ),
				'directions' => __( 'Direction was not found.', INTERGEO_PLUGIN_NAME ),
			),
		),
	) );

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'intergeo-editor', INTERGEO_ABSURL . 'css/editor.css', array(), INTERGEO_VERSION );

    // Added by Ash/Upwork
    if( defined( 'IntergeoMaps_Pro' ) ){
        global $IntergeoMaps_Pro;
        $IntergeoMaps_Pro->enqueueScriptsAndStyles(array('intergeo-editor'), array("mapID" => $map_id));
    }
    // Added by Ash/Upwork

	wp_iframe( 'intergeo_iframe', $post_id, $map_id );
}

function intergeo_iframe( $post_id = false, $map_id = false ) {
	$publisher_id = trim( get_option( 'intergeo_adsense_publisher_id' ) );
	$show_map_center = get_option( 'intergeo_show_map_center', true );

	$submit_text = __( 'Insert into post', INTERGEO_PLUGIN_NAME );

	if ( !$post_id ) {
		$submit_text = __( 'Create the map', INTERGEO_PLUGIN_NAME );
	}

	$copy = false;
	if ( !$map_id ) {
		$copy = true;
		$map_id = filter_input( INPUT_GET, 'copy' );
	}

	$json = array();
	if ( $map_id ) {
		$map = get_post( intergeo_decode( $map_id ) );
		if ( $map->post_type == INTERGEO_PLUGIN_NAME ) {
			$json = json_decode( $map->post_content, true );
			if ( !$copy ) {
				$submit_text = __( 'Update the map', INTERGEO_PLUGIN_NAME );
			}
		}
	}

	require INTERGEO_ABSPATH . '/templates/iframe/form.php';
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="filtering">

function intergeo_filter_value( $value, $array ) {
	$value = strtoupper( $value );
	return !in_array( $value, $array ) ? null : $value;
}

function intergeo_filter_position( $position ) {
	return intergeo_filter_value( $position, array(
		'TOP_LEFT',     'TOP_CENTER',    'TOP_RIGHT',
		'RIGHT_TOP',    'RIGHT_CENTER',  'RIGHT_BOTTOM',
		'BOTTOM_RIGHT', 'BOTTOM_CENTER', 'BOTTOM_LEFT',
		'LEFT_BOTTOM',  'LEFT_CENTER',   'LEFT_TOP'
	) );
}

function intergeo_filter_map_type( $type ) {
	return intergeo_filter_value( $type, array( 'ROADMAP', 'TERRAIN', 'SATELLITE', 'HYBRID' ) );
}

function intergeo_filter_map_type_style( $style ) {
	return intergeo_filter_value( $style, array( 'DEFAULT', 'DROPDOWN_MENU', 'HORIZONTAL_BAR' ) );
}

function intergeo_filter_zoom_style( $style ) {
	return intergeo_filter_value( $style, array( 'DEFAULT', 'SMALL', 'LARGE' ) );
}

function intergeo_filter_wind_speed_units( $unit ) {
	return intergeo_filter_value( $unit, array( 'KILOMETERS_PER_HOUR', 'METERS_PER_SECOND', 'MILES_PER_HOUR' ) );
}

function intergeo_filter_temperature_units( $unit ) {
	return intergeo_filter_value( $unit, array( 'CELSIUS', 'FAHRENHEIT' ) );
}

function intergeo_filter_adsense_format( $format ) {
	return intergeo_filter_value( $format, array(
		'BANNER',
		'BUTTON',
		'HALF_BANNER',
		'LARGE_HORIZONTAL_LINK_UNIT',
		'LARGE_RECTANGLE',
		'LARGE_VERTICAL_LINK_UNIT',
		'LEADERBOARD',
		'MEDIUM_RECTANGLE',
		'MEDIUM_VERTICAL_LINK_UNIT',
		'SKYSCRAPER',
		'SMALL_HORIZONTAL_LINK_UNIT',
		'SMALL_RECTANGLE',
		'SMALL_SQUARE',
		'SMALL_VERTICAL_LINK_UNIT',
		'SQUARE',
		'VERTICAL_BANNER',
		'WIDE_SKYSCRAPER',
		'X_LARGE_VERTICAL_LINK_UNIT',
	) );
}

function intergeo_filter_custom_style( $style ) {
	$style = trim( $style );
	$json = @json_decode( $style, true );

	return empty( $json ) ? null : $json;
}

function intergeo_filter_overlays_marker( $marker ) {
	if ( !isset( $marker['position'] ) || !preg_match( '/^-?\d+\.?\d*,-?\d+\.?\d*$/', $marker['position'] ) ) {
		return false;
	}

	return array(
		'position' => explode( ',', $marker['position'] ),
		'icon'     => isset( $marker['icon'] ) ? filter_var( $marker['icon'], FILTER_VALIDATE_URL ) : '',
		'info'     => isset( $marker['info'] ) ? trim( preg_replace( '/\<\/?script.*?\>/is', '', $marker['info'] ) ) : '',
		'title'    => isset( $marker['title'] ) ? strip_tags( trim( $marker['title'] ) ) : '',
	);
}

function intergeo_filter_overlays_polyline( $polyline ) {
	if ( !isset( $polyline['path'] ) ) {
		return false;
	}

	$path = array();
	foreach( explode( ';', $polyline['path'] ) as $point ) {
		if ( preg_match( '/^-?\d+\.?\d*,-?\d+\.?\d*$/', $point ) ) {
			$path[] = explode( ',', $point );
		}
	}

	if ( count( $path ) < 2 ) {
		return false;
	}

	return array(
		'path'    => $path,
		'weight'  => isset( $polyline['weight'] )
			? filter_var( $polyline['weight'], FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1, 'default' => '' ) ) )
			: '',
		'opacity' => isset( $polyline['opacity'] )
			? filter_var( $polyline['opacity'], FILTER_VALIDATE_FLOAT, array( 'options' => array( 'min_range' => 0, 'max_range' => 1, 'default' => '' ) ) )
			: '',
		'color'   => isset( $polyline['color'] )
			? filter_var( $polyline['color'], FILTER_VALIDATE_REGEXP, array( 'options' => array( 'regexp' => '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', 'default' => '#000000' ) ) )
			: '#000000',
	);
}

function intergeo_filter_overlays_polyoverlay( $polygon ) {
	if ( !isset( $polygon['path'] ) ) {
		return false;
	}

	$path = array();
	foreach( explode( ';', $polygon['path'] ) as $point ) {
		if ( preg_match( '/^-?\d+\.?\d*,-?\d+\.?\d*$/', $point ) ) {
			$path[] = explode( ',', $point );
		}
	}

	if ( count( $path ) < 2 ) {
		return false;
	}

	$position = isset( $polygon['position'] ) ? strtoupper( trim( $polygon['position'] ) ) : 'CENTER';

	return array(
		'path'           => $path,
		'position'       => in_array( $position, array( 'CENTER', 'INSIDE', 'OUTSIDE' ) ) ? $position : 'CENTER',
		'weight'         => isset( $polygon['weight'] ) ? filter_var( $polygon['weight'], FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1, 'default' => '' ) ) ) : '',
		'stroke_opacity' => isset( $polygon['stroke_opacity'] ) ? filter_var( $polygon['stroke_opacity'], FILTER_VALIDATE_FLOAT, array( 'options' => array( 'min_range' => 0, 'max_range' => 1, 'default' => '' ) ) ) : '',
		'stroke_color'   => isset( $polygon['stroke_color'] ) ? filter_var( $polygon['stroke_color'], FILTER_VALIDATE_REGEXP, array( 'options' => array( 'regexp' => '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', 'default' => '#000000' ) ) ) : '#000000',
		'fill_opacity'   => isset( $polygon['fill_opacity'] ) ? filter_var( $polygon['fill_opacity'], FILTER_VALIDATE_FLOAT, array( 'options' => array( 'min_range' => 0, 'max_range' => 1, 'default' => '' ) ) ) : '',
		'fill_color'     => isset( $polygon['fill_color'] ) ? filter_var( $polygon['fill_color'], FILTER_VALIDATE_REGEXP, array( 'options' => array( 'regexp' => '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', 'default' => '#000000' ) ) ) : '#000000',
	);
}

function intergeo_filter_directions( $direction ) {
	$to = isset( $direction['to'] ) ? trim( $direction['to'] ) : '';
	$from = isset( $direction['from'] ) ? trim( $direction['from'] ) : '';

	if ( empty( $to ) || empty( $from ) ) {
		return false;
	}

	$mode = isset( $direction['mode'] ) ? strtoupper( trim( $direction['mode'] ) ) : 'DRIVING';

	return array(
		'mode' => in_array( $mode, array( 'BICYCLING', 'DRIVING', 'TRANSIT', 'WALKING' ) ) ? $mode : 'DRIVING',
		'from' => $from,
		'to'   => $to,
	);
}

function intergeo_filter_input() {
	$color_regexp = '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/';
	$postion_filter = array( 'filter' => FILTER_CALLBACK, 'options' => 'intergeo_filter_position' );

	$validationArray = array (
		'lat'                                   => array( 'filter' => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_SCALAR, 'options' => array( 'min_range' => -90, 'max_range' => 90, 'default' => 48.1366069 ) ),
		'lng'                                   => array( 'filter' => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_SCALAR, 'options' => array( 'min_range' => -180, 'max_range' => 180, 'default' => 11.577085099999977 ) ),
		'zoom'                                  => array( 'filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_SCALAR, 'options' => array( 'min_range' => 0, 'max_range' => 19, 'default' => 5 ) ),
		'address'                               => FILTER_SANITIZE_STRING,
		'map_mapTypeId'                         => array( 'filter' => FILTER_CALLBACK, 'options' => 'intergeo_filter_map_type' ),
		'map_draggable'                         => FILTER_VALIDATE_BOOLEAN,
		'map_minZoom'                           => array( 'filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_SCALAR, 'options' => array( 'min_range' => 0, 'max_range' => 19, 'default' => 0 ) ),
		'map_maxZoom'                           => array( 'filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_SCALAR, 'options' => array( 'min_range' => 0, 'max_range' => 19, 'default' => 19 ) ),
		'map_scrollwheel'                       => FILTER_VALIDATE_BOOLEAN,
		'map_zoomControl'                       => FILTER_VALIDATE_BOOLEAN,
		'map_zoomControlOptions_position'       => $postion_filter,
		'map_zoomControlOptions_style'          => array( 'filter' => FILTER_CALLBACK, 'options' => 'intergeo_filter_zoom_style' ),
		'map_panControl'                        => FILTER_VALIDATE_BOOLEAN,
		'map_panControlOptions_position'        => $postion_filter,
		'map_scaleControl'                      => FILTER_VALIDATE_BOOLEAN,
		'map_scaleControlOptions_position'      => $postion_filter,
		'map_mapTypeControl'                    => FILTER_VALIDATE_BOOLEAN,
		'map_mapTypeControlOptions_position'    => $postion_filter,
		'map_mapTypeControlOptions_style'       => array( 'filter' => FILTER_CALLBACK, 'options' => 'intergeo_filter_map_type_style' ),
		'map_mapTypeControlOptions_mapTypeIds'  => array( 'filter' => FILTER_CALLBACK, 'flags' => FILTER_REQUIRE_ARRAY, 'options' => 'intergeo_filter_map_type' ),
		'map_streetViewControl'                 => FILTER_VALIDATE_BOOLEAN,
		'map_streetViewControlOptions_position' => $postion_filter,
		'map_rotateControl'                     => FILTER_VALIDATE_BOOLEAN,
		'map_rotateControlOptions_position'     => $postion_filter,
		'map_overviewMapControl'                => FILTER_VALIDATE_BOOLEAN,
		'map_overviewMapControlOptions_opened'  => FILTER_VALIDATE_BOOLEAN,
		'layer_traffic'                         => FILTER_VALIDATE_BOOLEAN,
		'layer_bicycling'                       => FILTER_VALIDATE_BOOLEAN,
		'layer_cloud'                           => FILTER_VALIDATE_BOOLEAN,
		'layer_weather'                         => FILTER_VALIDATE_BOOLEAN,
		'weather_temperatureUnits'              => array( 'filter' => FILTER_CALLBACK, 'options' => 'intergeo_filter_temperature_units' ),
		'weather_windSpeedUnits'                => array( 'filter' => FILTER_CALLBACK, 'options' => 'intergeo_filter_wind_speed_units' ),
		'layer_panoramio'                       => FILTER_VALIDATE_BOOLEAN,
		'panoramio_tag'                         => FILTER_SANITIZE_STRING,
		'panoramio_userId'                      => FILTER_SANITIZE_STRING,
		'layer_adsense'                         => FILTER_VALIDATE_BOOLEAN,
		'adsense_format'                        => array( 'filter' => FILTER_CALLBACK, 'options' => 'intergeo_filter_adsense_format' ),
		'adsense_position'                      => $postion_filter,
		'adsense_backgroundColor'               => array( 'filter' => FILTER_VALIDATE_REGEXP, 'options' => array( 'regexp' => $color_regexp, 'default' => '#c4d4f3' ) ),
		'adsense_borderColor'                   => array( 'filter' => FILTER_VALIDATE_REGEXP, 'options' => array( 'regexp' => $color_regexp, 'default' => '#e5ecf9' ) ),
		'adsense_titleColor'                    => array( 'filter' => FILTER_VALIDATE_REGEXP, 'options' => array( 'regexp' => $color_regexp, 'default' => '#0000cc' ) ),
		'adsense_textColor'                     => array( 'filter' => FILTER_VALIDATE_REGEXP, 'options' => array( 'regexp' => $color_regexp, 'default' => '#000000' ) ),
		'adsense_urlColor'                      => array( 'filter' => FILTER_VALIDATE_REGEXP, 'options' => array( 'regexp' => $color_regexp, 'default' => '#009900' ) ),
		'container_width'                       => FILTER_SANITIZE_STRING,
		'container_height'                      => FILTER_SANITIZE_STRING,
		'container_styles'                      => FILTER_SANITIZE_STRING,
		'styles_type'                           => FILTER_SANITIZE_STRING,
		'styles_custom'                         => array( 'filter' => FILTER_CALLBACK, 'options' => 'intergeo_filter_custom_style' ),
		'overlays_marker'                       => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
		'overlays_polyline'                     => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
		'overlays_polygon'                      => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
		'overlays_rectangle'                    => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
		'overlays_circle'                       => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
		'directions'                            => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
	);

	$defaults = array (
		'lat'                                   => 48.1366069,
		'lng'                                   => 11.577085099999977,
		'zoom'                                  => 5,
		'address'                               => '',
		'map_mapTypeId'                         => 'ROADMAP',
		'map_draggable'                         => true,
		'map_minZoom'                           => 0,
		'map_maxZoom'                           => 19,
		'map_scrollwheel'                       => true,
		'map_zoomControl'                       => true,
		'map_zoomControlOptions_position'       => null,
		'map_zoomControlOptions_style'          => 'DEFAULT',
		'map_panControl'                        => true,
		'map_panControlOptions_position'        => null,
		'map_scaleControl'                      => false,
		'map_scaleControlOptions_position'      => null,
		'map_mapTypeControl'                    => true,
		'map_mapTypeControlOptions_position'    => null,
		'map_mapTypeControlOptions_style'       => 'DEFAULT',
		'map_mapTypeControlOptions_mapTypeIds'  => array( 'ROADMAP', 'TERRAIN', 'SATELLITE', 'HYBRID' ),
		'map_streetViewControl'                 => true,
		'map_streetViewControlOptions_position' => null,
		'map_rotateControl'                     => true,
		'map_rotateControlOptions_position'     => null,
		'map_overviewMapControl'                => false,
		'map_overviewMapControlOptions_opened'  => false,
		'layer_traffic'                         => false,
		'layer_bicycling'                       => false,
		'layer_cloud'                           => false,
		'layer_weather'                         => false,
		'weather_temperatureUnits'              => null,
		'weather_windSpeedUnits'                => null,
		'layer_panoramio'                       => false,
		'panoramio_tag'                         => '',
		'panoramio_userId'                      => '',
		'layer_adsense'                         => false,
		'adsense_format'                        => null,
		'adsense_position'                      => null,
		'adsense_backgroundColor'               => '#c4d4f3',
		'adsense_borderColor'                   => '#e5ecf9',
		'adsense_titleColor'                    => '#0000cc',
		'adsense_textColor'                     => '#000000',
		'adsense_urlColor'                      => '#009900',
		'container_width'                       => '',
		'container_height'                      => '',
		'container_styles'                      => '',
		'styles_type'                           => 'DEFAULT',
		'styles_custom'                         => null,
		'overlays_marker'                       => array(),
		'overlays_polyline'                     => array(),
		'overlays_polygon'                      => array(),
		'overlays_rectangle'                    => array(),
		'overlays_circle'                       => array(),
		'directions'                            => array(),
	);

    // Added by Ash/Upwork
    if( defined( 'IntergeoMaps_Pro' ) ){
        global $IntergeoMaps_Pro;
        $IntergeoMaps_Pro->addValidations($validationArray, $defaults);
    }
    // Added by Ash/Upwork

	$options = filter_input_array( INPUT_POST, $validationArray );

	$results = array();
	foreach ( $options as $key => $value ) {
		if ( array_key_exists( $key, $defaults ) ) {
			$equals = $defaults[$key] == $value;
			if ( is_array( $value ) ) {
				$equals = ( count( $value ) == count( $defaults[$key] ) ) && ( count( array_diff( (array)$defaults[$key], $value ) ) == 0 );
			}

			if ( !$equals ) {
				$results[$key] = $value;
			}
		}
	}

	if ( !empty( $results['overlays_marker'] ) ) {
		$results['overlays_marker'] = array_filter( array_map( 'intergeo_filter_overlays_marker',  $results['overlays_marker'] ) );
	}

	if ( !empty( $results['overlays_polyline'] ) ) {
		$results['overlays_polyline'] = array_filter( array_map( 'intergeo_filter_overlays_polyline',  $results['overlays_polyline'] ) );
	}

	if ( !empty( $results['directions'] ) ) {
		$results['directions'] = array_filter( array_map( 'intergeo_filter_directions',  $results['directions'] ) );
	}

	foreach ( array( 'polygon', 'rectangle', 'circle' ) as $overlay ) {
		$overlay = 'overlays_' . $overlay;
		if ( !empty( $results[$overlay] ) ) {
			$results[$overlay] = array_filter( array_map( 'intergeo_filter_overlays_polyoverlay',  $results[$overlay] ) );
		}
	}

    // Added by Ash/Upwork
    if( defined( 'IntergeoMaps_Pro' ) ){
        global $IntergeoMaps_Pro;
        $IntergeoMaps_Pro->processResults($results);
    }
    // Added by Ash/Upwork

	return $results;
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="saving">

function intergeo_save_map( $map_id = false, $post_id = false ) {
	$options = array();
	$array_ptr = &$options;
	foreach ( intergeo_filter_input() as $key => $value ) {
		if ( !is_null( $value ) ) {
			$keys = explode( '_', $key );
			$last_key = array_pop( $keys );

			while ( $arr_key = array_shift( $keys ) ) {
				if ( !array_key_exists( $arr_key, $array_ptr ) ) {
					$array_ptr[$arr_key] = array( );
				}
				$array_ptr = &$array_ptr[$arr_key];
			}

			$array_ptr[$last_key] = $value;
			$array_ptr = &$options;
		}
	}

	$address = '';
	if ( !empty( $options['address'] ) ) {
		$address = $options['address'] = trim( $options['address'] );
	}

	$args = array(
		'post_type'    => INTERGEO_PLUGIN_NAME,
		'post_content' => addcslashes( json_encode( $options ), '\\' ),
		'post_status'  => 'private',
	);

	$update = false;
	if ( $map_id ) {
		$post = get_post( intergeo_decode( $map_id ) );
		if ( $post && $post->post_type == INTERGEO_PLUGIN_NAME ) {
			$update = true;
			$args['ID'] = $post->ID;
		}
	}

	$id = wp_insert_post( $args );

	if ( !empty( $id ) && !is_wp_error( $id ) ) {
		if ( !$post_id ) {
			intergeo_set_info( $update
				? __( 'The map has been updated successfully.', INTERGEO_PLUGIN_NAME )
				: __( 'The map has been created successfully.', INTERGEO_PLUGIN_NAME )
			);
		}
		return sprintf( '[intergeo id="%s"]%s[/intergeo]', intergeo_encode( $id ), $address );
	}

	if ( !$post_id ) {
		intergeo_set_error( $update
			? __( 'The map updating failed.', INTERGEO_PLUGIN_NAME )
			: __( 'The map creation failed.', INTERGEO_PLUGIN_NAME )
		);
	}

	return false;
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="ajax stuff">

add_action( 'wp_ajax_intergeo_show_map_center', 'intergeo_show_map_center_changed' );
function intergeo_show_map_center_changed() {
	$nonce = filter_input( INPUT_POST, 'nonce' );
	if ( wp_verify_nonce( $nonce, 'editor_popup' . filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP ) ) ) {
		update_option( 'intergeo_show_map_center', (int)filter_input( INPUT_POST, 'status', FILTER_VALIDATE_BOOLEAN ) );
	}
}

// </editor-fold>

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="shortcode">

add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'term_description', 'do_shortcode' );

add_shortcode( INTERGEO_PLUGIN_NAME, 'intergeo_shortcode' );
function intergeo_shortcode( $attrs, $address = '' ) {
	$args = shortcode_atts( array(
		'id'     => false,
		'hook'   => false,
		'width'  => false,
		'height' => false,
		'style'  => false,
		'zoom'   => false,
	), $attrs );

	$address = trim( $address );
	if ( empty( $args['id'] ) && empty( $address ) ) {
		return '';
	}

	$json = array();
	if ( !empty( $args['id'] ) ) {
		$post = get_post( intergeo_decode( $args['id'] ) );
		if ( !$post || $post->post_type != INTERGEO_PLUGIN_NAME ) {
			return '';
		}

		$json = json_decode( $post->post_content, true );
	} else {
		$args['id'] = intergeo_encode( rand( 0, 100 ) . rand( 0, 10000 ) );
		$json['zoom'] = intval( $args['zoom'] ) ? intval( $args['zoom'] ) : 15;
	}

	if ( !empty( $address ) ) {
		$json['address'] = $address;
	}

	if ( trim( $args['hook'] ) != '' ) {
		$json = apply_filters( $args['hook'], $json );
	}

	wp_enqueue_style( 'intergeo-frontend' );
	intergeo_enqueue_google_maps_script( intergeo_check_libraries( $json ) );
	if ( !wp_script_is( 'intergeo-rendering' ) ) {
		wp_enqueue_script( 'intergeo-rendering', INTERGEO_ABSURL . 'js/rendering.js', array( 'jquery', 'google-maps-v3' ), INTERGEO_VERSION );
		wp_localize_script( 'intergeo-rendering', 'intergeo_options', array(
			'adsense' => array( 'publisher_id' => get_option( 'intergeo_adsense_publisher_id' ) )
		) );
	}

	$container = array();
	if ( isset( $json['container'] ) ) {
		$container = $json['container'];
		unset( $json['container'] );
	}

	$width = !empty( $container['width'] ) ? esc_attr( $container['width'] ) : '100%';
	if ( trim( $args['width'] ) != '' ) {
		$width = $args['width'];
	}
	if ( is_numeric( $width ) ) {
		$width .= 'px';
	}

	$height = !empty( $container['height'] ) ? esc_attr( $container['height'] ) : '300px';
	if ( trim( $args['height'] ) != '' ) {
		$height = $args['height'];
	}
	if ( is_numeric( $height ) ) {
		$height .= 'px';
	}

	$styles = !empty( $container['styles'] ) ? esc_attr( $container['styles'] ) : '';
	if ( trim( $args['style'] ) != '' ) {
		$styles = $args['style'];
	}

	return sprintf( '
		<div id="intergeo_map%1$s" class="intergeo_map_canvas" style="width:100%%;height:300px;width:%2$s;height:%3$s;%4$s"></div>
		<script type="text/javascript">
			/* <![CDATA[ */
			if (!window.intergeo_maps) window.intergeo_maps = [];
			window.intergeo_maps.push( { container: \'intergeo_map%1$s\', options: %5$s } );
			if (!window.intergeo_maps_current) window.intergeo_maps_current = null;
			/* ]]> */
		</script>
		',
		$args['id'],
		$width,
		$height,
		$styles,
		json_encode( $json )
	);
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="library">

add_action( 'admin_menu', 'intergeo_admin_menu' );
function intergeo_admin_menu() {
	$page = add_submenu_page( 'upload.php', 'Intergeo Maps Library', 'Intergeo Maps', 'edit_posts', INTERGEO_PLUGIN_NAME, 'intergeo_library' );
	if ( $page ) {
		add_action( "load-{$page}", 'intergeo_library_init' );
	}
}

function intergeo_library_init() {
	wp_enqueue_style( 'intergeo_library', INTERGEO_ABSURL . 'css/library.css', array(), INTERGEO_VERSION );
	wp_enqueue_media();

	$screen = get_current_screen();

	$screen->add_help_tab( array(
		'title'   => esc_html__( 'Overview', INTERGEO_PLUGIN_NAME ),
		'id'      => 'overview',
		'content' => sprintf( '<p>%s</p>', implode( '</p><p>', array(
			esc_html__( "The library is a list to view all maps you have created in your system. The library is showing you 3x3 grid of maps' previews. You will see the same maps embedded into your posts at front end, as you see here. The library is paginated and if you have more than 9 maps, you will see pagination links under maps grid.", INTERGEO_PLUGIN_NAME ),
			esc_html__( 'To create a new map, click on "Add New" button next to the page title and map editor popup will appear. In case you want to edit a map, you can click on pencil icon in the right bottom corner of map preview box and edit popup window will appear.', INTERGEO_PLUGIN_NAME ),
			esc_html__( "If you want to delete a map, click on the trash icon in the right bottom corner of a map and confirm your action. Pay attention that whole information about the map will be removed from the system, but all shortcodes will be left where you embed it. However these deprecated shortcodes won't be rendered anymore, so you don't have to worry about it while the plugin is enabled.", INTERGEO_PLUGIN_NAME ),
		) ) ),
	) );

	$screen->add_help_tab( array(
		'title'   => esc_html__( 'Shortcodes', INTERGEO_PLUGIN_NAME ),
		'id'      => 'shortcodes',
		'content' => sprintf( '<p>%s</p>', implode( '</p><p>', array(
			esc_html__( 'You can easily embed a map into your posts, pages, categories or tags descriptions and text widgets by copying shortcode which you can find in the input field of a map preview box.', INTERGEO_PLUGIN_NAME ),
			esc_html__( 'To specify a certain address just type it inside a shortcode, and a map will be automatically centered at this place. Also each shortcode could be extended with custom attributes like width, height, style, zoom and hook. Use standard CSS values for such attributes as width, height and style. Type an integer between 0 and 19 for zoom attribute. You can use hook attribute to set up a filter hook which you can use in your custom plugin or theme to configure all options of a map.', INTERGEO_PLUGIN_NAME ),
		) ) ),
	) );
}

function intergeo_library() {
	if ( filter_input( INPUT_GET, 'do' ) == 'delete' ) {
		intergeo_library_delete();
	}

	$query = new WP_Query( array(
		'orderby'        => 'ID',
		'order'          => 'DESC',
		'post_type'      => INTERGEO_PLUGIN_NAME,
		'posts_per_page' => 9,
		'paged'          => filter_input( INPUT_GET, 'pagenum', FILTER_VALIDATE_INT, array( 'options' => array(
			'min_range' => 1,
			'default'   => 1,
		) ) ),
	) );

	$libraries = array();
	$pagination = paginate_links( array(
		'base'    => add_query_arg( array(
			'pagenum' => '%#%',
			'updated' => false,
		) ),
		'format'  => '',
		'current' => max( 1, $query->get( 'paged' ) ),
		'total'   => $query->max_num_pages,
		'type'    => 'array',
	) );

	require INTERGEO_ABSPATH . '/templates/library/list.php';

	intergeo_enqueue_google_maps_script( $libraries );

	wp_enqueue_script( 'intergeo-rendering', INTERGEO_ABSURL . 'js/rendering.js', array( 'jquery', 'google-maps-v3' ), INTERGEO_VERSION );
	wp_enqueue_script( 'intergeo-library', INTERGEO_ABSURL . 'js/library.js', array( 'intergeo-rendering', 'media-views' ), INTERGEO_VERSION );

	wp_localize_script( 'intergeo-rendering', 'intergeo_options', array(
		'adsense' => array( 'publisher_id' => get_option( 'intergeo_adsense_publisher_id' ) )
	) );

    // Added by Ash/Upwork
    if( defined( 'IntergeoMaps_Pro' ) ){
        global $IntergeoMaps_Pro;
        $IntergeoMaps_Pro->enqueueScriptsAndStyles(array('intergeo-rendering'));
    }
    // Added by Ash/Upwork

}

function intergeo_library_delete() {
	if ( !current_user_can( 'delete_posts' ) ) {
		return;
	}

	$id = intergeo_decode( trim( filter_input( INPUT_GET, 'map' ) ) );
	if ( !$id ) {
		return;
	}

	$post = get_post( $id );
	if ( wp_verify_nonce( filter_input( INPUT_GET, 'nonce' ), $id . filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP ) ) && $post->post_type == INTERGEO_PLUGIN_NAME ) {
		if ( wp_delete_post( $id, true ) ) {
			intergeo_set_info( __( 'The map was deleted successfully.', INTERGEO_PLUGIN_NAME ) );
		}
	}

	if ( filter_input( INPUT_GET, 'noheader', FILTER_VALIDATE_BOOLEAN ) ) {
		wp_redirect( add_query_arg( 'page', INTERGEO_PLUGIN_NAME, admin_url( 'upload.php' ) ) );
		exit;
	}
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="messaging functions">

function intergeo_set_message( $message, $is_normal, $user_id = false ) {
	$messages = get_option( 'intergeo_messages', array() );
	if ( $user_id === false ) {
		$user_id = get_current_user_id();
	}

	if ( !isset( $messages[$user_id] ) ) {
		$messages[$user_id] = array();
	}

	$messages[$user_id][] = array( $message, $is_normal );
	update_option( 'intergeo_messages', $messages );
}

function intergeo_set_info( $message, $user_id = false ) {
	intergeo_set_message( $message, 1, $user_id );
}

function intergeo_set_error( $message, $user_id = false ) {
	intergeo_set_message( $message, 0, $user_id );
}

add_action( 'admin_notices', 'intergeo_print_messages' );
function intergeo_print_messages() {
	global $pagenow;

	if ( $pagenow != 'upload.php' ) {
		return;
	}

	$messages = get_option( 'intergeo_messages', array() );
	$user_id = get_current_user_id();

	if ( !isset( $messages[$user_id] ) ) {
		return;
	}

	foreach ( $messages[$user_id] as $message ) {
		printf( $message[1] ? '<div class="updated"><p>%s</p></div>' : '<div class="error"><p>%s</p></div>', $message[0] );
	}

	$messages[$user_id] = array();
	update_option( 'intergeo_messages', $messages );
}

// </editor-fold>
