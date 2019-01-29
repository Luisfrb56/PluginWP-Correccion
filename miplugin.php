<?php
/**
 * @package Mi_Plugin
 * @version 2.0
 */
/*
Plugin Name: MiPlugin2.0
Plugin URI: http://wordpress.org/plugins/mi-plugin/
Description: Hace cosas
Author: Luis Fernando
Version: 2.0
Author URI: http://luis.tt/
*/



function errores(){


global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'pluginerrores';

        $sql = "CREATE TABLE IF NOT EXISTS $table_name(
        fallo varchar(80),
        correccion varchar(80),
        PRIMARY KEY(fallo)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );



}

add_filter( 'init', 'errores' );



function nota_final( $content ) {
	$content .= '<footer">Gracias por leer mi post, confio en que elijas otro que te guste para visitar.</footer>';
	return $content;
}
add_filter( 'the_content', 'nota_final' );


function corregir( $text ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'pluginerrores';
    $results1 = $wpdb->get_results( "SELECT fallo FROM $table_name", OBJECT );
    $results2 = $wpdb->get_results( "SELECT correccion FROM $table_name", OBJECT );
	
    $search = array();
    $replace= array();
    
	for($i=0;$i<count($results1); $i++) {
        array_push($search,$results1[$i]->fallo);
        array_push($replace,$results2[$i]->correccion);
	};
	return str_replace( $search, $replace, $text );
	
function mal_sonantes () {
}
add_shortcode('error', 'corregir');
}
add_filter( 'the_content', 'corregir' );
