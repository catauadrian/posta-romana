<?php



if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}


 ?>

<!DOCTYPE html>
<html>
  <head>
  <title>Posta Romana</title>


   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
   <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap.min.js"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css" />
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



  <style>
 body
 {
  margin:0;
  padding:0;
  background-color:#f1f1f1;
 }
 .box
 {
  width:1270px;
  padding:20px;
  background-color:#fff;
  border:1px solid #ccc;
  border-radius:5px;
  margin-top:25px;
 }
</style>

<link rel="stylesheet" href="../wp-content/plugins/posta-romana/css/indexprint.css">

  </head>
  <body>
    <div class="container box">
   <h1 align="center">Printare documente posta</h1>
   <br />
   <div class="table-responsive">
    <br />

      <?php
      // set start and end year range
      $yearArray = range(date('Y'), 2010);
      //Months range
      $Months = range(12,1);

      ?>
      <!-- displaying the dropdown list -->
      <SELECT name="Anul" id ="anul" onChange ="showLunaAnul(),ClearForm(),IncarcaDatele()">

          <?php
          foreach ($yearArray as $year) {
              // if you want to select a particular year
              $selected = ($year == date('Y')) ? 'selected' : '';
              echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
          }
          ?>
    </SELECT>

    <!--ComboBox Luna  -->

    <SELECT id="luna" onChange ="showLunaAnul(),ClearForm(),IncarcaDatele()">

      <?php
      foreach ($Months as $month) {

        $month = (str_pad($month, 2, "0", STR_PAD_LEFT));
       $selected = ($month == date('m')) ? 'selected' : '';

          echo '<option '.$selected.' value="'.$month.'">'.$month.'</option>';
      }
      ?>



    </SELECT>
<!--Finalizare ComboLuna  -->



<script>
function showLunaAnul(){
 var anul = document.getElementById('anul');
 var idxA = anul.selectedIndex;
 var contentA = anul.options[idxA].innerHTML;

 var luna = document.getElementById('luna');
 var idxL = luna.selectedIndex;
 var contentL = luna.options[idxL].innerHTML;
 anluna = (contentA+contentL);
return anluna;
}
</script>


    <br /><br />
    <table id="user_data" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th width="5%">Id</th>
       <th width="20%">Data Doc</th>
       <th width="20%">Nume</th>
       <th width="35%">Prenume</th>
       <th width="25%">Localitate</th>
       <th width="15%">Total</th>
       <th width="20%">Formular</th>
       <th width="10%">Eticheta</th>
      </tr>
     </thead>
    </table>

   </div>
  </div>
 </body>
</html>

  </body>
</html>


<script>
    function IncarcaDatele() {

          jQuery(document).ready(function() {
          // var $ = jQuery.noConflict();
                  var anluna1 = showLunaAnul();
                  var test = "test";
                  var dataTable = jQuery('#user_data').DataTable({
                          "processing": true,

                           // "serverSide":true,
                          "order": [],
                          "ajax": {
                              url: "../wp-content/plugins/posta-romana/fetch.php",


                              type: "POST",
                              crossDomain: true,
                              data: {anluna1,test}
                            },

                          "columnDefs": [{
                              "targets": -1,
                          }],
                      });

              });
      }
</script>


 <script>
IncarcaDatele();
</script>


 <!-- Functia ClearForma :)) -->
<script>
function ClearForm(){
  jQuery(document).ready(function(){
    jQuery("#user_data").dataTable().fnDestroy();
  });
}
</script>



<script>
function deschideEticheta_id(order_id){

window.open("../wp-content/plugins/posta-romana/printing/eticheta.php?order_id="+order_id);
}
</script>

<script>
function deschideMandat_id(order_id){

window.open("../wp-content/plugins/posta-romana/printing/mandat.php?order_id="+order_id);
}
</script>
