<?php
namespace broshcrm;
/*add_menu_page(
    $title,
    $title,
    $dashBoardCapability,
    'brosh_forms',
    [$this, 'renderFormAdminRoute'],
    $this->getMenuIcon(),
    $menuPriority
);*/
class broshcrm_Bootstrap
{

    public static function run($file1)
    {

        broshcrm_Bootstrap::install1();
        add_action('admin_enqueue_scripts', array(new broshcrm_Bootstrap($file1), 'my_scripts'));
        add_action('admin_menu', array(new broshcrm_Bootstrap($file1), 'my_menu'));
        /*  add_action('plugins_loaded', function () {
            //Application::run(static::$file, static::$config);
            do_action('broshcrm_loaded');
        }, 1);
        */
    }
    function my_scripts()
    {
        wp_register_style(
            'broshmaincss',
            plugin_dir_url(__FILE__) . ltrim('main.css', '/'),
            [],
            'c1',
            'all'
        );
        wp_enqueue_style('broshmaincss');


        wp_register_script(
            'broshmainjs',
            plugin_dir_url(__FILE__) . ltrim('main.js', '/'),
            ['jquery'],
            'b1',
            false
        );

        wp_enqueue_script('broshmainjs');
    }
    function escParam($str){
        $slt=strtoupper(chr(wp_rand(65,89)));
        return urlencode($slt.base64_encode($str));
    } 

    public  function my_menu($file1)
    {


        $page_title = esc_html__("BROSH CRM", broshcrm_PLUGIN_DOMAIN);
        $menu_title = esc_html__("BROSH CRM", broshcrm_PLUGIN_DOMAIN);
        $capability = broshcrm_PLUGIN_ROLE;
        $menu_slug = "broshcrm";
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this, 'admin_page'), $this->getMenuIcon(), 25);

        // $page_title, esc_html__('CRM',PLUGIN_DOMAIN), $capability, $file1.'/main_crm.php', '', '', 90 );

       /*  add_submenu_page(
            $menu_slug,
            esc_html__("pop out", PLUGIN_DOMAIN),
            esc_html__("pop out", PLUGIN_DOMAIN),
            $capability,
            'https://app.brosh.io',
            array($this, 'admin_page'),
            '',
            6
        );*/
    }
    function getMenuIcon()
    {
        return 'data:image/svg+xml;base64,' . base64_encode('<svg version="1.0" xmlns="http://www.w3.org/2000/svg"  width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000"  preserveAspectRatio="xMidYMid meet">  <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#FFFFFF" stroke="none"> <path d="M2405 4830 c-66 -12 -126 -35 -205 -79 -36 -19 -82 -45 -103 -56 -50 -27 -323 -187 -411 -242 -38 -23 -73 -43 -77 -43 -9 0 -164 -90 -234 -135 -27 -18 -95 -56 -150 -85 -55 -29 -122 -68 -150 -85 -27 -18 -115 -70 -195 -115 -80 -45 -152 -88 -160 -95 -109 -96 -132 -123 -168 -193 -82 -158 -77 -80 -77 -1142 l0 -945 23 -65 c21 -58 76 -167 92 -180 3 -3 13 -17 22 -31 25 -39 147 -127 298 -214 74 -43 158 -92 185 -110 28 -17 77 -45 110 -62 33 -17 94 -51 135 -76 41 -25 125 -73 185 -108 61 -34 136 -77 168 -95 67 -39 87 -42 87 -14 0 25 38 189 49 215 5 11 24 90 42 175 17 85 59 274 91 420 127 561 139 618 162 722 l22 108 -576 2 -577 3 199 225 c109 124 202 232 205 240 4 8 19 25 33 37 15 12 47 48 71 80 24 32 296 346 604 698 308 352 578 664 600 693 21 28 42 52 46 52 4 0 33 33 65 73 32 39 92 110 133 156 74 84 74 84 53 101 -47 38 -222 129 -287 150 -79 24 -231 34 -310 20z"/> <path d="M3251 4408 c-12 -51 -48 -214 -81 -363 -116 -528 -249 -1121 -259 -1155 -6 -19 -11 -41 -11 -47 0 -10 120 -13 575 -13 316 0 575 -2 575 -5 0 -3 -107 -128 -238 -278 -200 -228 -521 -598 -866 -997 -41 -47 -107 -123 -148 -170 -597 -684 -768 -882 -768 -889 0 -13 100 -74 205 -126 112 -55 228 -80 331 -72 117 10 214 48 389 150 88 52 268 156 400 232 230 132 304 175 515 298 52 31 149 86 215 123 308 172 393 255 462 451 l28 78 0 935 0 935 -24 79 c-41 133 -137 258 -261 342 -25 17 -92 57 -150 89 -58 32 -136 77 -175 100 -64 39 -136 80 -542 314 -78 44 -144 81 -146 81 -3 0 -15 -42 -26 -92z"/> </g> </svg>');
    }
  

    function admin_page()
    {
        global $wpdb;
        $current_user = wp_get_current_user();
        $user_email = $current_user->user_email;
        $f1 = $current_user->first_name;
        $l1 = $current_user->last_name;
        //$table = 'brosh_acc';
        $wpi=$wpdb->get_var("select wpi from brosh_acc limit 1;") ;
        $params="src=wordpress&email=".$this->escParam($user_email)."&wpi=".$this->escParam($wpi)."&s=".$this->escParam(get_site_url())."&f1=".$this->escParam($f1)."&l1=".$this->escParam($l1);

        if(broshcrm_isDev==0){
            $crm_url='https://app.brosh.io/login?'.$params;
        }else{
           // $crm_url = 'https://lo'.'cal'.'host/lo'.'gin?'.$params;
        }


    ?><div id="BROSHCRMIFRMWRP" ><iframe src="<?php echo (esc_html($crm_url)) ?>" width="100%" border="0"  id="BROSHCRMIFRM" / onload="BROSHCRMIFRMWRPF()"></div><?php

    }



    public static function install1()
    {
        global $wpdb;
        
        
        
        $table = 'brosh_acc';

        if ($wpdb->get_var("SHOW TABLES LIKE 'brosh_acc'") != $table) {
            $charsetCollate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE brosh_acc (
                `id` int NOT NULL AUTO_INCREMENT,
                `wpi` varchar(45) NOT NULL,
                PRIMARY KEY (`id`)
              ) $charsetCollate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );


        $rand1=$wpdb->get_var("select LEFT(MD5(RAND()), 15);");
        //$sql = " insert into brosh_acc (wpi) select LEFT(MD5(RAND()), 15);";
        $result = $wpdb->insert('brosh_acc',array(
            'wpi'=>$rand1
        ));
        //print_r('++++++++++++++++++++++++');
        //print_r($result);
        }
    }

}
