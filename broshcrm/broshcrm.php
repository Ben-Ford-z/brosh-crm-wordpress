<?php
/*
Plugin Name: BROSH CRM
Description: BROSH CRM is UNIFIED CRM & MARKETING PLATFORM
Version: 1.0
Author: ZaapIT AS LTD / BROSH.io
Author URI: https://brosh.io
Plugin URI: https://brosh.io/page/wordpress
License: GPLv2 or later
Text Domain: broshcrm
Domain Path: /resources/languages
*/
namespace broshcrm;
defined('ABSPATH') or die;
//define( 'WP_DEBUG', true );
defined('broshcrm') or define('broshcrm', true);
define('broshcrm_DIR_PATH', plugin_dir_path(__FILE__));
defined('broshcrm_VERSION') or define('broshcrm_VERSION', '1.0');

define('broshcrm_PLUGIN_ROLE', 'manage_options');
define('broshcrm_PLUGIN_DOMAIN', 'broshcrm');
//define('isDev', '1');
define('broshcrm_isDev', '0');

//echo '+++++++++++++++++++++++'. wp_get_environment_type();

if (!defined('broshcrm_HAS_NIA')) {
    define('broshcrm_HAS_NIA', true);
}

define('broshcrm_APACHE_MIME_TYPES_URL', 'http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types');

include broshcrm_DIR_PATH . 'main.php';

//use Bootstrap;



/*** remove wordpress update notifications */
/*
add_action('admin_head', function() {
    remove_all_actions('admin_notices');
        //remove_action( 'admin_notices', 'update_nag',      3  );
        //remove_action( 'admin_notices', 'maintenance_nag', 10 );
  
});*/


add_action('admin_init', function () {
    $disablePages = [
        'broshcrm',
    ];

    
	 $actual_link = $_SERVER["QUERY_STRING"];

	$pos1 = strrpos($actual_link, 'page=broshcrm');
	
	if ( $pos1 >= 0 ) {

	
		remove_all_actions('admin_notices');
	}
});

broshcrm_Bootstrap::run(broshcrm_DIR_PATH);

//get static content
/*
$actual_link = "$_SERVER[REQUEST_URI]";

$pos1 = strrpos($actual_link, '/broshcrm/');

if (false && $pos1 >= 0  && strrpos($actual_link, '..') == null) {
 
    $filedir1 = 'crm-zp/' . substr($actual_link, $pos1+10);
    $fileToGet = broshcrm_DIR_PATH . $filedir1;
    //$mimes = get_post_mime_types();



    $mimet = qmimetype($fileToGet);
    //echo '+++++++++++++++++++++++'. $mimet.' '.$fileToGet;
    header('Content-Type: ' . $mimet,true);

    echo ( file_get_contents($fileToGet));
    
} else {
    
    
}

function qmimetype($file)
{
    $ext = array_pop(explode('.', $file));
   // echo '+++++++++++++++++++++++' .$file. ' ' . $ext;
    if ($ext!=null && strrpos($file, '.') != null && $ext != '') {
        foreach (file(broshcrm_DIR_PATH . 'mime.types') as $line)
            if (preg_match('/^([^#]\S+)\s+.*' . $ext . '$/', $line, $m))
                return $m[1];
    }
    return 'application/octet-stream';
}

*/



