<?php

    use Dompdf\Dompdf;

    require 'vendor/autoload.php';

	if (isset($_POST['add_tour_btn'])) {
		add_tour();
    }
    if (isset($_POST['send_invoice_btn'])) {
		send_invoice();
	}
	if (isset($_POST['edit_tour_btn'])) {
		edit_tour();
	}
	if (isset($_POST['delete_tour_btn'])) {
		delete_tour();
    }
    if (isset($_POST['add_book_btn'])) {
		add_book();
    }
    if (isset($_POST['checkout_btn'])) {
		add_booking();
	}
	if (isset($_POST['edit_book_btn'])) {
		edit_book();
	}
	if (isset($_POST['delete_book_btn'])) {
		delete_book();
  }
 if (isset($_POST['deltourimg_btn'])) {
    deltourimg();
  } 
  if (isset($_POST['cancel_book_btn'])) {
		cancel_book();
  }
 if (isset($_POST['rev_tour_btn'])) {
    rev_tour();
  } 

    function add_tour(){
        global $db,$update;

        $name = e($_POST['name']);
        $country = e($_POST['country']);
        $desc = e($_POST['desc']);
        $continent = e($_POST['continent']);
        $price = e($_POST['price']);
        $agent_id = $_SESSION['user']['id'];
        $agent_uname = $_SESSION['user']['username'];
        $i=0;
        $files="";

        $query = "INSERT INTO tours (`name`,`country`,`continent`,`price`,`agent_id`,`agent_uname`,`descr`) VALUES ('$name','$country','$continent',$price,$agent_id,'$agent_uname','$desc')";
        $query_run = mysqli_query($db, $query);
        $tour_id = mysqli_insert_id($db);
        $new_directory='img/tour/'.$tour_id;
        if (!is_dir($new_directory)){
          mkdir($new_directory,0777);
        }
        foreach ($_FILES['image']['tmp_name'] as $key => $image) {
            $imageTmpName = $_FILES['image']['tmp_name'][$key];
            $image = $_FILES['image']['name'][$key];
            $fileExt = explode('.',$image);
            $fileActualExt = strtolower(end($fileExt));
            if($_FILES['image']['type'][$key]=='image/jpeg' && $_FILES['image']['size'][$key]<1000000){
                $fileNameNew=$tour_id.$i.".".$fileActualExt;
                $target = $new_directory.'/'.$fileNameNew;
                if (move_uploaded_file($imageTmpName, $target)) {
                if($i==0){
                    $files=$files."$fileNameNew";
                }
                else{
                    $files=$files.",$fileNameNew";
                }
            }else{
              array_push($update,"Failed to upload image");
              }
            }
            else{
                array_push($update, "Selected file is not an image please select Jpeg or jpg image or select file less than 1mb");
            }
            $i++;
        }

        $sql = "UPDATE tours SET image='$files' WHERE id ='$tour_id'";
        $qr_run = mysqli_query($db, $sql);

        if($query_run && $qr_run)
        {
            array_push($update, "Tour Added");
        }
        else
        {
            array_push($update, "Data Not Added");
        }


    }

    function edit_tour(){
        global $db,$update;
        $id =e($_POST['update_id_tour']);

        $name = e($_POST['name']);
        $country = e($_POST['country']);
        $continent = e($_POST['continent']);
        $price = e($_POST['price']);
        $agent_id = $_SESSION['user']['id'];
        $agent_uname = $_SESSION['user']['username'];

        $query = "UPDATE tours SET name='$name', country='$country', continent='$continent', price=$price WHERE id=$id ";
        $query_run = mysqli_query($db, $query);

        if(!isset($_FILES['image']['name'][0]) || $_FILES['image']['error'][0] == 4){
        if($query_run)
        {
           array_push($update, "Tour Updated");

        }
        else
        {
           array_push($update, "Tour Not Updated");
        }
        }else{
            $i=0;
            $files="";
            $tour_id = $id;
            $new_directory='img/tour/'.$tour_id;
            if (!is_dir($new_directory)){
              mkdir($new_directory,0777);
            }
            foreach ($_FILES['image']['tmp_name'] as $key => $image) {
            $imageTmpName = $_FILES['image']['tmp_name'][$key];
            $image = $_FILES['image']['name'][$key];
            $fileExt = explode('.',$image);
            $fileActualExt = strtolower(end($fileExt));
            if($_FILES['image']['type'][$key]=='image/jpeg' && $_FILES['image']['size'][$key]<1000000000000){
                $fileNameNew=$tour_id.$i.".".$fileActualExt;
                $target = $new_directory.'/'.$fileNameNew;
                if (move_uploaded_file($imageTmpName, $target)) {
                if($i==0){
                    $files=$files."$fileNameNew";
                }
                else{
                    $files=$files.",$fileNameNew";
                }
            }else{
              array_push($update,"Failed to upload image");
              }
            }
            else{
                array_push($update, "Selected file is not an image please select Jpeg or jpg image or select file less than 10mb");
            }
            $i++;
        }

        $sql = "UPDATE tours SET image='$files' WHERE id ='$tour_id'";
        $qr_run = mysqli_query($db, $sql);
        if($query_run && $qr_run)
        {
            array_push($update, "Tour Added");
        }
        else
        {
            array_push($update, "Data Not Added");
        }
        }
    }

    function deltourimg(){
      global $db, $username, $update;
      $id =e($_POST['update_id_tour']);
      $query = "SELECT * FROM tours WHERE id='$id'";
      $query_run = mysqli_query($db, $query);
      $row = mysqli_fetch_assoc($query_run);
      $img=explode(',',$row['image']);
      $path="img/tour/".$row['id'];
      if($img[0]!="default.jpg"){
        foreach($img as $value){
         $image = "img/tour/$id/$value";
         unlink($image);
        }
        $sql = "UPDATE tours SET image='default.jpg' WHERE id ='$id'";
        if(mysqli_query($db, $sql)){
          array_push($update, "Images deleted");
        }
      }else{
        array_push($update, "Images dont exist");
      }
     }

     function rrmdir($d) {
      global $db, $username, $update;
      $dir="img/tour/".$d;
      if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
          if ($object != "." && $object != "..") {
            if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
          }
        }
        reset($objects);
        if(rmdir($dir)){
          array_push($update, "Image deleted successfully");
        }
        else{
          array_push($update, "Image not deleted successfully");
        }
        }
        else{
          array_push($update, "Directory doesnt exists");
        }
      }


    function delete_tour(){
        global $db,$update;
        $id = e($_POST['delete_id_tour']);


        $query = "DELETE FROM tours WHERE id='$id'";
        $query_run = mysqli_query($db, $query);

        if($query_run)
        {
            array_push($update, "Tour Deleted");
            rrmdir($id);
        }
        else
        {
            array_push($update,"Tour Not Dleted");
        }


    }

    function add_booking(){
        global $db,$update;

        $cname = e($_POST['fullname']);
        $cemail = e($_POST['email']);
        $caddr = e($_POST['addr']);
        $sdate = date('Y-m-d', strtotime($_POST['sdate']));
        $edate = date('Y-m-d', strtotime($_POST['edate']));
        $nop = (int)$_POST['nop'];
        $price = (int)$_SESSION['tour']['price'];
        $cost = $nop * $price;
        $user_id = $_SESSION['user']['id'];
        $agent_id =  $_SESSION['user']['id'];
        $tour_id = $_SESSION['tour']['id'];
        $bdate=date('Y-m-d');
        $qr = "SELECT agent_id FROM tours WHERE id='$tour_id'";
        $qr_run = mysqli_query($db, $qr);
        $agent = mysqli_fetch_assoc($qr_run);
        $agent_id = $agent['agent_id'];

        $query = "INSERT INTO `book`(`cname`, `cemail`, `cadd`, `bdate`, `sdate`, `edate`, `nop`, `cost`, `user_id`,`agent_id`, `tour_id`)
                   VALUES ('$cname','$cemail','$caddr','$bdate','$sdate','$edate',$nop,$cost,$user_id,$agent_id,$tour_id)";

        if(mysqli_query($db, $query))
        {
            array_push($update, "Booking Received");
            $booking_id=mysqli_insert_id($db);
            $query = "SELECT * FROM book WHERE id='$booking_id'";
            $query_run = mysqli_query($db, $query);
            $book = mysqli_fetch_assoc($query_run);
            $_SESSION['book']=$book;
            $_SESSION['msg']="Booking confirmed Please check mail for details.";
            send_invoice($cemail);
            header("Location:invoice.html");
        }
        else
        {
            array_push($update, "Booking Error");
            
        }


    } 

    function send_invoice($email){
        
        require 'vendor/autoload.php';
        $subtotal=$_SESSION['book']['nop']*$_SESSION['tour']['price'];
        $book_id=$_SESSION['book']['id'];
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
        $output = $dompdf->output();
        file_put_contents("invoices/$book_id.pdf", $output);


		$mailto = "$email";
		$mailSub = "Travelmeister Booking Confirmed Id=".$_SESSION['book']['id'];
		$mailMsg = 'Name:-'.$_SESSION['book']['cname'].'
		<br>No of People:-'.$_SESSION['book']['nop'].'
		<br>Booking Id:-'.$_SESSION['book']['id'];
		require 'PHPMailer-master/PHPMailerAutoload.php';
	   $mail = new PHPMailer();
	   $mail ->IsSmtp();
	   $mail ->SMTPDebug = 0;
	   $mail ->SMTPAuth = true;
	   $mail ->SMTPSecure = 'ssl';
	   $mail ->Host = "smtp.gmail.com";
	   $mail ->Port = 465; // or 587
	   $mail ->IsHTML(true);
	   $mail ->Username = "travelmeistercare@gmail.com";
	   $mail ->Password = "Heydudesupnice2@";
	   $mail ->SetFrom("travelmeistercare@gmail.com");
	   $mail ->Subject = $mailSub;
	   $mail ->Body = $mailMsg;
       $mail ->AddAddress($mailto);
       $mail->addAttachment("invoices/$book_id.pdf", 'invoice.pdf');

	   if(!$mail->Send()){
		echo "<script type='text/javascript'>alert('Some error your query has not been sent');</script>";
	   }
	   else
	   {
		echo "<script type='text/javascript'>alert('We have received your query');</script>";
	   }
    }

    function add_book(){
        global $db,$update;

        $cname = e($_POST['name']);
        $cemail = e($_POST['email']);
        $cadd = e($_POST['addr']);
        $sdate = date('Y-m-d', strtotime($_POST['sdate']));
        $edate = date('Y-m-d', strtotime($_POST['edate']));
        $nop = e($_POST['nop']);
        $cost = e($_POST['cost']);
        $user_id = e($_POST['user_id']);
        $agent_id =  $_SESSION['user']['id'];
        $tour_id = e($_POST['tour_id']);
        $bdate=date('Y-m-d');

        $query = "INSERT INTO `book`(`cname`, `cemail`, `cadd`, `bdate`, `sdate`, `edate`, `nop`, `cost`, `user_id`, `agent_id`, `tour_id`)
                   VALUES ('$cname','$cemail','$cadd','$bdate','$sdate','$edate',$nop,$cost,$user_id,$agent_id,$tour_id)";
        $query_run = mysqli_query($db, $query);

        if($query_run)
        {
            array_push($update, "Booking Added");
            header("Location:agent.html");
        }
        else
        {
            array_push($update, "Booking Not Added");
        }

        
    } 

    function edit_book(){
        global $db,$update;
        $id =e($_POST['update_id']);
        $sdate = date('Y-m-d', strtotime($_POST['sdate']));
        $edate = date('Y-m-d', strtotime($_POST['edate']));
        $nop = e($_POST['nop']);
        $cost = e($_POST['cost']);
        $user_id = e($_POST['user_id']);
        $agent_id =  $_SESSION['user']['id'];
        $tour_id = e($_POST['tour_id']);

        $query = "UPDATE book SET `sdate`='$sdate',`edate`='$edate',
        `nop`=$nop,`cost`=$cost,`user_id`=$user_id,`agent_id`=$agent_id,`tour_id`=$tour_id WHERE id='$id'";
        $query_run = mysqli_query($db, $query);

        if($query_run)
        {
            array_push($update, "Booking Updated");

        }
        else
        {
            array_push($update, "Booking Not Updated");
        }


    }

    function delete_book(){
        global $db,$update;
        $id = e($_POST['delete_id']);
        $query = "DELETE FROM book WHERE id='$id'";
        $query_run = mysqli_query($db, $query);

        if($query_run)
        {
            array_push($update, "Booking deleted");
            header("Location:agent.html");

        }
        else
        {
            array_push($update,"Tour Not Dleted");
        }
    }

    function cancel_book(){
      global $db,$update;
      $id = e($_POST['book_id']);
      $qr = "UPDATE book SET `cancel`='1' WHERE id='$id'";
      $qr_run = mysqli_query($db, $qr);

      if($qr_run)
      {
        array_push($update, "Booking Cancelled");
      }
      else
      {
          array_push($update, "Booking cancellation error");
          
      }
  } 

  function rev_tour(){
    global $db,$update;
    $userid = $_SESSION['user']['id'];
    $tourid = e($_POST['tour_id']);
    $bookid = e($_POST['book_id']);
    $rating = e($_POST['rating']);
    $review = e($_POST['review']);
    $rdate=date('Y-m-d');
    $qr_t = "SELECT * FROM tours WHERE id='$tourid'";
    $qr_runt = mysqli_query($db, $qr_t);
    if($qr_runt){
      $rate = 0;
      $nor =  0;
      $fr = 0;
      $qr_r = "INSERT INTO reviews (`date`, `rating`, `details`, `tour_id`, `user_id`) VALUES ('$rdate','$rating','$review','$tourid','$userid')";
      $qr_runr = mysqli_query($db, $qr_r);
      if($qr_runr){
        $qr_rt = "SELECT * FROM reviews WHERE tour_id='$tourid'";
        $qr_runrt = mysqli_query($db, $qr_rt);
        if($qr_runrt)
        {
          foreach($qr_runrt as $row)
          {
            $rate = $rate + $row['rating'];
            $nor = $nor + 1;
          }
          $fr = $rate/$nor;
        }else{
          array_push($update, "review error update");
        }
        $qr_b = "UPDATE book SET `review`='$rating' WHERE id='$bookid'";
        $qr_runb = mysqli_query($db, $qr_b);
        if($qr_runb){
          $qr_tu = "UPDATE tours SET `rating`='$fr',`nor`='$nor' WHERE id='$tourid'";
          $qr_runtu = mysqli_query($db, $qr_tu);
          array_push($update, "Review Given");
        }else{
          array_push($update, "booking review error");
        }
      }else{
        array_push($update, "review error $tourid,$fr");
      }
    }else{
      array_push($update, "Tour doesnt exists");
    }
} 

    function indicator(){
        global $db,$update;


        if(isset($_POST['search_btn'])){
            $country=e($_POST['country']);
            $_SESSION['sdate']=date('Y-m-d', strtotime($_POST['sdate']));
            $_SESSION['edate']=date('Y-m-d', strtotime($_POST['edate']));
            $_SESSION['country']=$country;
            $query = "SELECT * FROM tours where country='$country'";
        }
        elseif(isset($_POST['filter_btn'])){
            $category="";
            $order="id";
            $rating="0";
            $price="100000000";
            if(isset($_POST['orderby'])){
            $order=e($_POST['orderby']);
            }
            if(isset($_POST['category'])){
            $category=e($_POST['category']);
            }
            if(isset($_POST['price'])){
            $price=e($_POST['price']);
            }
            if(isset($_POST['rating'])){
            $rating=e($_POST['rating']);
            }
            $query = "SELECT * FROM tours WHERE rating >= '$rating' AND price <='$price' AND name REGEXP '$category' ORDER BY $order";
        }
        else{
            $query = "SELECT * FROM tours";

        }

        $query_run = mysqli_query($db, $query);
        $k=1;
        $i=0;
        $j=0;
        $l=0;
        $n=0;
        $rowcount=mysqli_num_rows($query_run);
        $c=$rowcount/4;
        $a=ceil($c);

        echo '
        <div id="multi-item-example" class="carousel slide carousel-multi-item" data-interval="false">

          <!--Controls-->
          <div class="controls-top text-center">
            <a class="btn-floating btn-blue black-text" href="#multi-item-example" data-slide="prev"><i class="fas fa-chevron-left black-text"></i></a>
            <a class="btn-floating btn-blue black-text" href="#multi-item-example" data-slide="next"><i class="fas fa-chevron-right black-text"></i></a>
          </div>';
			if($query_run && ($rowcount!=0)){
              echo '<ol class="carousel-indicators mt-5 mb-2">
              <li data-target="#multi-item-example" data-slide-to="0" class="blue active"></li>';
              while($k < $a){
                echo '<li data-target="#multi-item-example" class="blue" data-slide-to="'.$k.'"></li>';
                $k++;
                }

             echo '</ol>
            <div class="carousel-inner" role="listbox">';
                 while(($j < $a) && ($n < $rowcount)){
                    $l=0;
                    if($j==0){
                        echo '<div class="carousel-item active">';
                        }
                    else{
                        echo '<div class="carousel-item">';
                    }
                    $j++;
                    while(($l < 2) && ($n < $rowcount)){
                        $l++;
                        echo '<div class="row">';
                        $i=0;
                        while(($n < $rowcount) && ($i < 2)){
                            $n++;
                            $row = mysqli_fetch_array($query_run);
                            $rating=$row['rating'];
                            $i++;
                            $imgt=$row['country'].'.jpg';
                            $img=0;
                            $img=explode(',',$row['image']);
                            $path="img/tour/".$row['id']."/";

                            echo '<!-- Grid column-->
                            <div class="col-lg-6 col-md-12 mb-5">

                            
                            <!-- Card-->
                            <div class="card card-ecommerce">

                                <!-- Card image-->
                                <div class="view overlay">
                                <form action="tourpage.html" method="POST">
                                <input type="hidden" name="tour_id" value='.$row['id'].' id="tour_id">
                                <button type="submit" name="tour_btn" style="padding: 0;border: none;background: none">
                                <img src="'.$path.$img[0].'" class="z-depth-1 img-home" alt="Tour image">
                                </button>

                                </div>
                                <!-- Card image-->

                                <!-- Card content-->
                                
                                <div class="card-body">
                                
                                <!-- Category & Title-->
                                <button type="submit" name="tour_btn" style="padding: 0;border: none;background: none">
                                <h5 class="card-title mb-1"><strong>'.$row['name'].'</strong></h5>
                                <span class="badge badge-danger mb-2">'.$row['country'].'</span>
                                <span class="badge badge-danger mb-2">'.$row['continent'].'</span>
                                </button>
                                
                                </form>

                                <!-- Rating-->
                                ';
                                
                                display_star(round($rating));

                                echo '

                                <!-- Card footer-->
                                <div class="card-footer pb-0">

                                    <div class="row mb-0">
                                    <div class="col-lg-6">

                                    <span class="float-left"><strong>Rs.'.$row['price'].'</strong></span>
                                    </div>

                                    <form action="checkout.html" method="POST">
                                    <input type="hidden" name="tour_id" value='.$row['id'].' id="tour_id">
                                    <div class="col-lg-6">

                                    <span class="float-center">

                                        <button type="submit" name="tour_btn" class="btn btn-info btn-rounded btn-sm black-text">BookTour</button>

                                    </span>
                                    </div>
                                    </form>

                                    </div>

                                </div>

                                </div>
                                <!-- Card content-->

                            </div>
                            
                            <!-- Card-->

                            </div>
                            <!-- Grid column-->';}
                            echo '</div>';}

                        echo '</div>';
                            }
                        echo  '</div>';
                        }
                        else{
                            echo "</h3>No record found</h3>";
                        }
                        echo '</div>';
      }

?>
