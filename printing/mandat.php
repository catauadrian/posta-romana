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

   }
  }
}


   include '../class/FunClass.php';
   $ValColet = 20;
   $numar = $result->order_total;
   $instance = new NumToLitere;
   $ramburslitere = $instance->strLei($numar,'','.');
   $ValoareStatistica = $instance->strLei($ValColet,'','.');


   $jsonData = file_get_contents ("../wp_company.json");
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

$pdf=new PDF('P','mm','A4');
$pdf->SetFillColor(240,231,231);
$pdf->AddPage();
$pdf->SetFont('Arial','b',9);
$pdf->Image('../img/form1.png',-4,-4,0,0,'png');

// Date prima Sectiune  = 1

$pdf->RotatedText(40,110,$ValColet,90);
$pdf->RotatedText(40,80, strtoupper($ValoareStatistica),90);
$pdf->RotatedText(45,112,$numar,90);
$pdf->RotatedText(45,98, $ramburslitere,90);
$pdf->RotatedText(51,117, strtoupper($PrenumeClient ." ". $NumeClient), 90);
$pdf->RotatedText(51,30, $TelefonClient,90);
$pdf->RotatedText(57,127, $Adresa1 ." ". $Adresa2, 90);
$pdf->RotatedText(63,116, $CodPostal, 90);
$pdf->RotatedText(63,60, $Localitate, 90);
$pdf->RotatedText(72,112, $Judet, 90);

// Date prima Sectiune  = 2

$pdf->RotatedText(80,117, $NumeCompany, 90);
$pdf->RotatedText(80,50, $TelefonCompany, 90);
$pdf->RotatedText(86,127, $Strada, 90);
$pdf->RotatedText(86,98, $NumarCompany, 90);
$pdf->RotatedText(92,117, $Cod_postalCompany, 90);
$pdf->RotatedText(92,88, $LocCompany, 90);
$pdf->RotatedText(92,48, $JudetCompany, 90);
$pdf->RotatedText(96,112, $EmailCompany, 90);



// - Date a-treia sectiune Aviz de primire

$pdf->RotatedText(136,116, strtoupper($PrenumeClient ." ". $NumeClient), 90);
$pdf->RotatedText(136,26, $TelefonClient, 90);
$pdf->RotatedText(144,127, $Adresa1 ." ". $Adresa2, 90);
$pdf->RotatedText(156,70,$ValColet . " RON",90);
$pdf->RotatedText(156,30,$numar . " RON",90);
$pdf->RotatedText(162,112, $NumeCompany, 90);
$pdf->RotatedText(169,127, $Strada, 90);
$pdf->RotatedText(169,76, $NumarCompany, 90);
$pdf->RotatedText(169,62, $Cod_postalCompany, 90);
$pdf->RotatedText(169,31, $LocCompany, 90);


// Sectiunea CUPON - mandat postal

// Date Expeditor





$pdf->RotatedText(3,205, strtoupper($PrenumeClient ." ". $NumeClient), 0);
$pdf->RotatedText(8,213, $Adresa1 ." ". $Adresa2, 0);
$pdf->RotatedText(10,217, $CodPostal, 0);
$pdf->RotatedText(37,217, $Localitate, 0);
$pdf->RotatedText(14,236, $TelefonClient, 0);
$pdf->SetY(245);
$pdf->SetX(5);
$pdf->Cell(53,7,$numar,1,1,'C',true);

// Date Primitor

$pdf->RotatedText(80,200, $NumeCompany, 0);
$pdf->RotatedText(84,203, $CodFiscal, 0);
$pdf->RotatedText(77,207, $Strada, 0);
$pdf->RotatedText(124,207, $NumarCompany, 0);
$pdf->RotatedText(74,211, $Cod_postalCompany, 0);
$pdf->RotatedText(103,211, $LocCompany, 0);
$pdf->RotatedText(80,215, $IbanComapany, 0);
$pdf->RotatedText(82,222, $BancaCompany, 0);
$pdf->RotatedText(92,225, $LocBancaCompany, 0);

// - sub Date Expeditor

$pdf->RotatedText(81,229, strtoupper($PrenumeClient ." ". $NumeClient), 0);
$pdf->RotatedText(84,232, $Localitate, 0);
$pdf->SetY(239);
$pdf->SetX(67);
$pdf->Cell(64,6,$numar,1,1,'C',true);
$pdf->SetY(250);
$pdf->SetX(67);
$pdf->MultiCell(64,7,strtoupper($ramburslitere),1,1,'C','M');





$pdf->AddPage();
$pdf->SetFont('Arial','b',9);
$pdf->Image('../img/form2.png',-4,-4,0,0,'png');
$pdf->RotatedText(184,280,$NumeCompany,180);
$pdf->RotatedText(184,275,$CodFiscal,180);
$pdf->RotatedText(195,270,$Strada,180);
$pdf->RotatedText(155,270,$NumarCompany,180);
$pdf->RotatedText(191,265,$IbanComapany,180);
$pdf->RotatedText(202,255,$BancaCompany,180);
$pdf->RotatedText(202,250,$LocBancaCompany,180);
$pdf->RotatedText(184,245,$LocCompany,180);
$pdf->RotatedText(177,240,$JudetCompany,180);
$pdf->RotatedText(190,235,$TelefonCompany,180);
$pdf->RotatedText(175,229,'RAMBURS',180);
$pdf->RotatedText(201,224,'COLET POSTAL NR.',180);
$pdf->RotatedText(192,219,'X',180);




$pdf->Output();
?>
