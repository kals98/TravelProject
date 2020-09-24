<?php

$sessionTime = 365 * 24 * 60 * 60;
$sessionName = "my_session";

if (isset($_COOKIE[$sessionName])) {
            session_set_cookie_params($sessionTime);
            session_name($sessionName);
            session_start();
        }
else{
        if (!empty($_POST["remember"])){
            session_set_cookie_params($sessionTime);
            session_name($sessionName);
            session_start();
        }
        else{
            session_start();
        }

}

use Dompdf\Dompdf;
require 'vendor/autoload.php';
$subtotal=$_SESSION['book']['nop']*$_SESSION['tour']['price'];
$tax=0.05*$subtotal;
$total=$subtotal+$tax;   

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="windows-1252">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Checkout</title>

  <link rel="icon" href="img/ico/travelmeister.ico" type="image/x-icon">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">

  <link rel="stylesheet" href="css/mdb.min.css">

  <link rel="stylesheet" href="css/userdashboard.css">
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="card">
  <div class="card-body d-flex justify-content-between">
    <h4 class="h4-responsive">Booking No.'. $_SESSION['book']['id'].'</h4>
  </div>
</div>
<div>
<section>
<div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 text-left">
          <p><small>From:</small></p>
          <p><strong>Travelmeister Tours</strong></p>
          <p>MIT-WPU</p>
          <p>Pune, MH 411038</p>
          <p><strong>Booking date:'.$_SESSION['book']['bdate'].'</strong></p>
        </div>
        <div class="col-md-6 text-right">
          <p><small>To:</small></p>
          <p><strong>'.$_SESSION['book']['cname'].'</strong></p>
          <p>'.$_SESSION['book']['cadd'].'</p>
          <p><strong>CheckIn:'.$_SESSION['book']['sdate'].'</strong></p>
          <p><strong>CheckOut:'.$_SESSION['book']['edate'].'</strong></p>
        </div>
      </div>
    </div>
  </div>
</section>
<hr>
<section>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Tour Name</th>
              <th>Number Of People</th>
              <th>Country</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>'.$_SESSION['tour']['name'].'</td>
              <td>'.$_SESSION['book']['nop'].'</td>
              <td>'.$_SESSION['tour']['country'].'</td>
            </tr>
          </tbody>
        </table>
      </div>
      <ul class="list-unstyled text-right">
        <li style="padding-right:75px"><strong>Sub Total:</strong><span class="float-right ml-3">Rs.'.$subtotal.'</span></li>
        <li style="padding-right:10px"><strong>TAX:</strong><span class="float-right ml-3">Rs.'.$tax.'</span></li>
        <li><strong>TOTAL:</strong><span class="float-right ml-3">Rs.'.$total.'</span></li>
      </ul>
    </div>
  </div>
</section>
</div>

<script type="text/javascript" src="js/jquery.min.js"></script>

<script type="text/javascript" src="js/popper.min.js"></script>

<script type="text/javascript" src="js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/mdb.min.js"></script>

<script type="text/javascript" src="js/addons/datatables.min.js"></script>

<script type="text/javascript" src="js/addons/datatables-select.min.js"></script>

<script type="text/javascript" src="js/index.js"></script>

<script type="text/javascript" src="js/agent.js"></script>
</body>
</html>';

$codeHTML = utf8_encode($html);
$dompdf = new Dompdf();
$dompdf->load_html($codeHTML);
$dompdf->setPaper('A4' ,'horizontal');

//if you whould like to add fonts
$dompdf->set_option('defaultFont', 'Courier');

ini_set('memory_limit', '128M');
$dompdf->render();
$dompdf->stream('Receipt.pdf');
?>

