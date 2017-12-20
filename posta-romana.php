<?php
/*
 * Plugin Name: Posta-Romana
 * Plugin URI:  https://github.com/catauadrian/posta-romana
 * Description: A plugin made for internal use generate postal romanian documents.
 * Version:     1.0.0
 * Author:      Catau Adrian
 * Author URI:  https://progstarters.blogspot.ro
 * License:     GPL-2.0+
 * Copyright:   GPLv2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
    die ('Nu incerca sa pui scripturi aiuriea');
}



add_action('admin_menu', 'post_romana_setup_menu');

function post_romana_setup_menu(){
        add_menu_page( 'Posta Romana Page', 'Posta Romana', 'manage_options', 'Posta-romana', 'load_combos', plugins_url( 'posta-romana/img/prlogo1.png' ), 3 );
}

function load_combos(){

include_once( plugin_dir_path( __FILE__ ) . 'combos.php');


}
