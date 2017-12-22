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
    max( CASE WHEN pm.meta_key = '_shipping_country' and p.ID = pm.post_id THEN pm.meta_value END ) as shipping_country,
    max( CASE WHEN pm.meta_key = '_billing_phone' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_phone,
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
        $PrenumeClient = $result->billing_last_name;
        $TelefonClient = $result->billing_phone;
        $Localitate = $result->shipping_city;
        $Judet = $result->shipping_state;
        $Adresa1 = $result->shipping_address_1;
        $Adresa2 = $result->shipping_address_2;
        $CodPostal = $result->shipping_postcode;
        $Ramburs = $result->order_total;
        $TaraClient = $result->shipping_country;

   }
  }
}



$jsonData = file_get_contents("../wp_company.json");
        $json = json_decode($jsonData, true);

$NumeCompany =  $json["company"][0]["nume"];
$CodFiscal = $json["company"][0]["codfiscal"];
$NumarCompany =  $json["company"][0]["numar"];
$LocCompany = $json["company"][0]["loc"];
$JudetCompany = $json["company"][0]["judet"];
$TelefonCompany = $json["company"][0]["telefon"];
$Cod_postalCompany = $json["company"][0]["cod_postal"];
$EmailCompany = $json["company"][0]["email"];
$Strada = $json["company"][0]["strada"];
$BancaCompany = $json["company"][0]["banca"];
$IbanComapany = $json["company"][0]["IBAN"];
$LocBancaCompany = $json["company"][0]["LocBanca"];
$TaraCompany = $json["company"][0]["tara"];


require('../fpdf/rotation.php');

class PDF extends PDF_Rotate
{
function RotatedText($x,$y,$txt,$angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}

// function RotatedImage($file,$x,$y,$w,$h,$angle)
// {
//     //Image rotated around its upper-left corner
//     $this->Rotate($angle,$x,$y);
//     $this->Image($file,$x,$y,$w,$h);
//     $this->Rotate(0);
// }
}

$pdf=new PDF('L','mm',array(100,70));
// $pdf->SetFillColor(240,231,231);
$pdf->AddPage();
$pdf->SetFont('Arial','b',12);





$pdf->RotatedText(1,4, 'Expeditor:', 0);
$pdf->RotatedText(1,9, strtoupper($NumeCompany), 0);
$pdf->RotatedText(1,14, $LocCompany . " " . $Cod_postalCompany, 0);
$pdf->RotatedText(1,19, $TaraCompany, 0);

$pdf->RotatedText(10,30, 'DESTINATAR:',0);
$pdf->RotatedText(1,35, 'Numele si Prenumele: ' . strtoupper($NumeClient . " " . $PrenumeClient), 0);
$pdf->RotatedText(1,40, $Adresa1 ." ". $Adresa2, 0);
$pdf->RotatedText(1,45, 'Cod Postal: '. $CodPostal, 0);
$pdf->RotatedText(1,50, 'Localitate: ' . $Localitate, 0);
$pdf->RotatedText(1,55, 'Judet: '. $Judet, 0);
$pdf->RotatedText(1,60, 'Tara: '. $TaraClient, 0);


$pdf->Output();
?>
