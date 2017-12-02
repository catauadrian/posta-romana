<?php

if (!isset($_POST['test'])) {
    exit; // disable direct access
}


// include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';


global $wpdb;

$query = '';
$output = array();

$anluna1 = $_POST['anluna1'];
$query.= " select p.ID as order_id,
  p.post_date as doc_date,
  max( CASE WHEN pm.meta_key = '_billing_email' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_email,
  max( CASE WHEN pm.meta_key = '_billing_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_first_name,
  max( CASE WHEN pm.meta_key = '_billing_last_name' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_last_name,
  max( CASE WHEN pm.meta_key = '_billing_address_1' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_address_1,
  max( CASE WHEN pm.meta_key = '_billing_address_2' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_address_2,
  max( CASE WHEN pm.meta_key = '_billing_city' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_city,
  max( CASE WHEN pm.meta_key = '_billing_state' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_state,
  max( CASE WHEN pm.meta_key = '_billing_postcode' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_postcode,
  max( CASE WHEN pm.meta_key = '_shipping_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_first_name,
  max( CASE WHEN pm.meta_key = '_shipping_last_name' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_last_name,
  max( CASE WHEN pm.meta_key = '_shipping_address_1' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_address_1,
  max( CASE WHEN pm.meta_key = '_shipping_address_2' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_address_2,
  max( CASE WHEN pm.meta_key = '_shipping_city' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_city,
  max( CASE WHEN pm.meta_key = '_shipping_state' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_state,
  max( CASE WHEN pm.meta_key = '_shipping_postcode' and p.ID = pm.post_id THEN pm.meta_value END ) as _shipping_postcode,
  max( CASE WHEN pm.meta_key = '_order_total' and p.ID = pm.post_id THEN pm.meta_value END ) as order_total,
  max( CASE WHEN pm.meta_key = '_order_tax' and p.ID = pm.post_id THEN pm.meta_value END ) as order_tax,
  max( CASE WHEN pm.meta_key = '_paid_date' and p.ID = pm.post_id THEN pm.meta_value END ) as paid_date,
  EXTRACT( YEAR_MONTH FROM p.post_date ) as anluna,
  ( select group_concat( order_item_name separator '|' ) from wp_woocommerce_order_items where order_id = p.ID ) as order_items
from
  wp_posts p
  join wp_postmeta pm on p.ID = pm.post_id
  join wp_woocommerce_order_items oi on p.ID = oi.order_id
group by
  p.ID
HAVING
  anluna = $anluna1
order by
   p.id desc ";

// //'".$_POST['anluna1']."'
// select * from cli_jur_view where anluna = '".$_POST["anluna1"]."'
// order by id desc ";


$results = $wpdb->get_results($query);
$rowcount = $wpdb->num_rows;
$data = array();

if ($row_count !== 0) {
    foreach( $results as $result ) {

        // echo $result->order_id;
        // echo $result->Anul;

  $sub_array = array();
  $sub_array[] = $result->order_id;
  $sub_array[] = $result->doc_date;
  $sub_array[] = $result->billing_first_name;
  $sub_array[] = $result->billing_last_name;
  $sub_array[] = $result->billing_city;
  $sub_array[] = $result->order_total;
  $sub_array[] = '<a href="javascript:deschidePrint_id('.$result->order_id.')" class="btn btn-primary" role="button">Mandat</a>';
  $sub_array[] = '<a href="javascript:deschidePrint_id('.$result->order_id.')" class="btn btn-info" role="button">Buletin</a>';
  $sub_array[] = '<a href="javascript:deschidePrint_id('.$result->order_id.')" class="btn btn-warning" role="button">Eticheta</a>';
  $data[] = $sub_array;
    }

    $output = array(
     "data"    => $data
     );
    echo json_encode($output);


}
    die();
