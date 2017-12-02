<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" style= type"text/css" href="../css/print1.css">
    <meta charset="utf-8">
</head>
<img src="../img/buletin1.png" alt="Mountain View" style="width:800px;height:600px;">
<body>


<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';


 global $wpdb;

$id = $_GET["order_id"];



if(isset($_GET["order_id"])){
  $query= " select p.ID as order_id,
    p.post_date as doc_date,
    max( CASE WHEN pm.meta_key = '_billing_email' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_email,
    max( CASE WHEN pm.meta_key = '_billing_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_first_name,
    max( CASE WHEN pm.meta_key = '_billing_last_name' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_last_name,
    max( CASE WHEN pm.meta_key = '_billing_address_1' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_address_1,
    max( CASE WHEN pm.meta_key = '_billing_address_2' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_address_2,
    max( CASE WHEN pm.meta_key = '_billing_city' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_city,
    max( CASE WHEN pm.meta_key = '_billing_state' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_state,
    max( CASE WHEN pm.meta_key = '_billing_postcode' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_postcode,
    max( CASE WHEN pm.meta_key = '_shipping_first_name' and p.ID = pm.post_id THEN pm.meta_value END ) as shipping_first_name,
    max( CASE WHEN pm.meta_key = '_shipping_last_name' and p.ID = pm.post_id THEN pm.meta_value END ) as shipping_last_name,
    max( CASE WHEN pm.meta_key = '_shipping_address_1' and p.ID = pm.post_id THEN pm.meta_value END ) as shipping_address_1,
    max( CASE WHEN pm.meta_key = '_shipping_address_2' and p.ID = pm.post_id THEN pm.meta_value END ) as shipping_address_2,
    max( CASE WHEN pm.meta_key = '_shipping_city' and p.ID = pm.post_id THEN pm.meta_value END ) as shipping_city,
    max( CASE WHEN pm.meta_key = '_shipping_state' and p.ID = pm.post_id THEN pm.meta_value END ) as shipping_state,
    max( CASE WHEN pm.meta_key = '_shipping_postcode' and p.ID = pm.post_id THEN pm.meta_value END ) as shipping_postcode,
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
    order_id = $id
  order by
     p.id desc ";

     $results = $wpdb->get_results($query);
     $row_count = $wpdb->num_rows;

     if ($row_count !== 0) {
         foreach( $results as $result ) {
        $NumeClient = $result->billing_first_name;
        // $Localitate = $row["shipping_city"];
        // $Judet = $row["shipping_state"];
        // $Adresa = $row["shipping_address_1"];

        echo $result->billing_first_name;


   }
  }
}
 ?>
   <div id="Id"> <?php echo $id;?> </div>
   <div id="NumeClient"> <?php echo $NumeClient;?> </div>
   <div id="Localitate"> <?php echo $Localitate;?> </div>
   <div id="Judet"> <?php echo $Judet;?> </div>
   <div id="Adresa"> <?php echo $Adresa;?> </div>




   </body>
</html>
