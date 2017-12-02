<?php



if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}


 ?>

<!DOCTYPE html>
<html>
  <head>
  <title>Posta Romana</title>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

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


    <SELECT name="Anul" id ="anul" onChange ="showLunaAnul(),ClearForm(),IncarcaDatele()">
      <?php
    global $wpdb;
    $query = "SELECT Anul FROM wp_tblanul where Anul <= Year(Now()) order by Anul desc ";
    $results = $wpdb->get_results($query) or die(mysql_error());

     foreach ($results as $row) {
   echo "<option id='anul' value='blue'>$row->Anul</option>";
   }

      ?>
  </SELECT>

    <!--ComboBox Luna  -->

    <SELECT id="luna" onChange ="showLunaAnul(),ClearForm(),IncarcaDatele()">
      <?php
      global $wpdb;
    $query = "SELECT MonthNR FROM wp_tblmonths order by MonthNR desc";
    $results = $wpdb->get_results($query) or die(mysql_error());

          foreach ($results as $row){
    echo "<option id='luna' 'value='blue'>$row->MonthNR</option>";

     }
  ?>
    </SELECT>
<!--Finalizare ComboLuna  -->


<!--function to set initial month, actually current month  -->

<script>
  function SetInitialMonth(){

    var lu = '<?php echo date('m'); ?>';

    var currentMonth = document.getElementById('luna');
    currentMonth.value = lu;
}
SetInitialMonth();
</script>



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
       <th width="10%">Total</th>
       <th width="10%">Mandat</th>
       <th width="10%">Buletin</th>
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
                  var anluna1 = showLunaAnul();
                  var test = "test1";
                  var dataTable = jQuery('#user_data').DataTable({
                          "processing": true,

                          // "serverSide":true,
                          "order": [],
                          "ajax": {
                              url: "../wp-content/plugins/posta-romana/fetch.php",
                              type: "POST",
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
function deschidePrint_id(order_id){

window.open("../wp-content/plugins/posta-romana/printing/mandat.php?order_id="+order_id, "width 100, height = 300");
}
</script>
