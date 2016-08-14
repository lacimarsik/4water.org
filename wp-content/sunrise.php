<?php
// https://paulund.co.uk/wordpress-multisite-nested-paths

if( defined( 'DOMAIN_CURRENT_SITE' ) && defined( 'PATH_CURRENT_SITE' ) ) {
  $current_site = new stdClass;
  $current_site->id = (defined( 'SITE_ID_CURRENT_SITE' ) ? constant('SITE_ID_CURRENT_SITE') : 1);
  $current_site->domain = $domain = DOMAIN_CURRENT_SITE;
  $current_site->path  = $path = PATH_CURRENT_SITE;

  if( defined( 'BLOGID_CURRENT_SITE' ) )
    $current_site->blog_id = BLOGID_CURRENT_SITE;

  $url = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

  $patharray = (array) explode( '/', trim( $url, '/' ));
  $blogsearch = '';

  if( count( $patharray )){
    foreach( $patharray as $pathpart ){
      $pathsearch .= '/'. $pathpart;
      $blogsearch .= $wpdb->prepare(" OR (domain = %s AND path = %s) ", $domain, $pathsearch .'/' );
    }
  }

  $current_blog = $wpdb->get_row( $wpdb->prepare("SELECT *, LENGTH( path ) as pathlen FROM $wpdb->blogs WHERE domain = %s AND path = '/'", $domain, $path) . $blogsearch .'ORDER BY pathlen DESC LIMIT 1');

  $blog_id = $current_blog->blog_id;
  $public  = $current_blog->public;
  $site_id = $current_blog->site_id;

  $current_site = pu_get_current_site_name( $current_site );
}

function pu_get_current_site_name( $current_site ) {
  global $wpdb;
  $current_site->site_name = wp_cache_get( $current_site->id . ':current_site_name', "site-options" );
  if ( !$current_site->site_name ) {
    $current_site->site_name = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM $wpdb->sitemeta WHERE site_id = %d AND meta_key = 'site_name'", $current_site->id ) );
    if( $current_site->site_name == null )
      $current_site->site_name = ucfirst( $current_site->domain );
    wp_cache_set( $current_site->id . ':current_site_name', $current_site->site_name, 'site-options');
  }
  return $current_site;
}