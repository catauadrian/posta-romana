<?php

if (!isset($_POST['test'])) {
    exit; // disable direct access
}

include $_SERVER['DOCUMENT_ROOT'].'/wp-config.php';
// require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/wp-load.php');
require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/wp-config.php');



global $wpdb;

$query = '';
$output = array();

$anluna1 = $_POST['anluna1'];
$query.= " select p.ID as order_id,p.post_status,
  p.post_date as doc_date,
  max( CASE WHEN pm.meta_key = '_billing_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_first_name,
  max( CASE WHEN pm.meta_key = '_billing_last_name' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_last_name,
  max( CASE WHEN pm.meta_key = '_billing_city' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_city,
  max( CASE WHEN pm.meta_key = '_order_total' and p.ID = pm.post_id THEN pm.meta_value END ) as order_total,
  EXTRACT( YEAR_MONTH FROM p.post_date ) as anluna
  from wp_posts p
  join wp_postmeta pm on p.ID = pm.post_id
  join wp_woocommerce_order_items oi on p.ID = oi.order_id
group by p.ID HAVING
  anluna = '".$_POST["anluna1"]."' and p.post_status not like 'trash'
order by
   p.id desc ";



$results = $wpdb->get_results($query);
$rowcount = $wpdb->num_rows;
$data = array();

if ($row_count !== 0) {
    foreach( $results as $result ) {

  $sub_array = array();
  $sub_array[] = $result->order_id;
  $sub_array[] = $result->doc_date;
  $sub_array[] = $result->billing_last_name;
  $sub_array[] = $result->billing_first_name;
  $sub_array[] = $result->billing_city;
  $sub_array[] = $result->order_total;
  $sub_array[] = '<a href="javascript:deschideMandat_id('.$result->order_id.')" class="btn btn-info" role="button">Formular</a>';
  $sub_array[] = '<a href="javascript:deschideEticheta_id('.$result->order_id.')" class="btn btn-warning" role="button">Eticheta</a>';
  $data[] = $sub_array;
    }

    $output = array(
     "data"    => $data
     );
    echo json_encode($output);


}
    die();
