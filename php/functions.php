<?php

	//session settings
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



	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'travelmeister');

	// variable declaration
 	$name     = "";
	$username = "";
	$email    = "";
	$phno     = "";
	$dob      = "";
	$c        = "";
	$d        = "";
	$errors   = array();
	$update   = array();


	// call the register() function if register_btn is clicked
	if (isset($_POST['register_btn'])) {
		register();
	}
	if (isset($_POST['contactus_btn'])) {
		contact();
	}


	if (isset($_POST['otp_btn']) || isset($_POST['resend_otp'])) {
		forgot();
	}
	if (isset($_POST['submit_otp_btn'])) {
		verify_otp();
	}
	if (isset($_POST['pass_btn'])) {
		verify_pass();
	}


	if (isset($_POST['upimg_btn'])) {
		user_update_img();
	}
	if (isset($_POST['delimg_btn'])) {
		user_delete_img();
	}

	// call the login() function if register_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}
	if (isset($_POST['update_btn']) || isset($_POST['update_btn_admin'])) {
		update();
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		setcookie($sessionName, time() - 3600);
		unset($_SESSION['user']);
		header("location: index.html");
	}

	// REGISTER USER
	function register(){
		global $db, $errors, $update;

		// receive all input values from the form
		$name        =  e($_POST['name']);
		$username    =  e($_POST['username']);
		$email       =  e($_POST['email']);
		$phno        =  e($_POST['phno']);
		$password_1  =  e($_POST['password_1']);
		$password_2  =  e($_POST['password_2']);
		$date        =    $_POST['dob'];
		$dob=date('Y-m-d', strtotime($date));

		// form validation: ensure that the form is correctly filled
		$sql_u = "SELECT * FROM users WHERE username='$username'";
  		$sql_e = "SELECT * FROM users WHERE email='$email'";
		$sql_p = "SELECT * FROM users WHERE phno='$phno'";
  		$res_u = mysqli_query($db, $sql_u);
  		$res_e = mysqli_query($db, $sql_e);
		$res_p = mysqli_query($db, $sql_p);

  	if (mysqli_num_rows($res_u) > 0) {
			array_push($errors, "Sorry... username already taken");
  	}
		if(mysqli_num_rows($res_e) > 0){
			array_push($errors, "Sorry... email already taken");
  	}
		if(mysqli_num_rows($res_p) > 0){
			array_push($errors, "Sorry... account with same phone no exists");
  	}
		if (empty($name)) {
			array_push($errors, "Name is required");
		}
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if ($username=="default") {
			array_push($errors, "Username cant be default");
		}
		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if (empty($phno)) {
			array_push($errors, "Phone no is required");
		}
		if (empty($date)) {
			array_push($errors, "DOB is required");
		}
		else{
			$d=date('Y', strtotime($dob));
			$c=date('Y');
			if(($c-$d)<18){
			array_push($errors, "You should be above 18 years");
			}
		}
		if (empty($password_1)) {
			array_push($errors, "Password is required");
		}
		elseif ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}
		if (strlen($_POST["password_1"]) < '8') {
			array_push($errors, "Your Password Must Contain At Least 8 Characters!");
		}
		elseif(!preg_match("#[0-9]+#",$password_1)) {
			array_push($errors, "Your Password Must Contain At Least 1 Number!");
		}
		elseif(!preg_match("#[A-Z]+#",$password_1)) {
			array_push($errors, "Your Password Must Contain At Least 1 Capital Letter!");
		}
		elseif(!preg_match("#[a-z]+#",$password_1)) {
			array_push($errors, "Your Password Must Contain At Least 1 Lowercase Letter!");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database

			if (isset($_POST['user_type'])) {
				$user_type = e($_POST['user_type']);
				$query = "INSERT INTO users (name, username, email, phno, dob, user_type, password)
						  VALUES('$name', '$username', '$email', '$phno', '$dob', '$user_type', '$password')";
				mysqli_query($db, $query);
				$_SESSION['success']  = "New user successfully created!!";
				header('Location: '.$_SERVER['PHP_SELF']);
			}else{
				$query = "INSERT INTO users (name, username, email, phno, dob, user_type, password)
						  VALUES('$name', '$username', '$email', '$phno', '$dob', 'user', '$password')";
				mysqli_query($db, $query);

				// get id of the created user
				array_push($update, "User added");
				$logged_in_user_id = mysqli_insert_id($db);
				$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
				$_SESSION['success']  = "You are now logged in";
				header('Location: '.$_SERVER['PHP_SELF']);
			}

		}

	}

	// return user array from their id
	function getUserById($id){
		global $db;
		$query = "SELECT * FROM users WHERE id=" . $id;
		$result = mysqli_query($db, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
	}

	// LOGIN USER
	function login(){
		global $db, $username, $errors, $sessionTime, $sessionName;

		// grap form values
		$username = e($_POST['username']);
		$password = e($_POST['password']);

		// make sure form is filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {
			$password = md5($password);

			$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);
					if (!empty($_POST["remember"])) {
						if (isset($_COOKIE['$sessionName'])) {
							setcookie($sessionName, $_COOKIE['$sessionName'], time() + $sessionTime, "/");
							}
						}
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					$site=$_SERVER['PHP_SELF'];
					header("location: $site");

			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

	function user_update_img(){
		global $db, $username, $update;

		$username=$_SESSION['user']['username'];

		$image = $_FILES['image']['name'];
		$fileExt = explode('.',$image);
		$fileActualExt = strtolower(end($fileExt));

		$imgname=$_SESSION['user']['image'];
		$allowed =array('jpg', 'jpeg','png', 'pdf');

		  	// image file directory
		  	$target = "img/profile/".basename($image);

				if($_FILES['image']['type']=='image/jpeg' && $_FILES['image']['size']<1000000){
					$fileNameNew=$username.".".$fileActualExt;
					$target = "img/profile/".$fileNameNew;
					if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
					$sql = "UPDATE users SET image='$fileNameNew' WHERE username ='$username'";
					// execute query
					mysqli_query($db, $sql);
		  		array_push($update, "Image uploaded successfully");
		  	}else{
		  		array_push($update, "Failed to upload image");
		  		}
				}
				else{
					array_push($update, "Selected file is not an image please select Jpeg or jpg image or select file less than 1mb");
				}
		  //$result = mysqli_query($db, "SELECT image FROM user WHERE username='$usernamea'");

			$querya = "SELECT * FROM users WHERE username='$username' LIMIT 1";

			$results = mysqli_query($db, $querya);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
					$logged_in_user = mysqli_fetch_assoc($results);
					$_SESSION['user'] = $logged_in_user;
					array_push($update, "Profile photo updated");
				}
			else{
				array_push($update, "User doesnt exists");
			}

	}

	function user_delete_img(){

		global $db, $username, $update;

		$username=$_SESSION['user']['username'];
		$imgname=$_SESSION['user']['image'];

		if($imgname!="default.jpg"){
			$image = "img/profile/$imgname";
			unlink($image);
   		$sql = "UPDATE users SET image='default.jpg' WHERE username ='$username'";
			// execute query
			mysqli_query($db, $sql);
  		array_push($update, "Image deleted successfully");
			$querya = "SELECT * FROM users WHERE username='$username' LIMIT 1";

			$results = mysqli_query($db, $querya);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
					$logged_in_user = mysqli_fetch_assoc($results);
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now logged in";
					header('location:userdashboard.html');
				}
			else{
				array_push($update, "User Doesnt exists");;
			}
		}
	}

	function user_show_img(){
		if (isLoggedIn()) {
			echo "img/profile/".$_SESSION['user']['image'];
		}
		else{
			echo "img/profile/deafault.jpg";
		}
	}


	function update(){
	global $db, $update, $username;

	if(isset($_POST['update_btn'])){
		$id=$_SESSION['user']['id'];
		$name1=$_SESSION['user']['name'];
		$username=$_SESSION['user']['username'];
		$username1=$_SESSION['user']['username'];
		$email1=$_SESSION['user']['email'];
		$phno1=$_SESSION['user']['phno'];
		$password1=$_SESSION['user']['password'];
		$dob1=$_SESSION['user']['dob'];
		$image1=$_SESSION['user']['image'];
		$user_type=$_SESSION['user']['user_type'];



		// receive all input values from the form
		$usernamea   =  e($_POST['username']);
		$email       =  e($_POST['email']);
		$phno        =  e($_POST['phno']);
		$password    =  e($_POST['password']);
		if(isset($_POST['password_2'])){
			$password_2  =  e($_POST['password_2']);
		}
		$date 			 =	$_POST['dob'];
		$dob=date('Y-m-d', strtotime($date));
		$password_1 = md5($password);
		$query = "SELECT * FROM users WHERE username='$username' AND password='$password_1'";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) {
		// form validation: ensure that the form is correctly filled

		$sql_u = "SELECT * FROM users WHERE username='$usernamea' AND not(id = '$id')";
		$sql_e = "SELECT * FROM users WHERE email='$email' AND not(id = '$id')";
		$sql_p = "SELECT * FROM users WHERE phno='$phno' AND not(id = '$id')";
		$res_u = mysqli_query($db, $sql_u);
		$res_e = mysqli_query($db, $sql_e);
		$res_p = mysqli_query($db, $sql_p);

		if (mysqli_num_rows($res_u) > 0) {
			array_push($update, "Sorry... username already taken");
		}
		if(mysqli_num_rows($res_e) > 0){
			array_push($update, "Sorry... email already taken");
		}
		if(mysqli_num_rows($res_p) > 0){
			array_push($update, "Sorry... account with same phone no exists");
		}
		if (empty($usernamea)) {
			array_push($update, "Username is required");
		}
		if ($usernamea=="default") {
			array_push($update, "Username cant be default");
		}
		if (empty($email)) {
			array_push($update, "Email is required");
		}
		if (empty($phno)) {
			array_push($update, "Phone no is required");
		}
		if (empty($dob)) {
			array_push($update, "DOB is required");
		}
		else{
			$d=date('Y', strtotime($dob));
			$c=date('Y');
			if(($c-$d)<18){
			array_push($update, "Should be above 18 years");
			}
		}
		if (!empty($password_2)) {
		if (strlen($password_2) < '8') {
			array_push($update, "Your Password Must Contain At Least 8 Characters!");
		}
		elseif(!preg_match("#[0-9]+#",$password_2)) {
			array_push($update, "Your Password Must Contain At Least 1 Number!");
		}
		elseif(!preg_match("#[A-Z]+#",$password_2)) {
			array_push($update, "Your Password Must Contain At Least 1 Capital Letter!");
		}
		elseif(!preg_match("#[a-z]+#",$password_2)) {
			array_push($update, "Your Password Must Contain At Least 1 Lowercase Letter!");
		}
	}

		// update user if there are no errors in the form
		if (count($update) == 0) {
			if (isset($_POST['$password_2'])) {
				$password_1 = md5($password_2);
			}
			//encrypt the password before saving in the database
			$query = "UPDATE users SET password='$password_1',username='$usernamea',email='$email',
					  phno='$phno',dob='$dob' WHERE id='$id'";
				mysqli_query($db, $query);
				$_SESSION['user'] = getUserById($id); // put logged in user in session
				array_push($update, "Details Updated");
		}else{
				array_push($update, "update failed");
		}
	}else{
		array_push($update, "update failed password incorrect");
		}
	}else{
	// receive all input values from the form
	$id			 =  e($_POST['id']);
	$name        =  e($_POST['name']);
	$usernamea   =  e($_POST['username']);
	$user_type   =  e($_POST['user_type']);
	$email       =  e($_POST['email']);
	$phno        =  e($_POST['phno']);
	$date 	     =	$_POST['dob'];
	$dob=date('Y-m-d', strtotime($date));
	// form validation: ensure that the form is correctly filled
	$sql_u = "SELECT * FROM users WHERE username='$usernamea' AND not(id = '$id')";
	$sql_e = "SELECT * FROM users WHERE email='$email' AND not(id = '$id')";
	$sql_p = "SELECT * FROM users WHERE phno='$phno' AND not(id = '$id')";
	$res_u = mysqli_query($db, $sql_u);
	$res_e = mysqli_query($db, $sql_e);
	$res_p = mysqli_query($db, $sql_p);

	if (mysqli_num_rows($res_u) > 0) {
		array_push($update, "Sorry... username already taken");
	}
	if(mysqli_num_rows($res_e) > 0){
		array_push($update, "Sorry... email already taken");
	}
	if(mysqli_num_rows($res_p) > 0){
		array_push($update, "Sorry... account with same phone no exists");
	}
	if (empty($name)) {
		array_push($update, "name is required");
	}
	if (empty($usernamea)) {
		array_push($update, "Username is required");
	}
	if ($usernamea=="default") {
		array_push($update, "Username cant be default");
	}
	if (empty($email)) {
		array_push($update, "Email is required");
	}
	if (empty($phno)) {
		array_push($update, "Phone no is required");
	}
	if (empty($dob)) {
		array_push($update, "DOB is required");
	}
	else{
		$d=date('Y', strtotime($dob));
		$c=date('Y');
		if(($c-$d)<18){
		array_push($update, "Should be above 18 years");
		}
	}

	// update user if there are no errors in the form
	    if (count($update) == 0) {
		    //encrypt the password before saving in the database
			$query = "UPDATE users SET name='$name',username='$usernamea',email='$email',
					 phno='$phno',dob='$dob',user_type='$user_type' WHERE id='$id'";
			mysqli_query($db, $query);
			array_push($update, "Details Updated");
	    }else{
			array_push($update, "update failed");
		}

	    }

 	}


function forgot(){
	global $db, $update;

	$generator = "1357902468";

    $result = "";

    for ($i = 1; $i <= 5; $i++) {
        $result .= substr($generator, (rand()%(strlen($generator))), 1);
    }
	if(isset($_SESSION['add1']) && !isset($_POST['add'])){
		$add       =  $_SESSION['add1'];
		$data      =  $_SESSION['otp_add1'];
	}
	else{
		$add       =  e($_POST['add']);
		$data      =  e($_POST['otp_add']);
		$_SESSION['add1']="$add";
		$_SESSION['otp_add1']="$data";
	}

	$query = "SELECT * FROM users WHERE email='$data' OR phno='$data'";
	$results = mysqli_query($db, $query);

	if (mysqli_num_rows($results) == 1) {

		if($add=="email"){

		$message="Your OTP is:".$result;
		$mailto = "$data";
		$mailSub = "Travelmeister:Verify you otp";
		$mailMsg = "$message";
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

	   if(!$mail->Send()){
		array_push($update, "Otp not sent enter correct email");
	   }
	   else
	   {
			array_push($update, "Otp sent to email enter otp");
		   $_SESSION['otp']=$result;
		   $_SESSION['email']=$data;
		   if(!isset($_POST['resend_otp'])){
			header('location:submitotp.html');
			}
	   }
	    }
	 elseif($add=="phno"){
		$field = array(
			"sender_id" => "TMTour",
			"language" => "english",
			"route" => "qt",
			"numbers" => "$data",
			"message" => "27497",
			"variables" => "{#AA#}",
			"variables_values" => "$result"
		);

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($field),
		  CURLOPT_HTTPHEADER => array(
			"authorization: l5AKjqFuCRi0kp6BarzwHZ2hQxTMgUPDobstyEO9fXecJ1nWL3GEkRVfNXsZIdLSgoKaqjxOT8evt9Aw",
			"accept: */*",
			"cache-control: no-cache",
			"content-type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			array_push($update, "Otp not sent to phone no");
		} else {
			$_SESSION['otp']=$result;
			$_SESSION['email']=$data;
			array_push($update, "Otp sent to phone number enter otp");
			if(!isset($_POST['resend_otp'])){
			header('location:submitotp.html');
			}
		}


	 }
	 else{
		array_push($update, "Otp sending error");
	 }
    }
  else{
	array_push($update, "No user with enetered details try again or register");

	}

}

function verify_otp(){
	global $db, $update;

	$otp=$_SESSION['otp'];
	$data=$_SESSION['email'];


	$add = e($_POST['otp']);

	if($add==$otp){
		$_SESSION['otp1']=$otp;
		header('location:password.html');

	}
	else{
		array_push($update, "Otp entered is wrong");

	}

}

function verify_pass(){
	global $db, $update;

	$data=$_SESSION['email'];

	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	if (empty($password_1)) {
		array_push($update, "Password is required");
	}
	elseif ($password_1 != $password_2) {
		array_push($update, "The two passwords do not match");
	}
	if (strlen($_POST["password_1"]) < '8') {
		array_push($update, "Your Password Must Contain At Least 8 Characters!");
	}
	elseif(!preg_match("#[0-9]+#",$password_1)) {
		array_push($update, "Your Password Must Contain At Least 1 Number!");
	}
	elseif(!preg_match("#[A-Z]+#",$password_1)) {
		array_push($update, "Your Password Must Contain At Least 1 Capital Letter!");
	}
	elseif(!preg_match("#[a-z]+#",$password_1)) {
		array_push($update, "Your Password Must Contain At Least 1 Lowercase Letter!");
	}

	// register user if there are no errors in the form
	if (count($update) == 0) {
		$password = md5($password_2);
		$sql = "UPDATE users SET password='$password' WHERE email ='$data' OR phno='$data'";
		$result=mysqli_query($db, $sql);
		if($result){
			unset($_SESSION['email']);
			$_SESSION['success']="Password Updated";
			header("location: index.html");
		}else{
			array_push($update, "Some error Re-enter password");
		}
	}else{
		array_push($update, "Re-enter password");
	}
}


  ///display functions

	function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	function isAdmin()
	{
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
			return true;
		}else{
			return false;
		}
	}
	function isAgent()
	{
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'agent' ) {
			return true;
		}else{
			return false;
		}
	}
	function isUser()
	{
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'user' ) {
			return true;
		}else{
			return false;
		}
	}




	// escape string
	function e($val){
		global $db;
		return mysqli_real_escape_string($db, trim($val));
	}

	function display_success() {
		if (isset($_SESSION['success']) > 0){
			echo '<div class="alert alert-danger" role="alert">';
					echo $_SESSION['success'].'abc' .'<br>';
					echo '</div>';
		}
		msg_unset();
	}

	function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="alert alert-danger" role="alert">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
				echo '</div>';
	}
  }

	function display_update_error() {
	global $update;
	if (count($update) > 0){
		echo '<div class="alert alert-danger" role="alert">';
			foreach ($update as $error){  
				echo $error.'<br>';
			}
				echo '</div>';
			}

	}


  function display_alert() {
  global $errors;
  $success="";
  $msg="";
  $msger="Login/register Error occured";

  if (count($errors) > 0){
		echo "<script type='text/javascript'>alert('$msger');</script>";
		}
  if(isset($_SESSION['success'])) {
		$success=$_SESSION['success'];
		echo "<script type='text/javascript'>alert('$success');</script>";

	}
  if(isset($_SESSION['msg'])) {
		$msg=$_SESSION['msg'];
		echo "<script type='text/javascript'>alert('$msg');</script>";

	}
  }
   
  
  function display_star($star) {

	$i = 5-$star;
	echo'<ul class="rating mb-0">';

    while($star>0){
		echo'<li>

		<i class="fas fa-star blue-text"></i>
  
		</li>';
		$star = $star-1 ;
	}

	while($i > 0){
		echo'<li>

		<i class="fas fa-star grey-text"></i>
  
		  </li>';
		  $i = $i-1 ;
	}

  	echo'</ul>';
	}

  function msg_unset(){
	unset($_SESSION['msg']);
	unset($_SESSION['success']);

  }
  function tourbook_unset(){
	unset($_SESSION['book']);
	unset($_SESSION['tour']);
  }

	function display_link() {
		if (!isLoggedIn()) {
			echo "login.html";
		}
		else{
			echo "dashboard.html";
		}
	}

	function display_name() {
		if (isLoggedIn()) {
			echo $_SESSION['user']['name'];
		}
	}

	function display_uname() {
		if (isLoggedIn()) {
			echo $_SESSION['user']['username'];
		}
	}
	function display_user_type() {
		if (isLoggedIn()) {
			echo $_SESSION['user']['user_type'];
		}
	}


	function display_email() {
		if (isLoggedIn()) {
			echo $_SESSION['user']['email'];
		}
	}

	function display_dob() {
		if (isLoggedIn()) {
			$dob=date('d-m-Y', strtotime($_SESSION['user']['dob']));
			echo $dob;
		}
	}

		function display_password() {
		if (isLoggedIn()) {
			echo $_SESSION['user']['password'];
		}
	}

		function display_phno() {
		if (isLoggedIn()) {
			echo $_SESSION['user']['phno'];
		} 
	}
	function display_sdate() {
		if (isset($_SESSION['sdate'])) {
			echo $_SESSION['sdate'];
		} 
	}
	function display_edate() {
		if (isset($_SESSION['edate'])) {
			echo $_SESSION['edate'];
		} 
    }


function contact(){
	global $db, $update;
	require 'PHPMailer-master/PHPMailerAutoload.php';

	$name       =  e($_POST['name']);
	$email     =  e($_POST['email']);
	$sub       =  e($_POST['subject']);
	$msg   =  e($_POST['message']);

	$query = "INSERT INTO contact (`name`, `email`, `subject`, `message`) VALUES ('$name','$email','$sub','$msg')";
	$results = mysqli_query($db, $query);
	

	if ($results) {
		$id=mysqli_insert_id($db);
		$message=$msg;
		$mailto = "travelmeistercare@gmail.com";
		$mailSub = "$sub";
		$mailMsg = 'Name:-'.$name.'
		<br>Emailid:-'.$email.'
		<br>Customer Query:-'.$message;
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

	   if(!$mail->Send()){
		echo "<script type='text/javascript'>alert('Some error your query has not been sent');</script>";
	   }
	   else
	   {
		   $a=rand();
		$message=$msg;
		$mailto = "$email";
		$mailSub = "Your query to TravelmeisterTours has been received ".$name;
		$mailMsg = "<h4 class='font-weight-bold'>Dear Customer,</h4>
		<br>Query Id:-$id
		<br>Your msg subject:-$sub
		<br>Your Query:-$message
		<br>We will get back to you in 24 to 48 hours
		<br><h6 class='light-grey-text'>$name</h6>
		<br>Thank you,
		<br>TravelmeisterTours Support";
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

	   if(!$mail->Send()){
		echo "<script type='text/javascript'>alert('Some error your query has been recieved but mail has not been sent to you');</script>";
	   }
	   else
	   {
		echo "<script type='text/javascript'>alert('We have received your query');</script>";
	   }
	   }
	}
	else{
	echo "<script type='text/javascript'>alert('Some error your query has not been sent');</script>";
	}

}

	include 'components.php';
	include 'tablefunctions.php';


?>
