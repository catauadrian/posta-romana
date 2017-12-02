<?php
/*
 * Plugin Name: Posta-Romana
 * Plugin URI:  https://catauadrian.serveftp.com
 * Description: A plugin made for internal use generate postal romanian documents.
 * Version:     1.0.0
 * Author:      Catau Adrian
 * Author URI:  https://catauadrian.serveftp.com
 * License:     GPL-2.0+
 * Copyright:   GPLv2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

add_action('admin_menu', 'post_romana_setup_menu');

function post_romana_setup_menu(){
        add_menu_page( 'Posta Romana Page', 'Posta Romana', 'manage_options', 'Posta-romana', 'load_combos', plugins_url( 'posta-romana/img/prlogo1.png' ), 3 );
}

function load_combos(){

include_once( plugin_dir_path( __FILE__ ) . 'combos.php');

}
