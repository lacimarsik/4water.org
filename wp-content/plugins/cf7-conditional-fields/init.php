<?php

if (!defined('WPCF7CF_VERSION')) define( 'WPCF7CF_VERSION', '1.4.1' );
if (!defined('WPCF7CF_REQUIRED_WP_VERSION')) define( 'WPCF7CF_REQUIRED_WP_VERSION', '4.1' );
if (!defined('WPCF7CF_PLUGIN')) define( 'WPCF7CF_PLUGIN', __FILE__ );
if (!defined('WPCF7CF_PLUGIN_BASENAME')) define( 'WPCF7CF_PLUGIN_BASENAME', plugin_basename( WPCF7CF_PLUGIN ) );
if (!defined('WPCF7CF_PLUGIN_NAME')) define( 'WPCF7CF_PLUGIN_NAME', trim( dirname( WPCF7CF_PLUGIN_BASENAME ), '/' ) );
if (!defined('WPCF7CF_PLUGIN_DIR')) define( 'WPCF7CF_PLUGIN_DIR', untrailingslashit( dirname( WPCF7CF_PLUGIN ) ) );

if (!defined('WPCF7CF_REGEX_MAIL_GROUP')) define( 'WPCF7CF_REGEX_MAIL_GROUP', '@\[[\s]*([a-zA-Z_][0-9a-zA-Z:._-]*)[\s]*\](.*?)\[[\s]*/[\s]*\1[\s]*\]@s');


if(file_exists(WPCF7CF_PLUGIN_DIR.'/pro/pro-functions.php')) {
    if (!defined('WPCF7CF_IS_PRO')) define( 'WPCF7CF_IS_PRO', true );
} else {
    if (!defined('WPCF7CF_IS_PRO')) define( 'WPCF7CF_IS_PRO', false );
}

function wpcf7cf_plugin_path( $path = '' ) {
    return path_join( WPCF7CF_PLUGIN_DIR, trim( $path, '/' ) );
}

function wpcf7cf_plugin_url( $path = '' ) {
    $url = plugins_url( $path, WPCF7CF_PLUGIN );
    if ( is_ssl() && 'http:' == substr( $url, 0, 5 ) ) {
        $url = 'https:' . substr( $url, 5 );
    }
    return $url;
}

if (WPCF7CF_IS_PRO) {
    require_once WPCF7CF_PLUGIN_DIR.'/pro/pro-functions.php';
}

require_once WPCF7CF_PLUGIN_DIR.'/cf7cf.php';
require_once WPCF7CF_PLUGIN_DIR.'/wpcf7cf-options.php';