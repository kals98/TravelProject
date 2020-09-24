<?php

function display_noti() {
  global $db, $update;
if (isLoggedIn()) {
  $id=$_SESSION['user']['id'];
  $query = "SELECT * FROM book WHERE user_id='$id' ORDER BY id desc LIMIT 3";
  $query_run = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($query_run);
  $i= mysqli_num_rows($query_run);
  echo '<li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle waves-effect" id="navbarDropdownMenuLink" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <span class="badge red">'.$i.'</span> <i class="fas fa-bell"></i>
      </a>
      <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">';
  if($query_run){
          foreach($query_run as $row){
    echo '
      <a class="dropdown-item" href="booking.html">
      <i class="far fa-money-bill-alt mr-2" aria-hidden="true"></i>
      <span>Booking Confirmed</span>
      <span class="float-right">#'.$row['id'].'</span>
      </a>';
    }
    echo '</div>
    </li>';
   }
}
}

function display_login() {
  if (isLoggedIn()) {
    echo ' <li class="nav-item dropdown">
             <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img src="'.'img/'.'profile/'.$_SESSION['user']['image'].'" class="rounded-circle z-depth-0"
                alt="avatar image" height="28" width="28"><span class="clearfix d-inline d-sm-inline-block"> ';
                display_name();
    echo '</span></a>
          <div class="dropdown-menu dropdown-menu-lg-right"
                    aria-labelledby="navbarDropdownMenuLink-55">
                    <a class="dropdown-item" href="userdashboard.html">Account Details</a>
                    <a class="dropdown-item" href="booking.html">Booking Details</a>
                    <a class="dropdown-item red" href="index.html?logout="1"">Log out</a>
                    </div>';
  }
  else{
    echo '<li class="nav-item avatar">
          <a class="nav-link" id="loginMenuLink" data-toggle="modal" data-target="#modalLRForm" href="">
          <img src="img/profile/default.jpg" class="rounded-circle z-depth-0"
          alt="avatar image" height="28">Login/signup
          </a>';
  }
}

function nav_display(){
  

  echo '<header>
  <nav class="navbar navbar-light navbar-expand-lg scrolling-navbar bg-primary font-weight-bold">

      <div class="container-fluid">

          <!-- Navbar brand -->
          <a class="navbar-brand" href="index.html"><i class="fas fa-biking"></i>Travelmeister Tours</a>

          <!-- Collapse button -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navBar"
              aria-controls="navBar" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Collapsible content -->
          <div class="collapse navbar-collapse" id="navBar">

              <!-- Links -->
              <ul class="navbar-nav ml-auto mr-auto smooth-scroll">
                  <li class="nav-item">
                      <a class="nav-link" href="index.html#intro"><i class="fas fa-home"></i>Home</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="index.html#search"><i class="fas fa-search"></i>Search</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="index.html#best-features"><i class="fas fa-heart"></i>Features</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="index.html#examples"><i class="fas fa-suitcase"></i>Destinations</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="index.html#aboutus"><i class="fas fa-user-secret"></i>About</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="index.html#contact"><i class="fas fa-envelope"></i>Contact</a>
                  </li>
                  <li class="nav-item">
                  <div class="ml-auto mb-0 mr-3 change-mode-wrapper">
                  <button class="btn btn-outline-black btn-sm" id="dark-mode">Colour Mode</button>
                  </div>
                  </li>


              </ul>
              <!-- Links -->

              <!-- Alert and profile  -->
              <ul class="navbar-nav mr-auto smooth-scroll">';
                      display_noti();
                      display_login();
      echo '			</li>
                </ul>
          </div>
          <!-- Collapsible content -->

      </div>

  </nav>

  <!--Modal: Login / Register Form-->
  <div class="modal fade" id="modalLRForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog cascading-modal" role="document">
    <!--Content-->
    <div class="modal-content">

      <!--Modal cascading tabs-->
      <div class="modal-c-tabs">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs md-tabs blue-gradient" role="tablist">
          <li class="nav-item">
            <a class="nav-link active black-text" data-toggle="tab" href="#panel7" role="tab"><i class="fas fa-user mr-1"></i>
              Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link black-text" data-toggle="tab" href="#panel8" role="tab"><i class="fas fa-user-plus mr-1"></i>
              Register</a>
          </li>
        </ul>

        <!-- Tab panels -->
        <div class="tab-content">
          <!--Panel 7-->
          <div class="tab-pane fade in show active" id="panel7" role="tabpanel">
            <form action="index.html" method="POST">
            <!--Body-->
            <div class="modal-body mb-1">
            <div>';
            display_error();
            echo '
            </div>
              <div class="md-form form-sm mb-5 required">
                <i class="fas fa-envelope prefix"></i>
                <input type="text" name="username" id="modalLRInput10" class="form-control form-control-sm" required>
                <label for="modalLRInput10">Your username</label>
              </div>

              <div class="md-form form-sm mb-4 required">
                <i class="fas fa-lock prefix"></i>
                <input type="password" name="password" id="modalLRInput11" class="form-control form-control-sm validate" required="required">
                <label class="control-label" data-error="wrong" data-success="right" for="modalLRInput11">Your password</label>
              </div>
              <div class="d-flex justify-content-around">
              <div>
            <!-- Remember me -->
          <div class="form-group">
            <input type="checkbox" class="form-check-input" name="remember" id="materialLoginFormRemember">
            <label class="form-check-label" for="materialLoginFormRemember">Remember me</label>
            </div>
          </div>
        <div>
          <!-- Forgot password -->
          <a href="forgot.html">Forgot password?</a>
          </div>
            </div>
              <div class="text-center mt-2">
                <button class="btn btn-info black-text" name="login_btn" value="Login" type="submit">Log in <i class="fas fa-sign-in ml-1"></i></button>
              </div>
            </div>
            <!--Footer-->
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-info waves-effect ml-auto" data-dismiss="modal">Close</button>
            </div>
            </form>

          </div>
          <!--/.Panel 7-->

          <!--Panel 8-->
          <div class="tab-pane fade" id="panel8" role="tabpanel">

            <!--Body-->
            <form name="registerForm" onsubmit="return validateForm()" action="index.html" method="post">
            <div class="modal-body">
            <div class="md-form form-sm mb-5 required">';
            display_error();
            echo '
            </div>
            <div class="md-form form-sm mb-5 required">
              <i class="fas fa-envelope prefix"></i>
              <input type="text" id="modalLRInput18" name="name" class="form-control form-control-sm" required="required">
              <label for="modalLRInput18">Your Full Name</label>
            </div>
              <div class="md-form form-sm mb-5 required">
                <i class="fas fa-envelope prefix"></i>
                <input type="text" id="modalLRInput13" name="username" class="form-control form-control-sm" required="required">
                <label for="modalLRInput13">Your username</label>
              </div>
              <div class="md-form form-sm mb-5 required">
                <i class="fas fa-envelope prefix"></i>
                <input type="email" name="email" id="modalLRInput14" class="form-control form-control-sm" required="required">
                <label for="modalLRInput14">Your email</label>
              </div>
              <div class="md-form form-sm mb-5 required">
                <i class="fas fa-phone-square prefix"></i>
                <input type="number" max="9999999999" name="phno" id="modalLRInputphone" class="form-control form-control-sm" required="required">
                <label for="modalLRInputphone">Your 10 digit mobile no</label>
              </div>

              <div class="md-form form-sm mb-5 date required ">
                <i class="fas fa-calendar prefix"></i>
                <input type="text" name="dob" id="modalLRInput15" class="form-control form-control-sm  datepicker" required="required">
                <label for="modalLRInput15">Select DOB</label>
              </div>

              <div class="md-form form-sm mb-5 required">
                <i class="fas fa-lock prefix"></i>
                <input type="password" name="password_1" id="modalLRInput16" class="form-control form-control-sm" required="required">
                <label for="modalLRInput16">Your password</label>
                <strong id="passerror" class="red-text"></strong>
              </div>

              <div class="md-form form-sm mb-4 required">
                <i class="fas fa-lock prefix"></i>
                <input type="password" name="password_2" id="modalLRInput17" class="form-control form-control-sm" required="required">
                <label for="modalLRInput17">Repeat password</label>
                <strong id="passmatch" class="red-text"></strong>
              </div>

              <div class="text-center form-sm mt-2">
                <button class="btn btn-info black-text" type="submit" name="register_btn" value="Sign Up">Sign up <i class="fas fa-sign-in ml-1"></i></button>
              </div>

            </div>
            <!--Footer-->
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-info waves-effect ml-auto" data-dismiss="modal">Close</button>
            </div>
            </form>
          </div>
          <!--/.Panel 8-->
        </div>

      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: Login / Register Form-->
</header>';
}

function display_footer(){
  echo '
<footer class="page-footer font-small primary-color black-text">

    <!-- Social buttons -->
    <div class="">
        <div class="container">
            <!--Grid row-->
            <div class="row py-4 d-flex align-items-center">

                <!--Grid column-->
                <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
                    <h5 class="mb-0 font-weight-bold black-text">Get connected with us on social networks!</h6>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6 col-lg-7 text-center text-md-right">
                    <!--Facebook-->
                    <a class="fb-ic ml-0">
                        <i class="fab fa-facebook fa-lg black-text mr-4"> </i>
                    </a>
                    <!--Twitter-->
                    <a class="tw-ic">
                        <i class="fab fa-twitter fa-lg black-text mr-4"> </i>
                    </a>
                    <!--Google +-->
                    <a class="gplus-ic">
                        <i class="fab fa-google fa-lg black-text mr-4"> </i>
                    </a>
                    <!--Linkedin-->
                    <a class="li-ic">
                        <i class="fab fa-linkedin fa-lg black-text mr-4"> </i>
                    </a>
                    <!--Instagram-->
                    <a class="ins-ic">
                        <i class="fab fa-instagram fa-lg black-text mr-4"> </i>
                    </a>
                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->
        </div>
    </div>
    <!-- Social buttons -->

    <!--Footer Links-->
    <div class="container mt-5 mb-4 text-center text-md-left">
        <div class="row mt-3">

            <!--First column-->
            <div class="col-md-4 col-lg-4 col-xl-3 mb-4">
                <h6 class="text-uppercase font-weight-bold">
                    <strong>Travelmeister Tours</strong>
                </h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>We Are dedicated towards you.Please contact us anytime between 8.30am-3.00 pm we are here to help.
                Our customer service team is working towars 100% customer satisfaction</p>
            </div>
            <!--/.First column-->

            <!--Third column-->
            <div class="col-md-4 col-lg-4 col-xl-2 mx-auto mb-4">
                <h6 class="text-uppercase font-weight-bold">
                    <strong>Useful links</strong>
                </h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>
                    <a href="userdashboard.html" class="black-text">Your Account</a>
                </p>
                <p>
                    <a href="index.html#search" class="black-text">Search Tours</a>
                </p>
                <p>
                    <a href="index.html#contact" class="black-text">Contact Us</a>
                </p>
                <p>
                    <a href="index.html#aboutus" class="black-text">About US</a>
                </p>
            </div>
            <!--/.Third column-->

            <!--Fourth column-->
            <div class="col-md-4 col-lg-4 col-xl-3">
                <h6 class="text-uppercase font-weight-bold">
                    <strong>Contact</strong>
                </h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>
                    <i class="fas fa-home mr-3"></i></i> <a  href="https://g.page/mit-wpu?share" class="black-text">MIT WPU,Pune, MH 411038, IND</a></p>
                <p>
                    <i class="fa fa-envelope mr-3"></i><a href="mailto:travelmeistercare@gmail.com" class="black-text">travelmeistercare@gmail.com</a></p>
                <p>
                    <i class="fa fa-phone mr-3"></i><a href="tel:+918879305922" class="black-text"> + 91 8879305922</a></p>
                <p>
                    <i class="fa fa-print mr-3"></i><a href="tel:+912224160333" class="black-text"> + 91 2224160333</a></p>
            </div>
            <!--/.Fourth column-->

        </div>
    </div>
    <!--/.Footer Links-->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2018 Copyright:
        <a href="https://mdbootstrap.com/bootstrap-tutorial/"> travelmeistertours</a>
    </div>
    <!-- Copyright -->

</footer>
';
}

function display_more(){
  if(isAgent()){
  echo'
      <hr class="my-5">

      <!--Section: More controls -->
      <section class="section pb-5">

        <!--Section heading -->
        <h4 class="text-center my-5 h1 pt-4">More options</h4>
        <section class="section">
          <!-- First row -->
          <div class="row">
            <!-- First column -->
            <div class="col-lg-6 text-center mb-4">
            <a href="agent.html">
            <button class="btn btn-primary waves-effect btn-lg waves-light black-text">Agent Dashboard</button>
            </a>
            </div>
            <div class="col-lg-6 text-center mb-4">
            <a href="booking.html">
            <button class="btn btn-primary waves-effect btn-lg waves-light black-text">View your Bookings</button>
            </a>
            </div>
          </div>
        </section>';

      }
 elseif(isAdmin()){
   echo'
       <hr class="my-5">

       <!--Section: More controls -->
       <section class="section pb-5">

         <!--Section heading -->
         <h4 class="text-center my-5 h1 pt-4">More options</h4>
         <section class="section">
           <!-- First row -->
           <div class="row">
             <!-- First column -->
             <div class="col-lg-6 text-center mb-4">
             <a href="admin.html">
             <button class="btn btn-primary waves-effect btn-lg waves-light black-text">Admin Dashboard</button>
             </a>
             </div>
             <div class="col-lg-6 text-center mb-4">
             <a href="booking.html">
             <button class="btn btn-primary waves-effect btn-lg waves-light black-text">View your Bookings</button>
             </a>
             </div>
           </div>
         </section>';
 }
 elseif(isUser()){
   echo'
       <hr class="my-5">

       <!--Section: More controls -->
       <section class="section pb-5">

         <!--Section heading -->
         <h4 class="text-center my-5 h1 pt-4">More options</h4>
         <section class="section">
           <!-- First row -->
           <div class="row">
             <!-- First column -->
             <div class="col-lg-12 text-center mb-4">
             <a href="booking.html">
             <button class="btn btn-primary waves-effect btn-lg waves-light black-text">View your Current Bookings</button>
             </a>
             </div>
           </div>
         </section>';
 }
}

function show_otp(){
  echo '<div class="row">

  <!-- First column -->
  <div class="col-md-12">
    <div class="md-form mb-0">
      <input type="number" id="form76" class="form-control validate" name="otp">
      <label for="form76">Enter otp</label>
    </div>
  </div>
  <!-- Second column -->
  </div>';
}


function show_password(){
  echo '
    <!-- First column -->
    <div class="col-md-6">
    <label for="form77"><h4>New Password</h4></label>
      <div class="md-form mb-0 md-outline">
        <input type="password" id="form77" class="form-control" name="password_1" autocomplete="off new-password" required>
        <label for="form77">New Password</label>
      </div>
    </div>

    <!-- Second column -->

    <div class="col-md-6">
    <label for="form79"><h4>Confirm New Password</h4></label>
      <div class="md-form mb-0 md-outline">
        <input type="password" id="form79" class="form-control" name="password_2"  autocomplete="off new-password" required>
        <label for="form79">Confirm New Password</label>
      </div>
    </div>
  </div>
  ';
}
function show_country(){
  echo "<option value=''>Select Country</option>
  <option value='Afghanistan'>Afganisthan</option>
  <option value='Åland Islands'>Åland Islands</option>
  <option value='Albania'>Albania</option>
  <option value='Algeria'>Algeria</option>
  <option value='American Samoa'>American Samoa</option>
  <option value='Andorra'>Andorra</option>
  <option value='Angola'>Angola</option>
  <option value='Anguilla'>Anguilla</option>
  <option value='Antarctica'>Antarctica</option>
  <option value='Antigua and Barbuda'>Antigua and Barbuda</option>
  <option value='Argentina'>Argentina</option>
  <option value='Armenia'>Armenia</option>
  <option value='Aruba'>Aruba</option>
  <option value='Australia'>Australia</option>
  <option value='Austria'>Austria</option>
  <option value='Azerbaijan'>Azerbaijan</option>
  <option value='Bahamas'>Bahamas</option>
  <option value='Bahrain'>Bahrain</option>
  <option value='Bangladesh'>Bangladesh</option>
  <option value='Barbados'>Barbados</option>
  <option value='Belarus'>Belarus</option>
  <option value='Belgium'>Belgium</option>
  <option value='Belize'>Belize</option>
  <option value='Benin'>Benin</option>
  <option value='Bermuda'>Bermuda</option>
  <option value='Bhutan'>Bhutan</option>
  <option value='Bolivia'>Bolivia</option>
  <option value='Bosnia and Herzegovina'>Bosnia and Herzegovina</option>
  <option value='Botswana'>Botswana</option>
  <option value='Bouvet Island'>Bouvet Island</option>
  <option value='Brazil'>Brazil</option>
  <option value='British Indian Ocean Territory'>British Indian Ocean Territory</option>
  <option value='Brunei Darussalam'>Brunei Darussalam</option>
  <option value='Bulgaria'>Bulgaria</option>
  <option value='Burkina Faso'>Burkina Faso</option>
  <option value='Burundi'>Burundi</option>
  <option value='Cambodia'>Cambodia</option>
  <option value='Cameroon'>Cameroon</option>
  <option value='Canada'>Canada</option>
  <option value='Cape Verde'>Cape Verde</option>
  <option value='Cayman Islands'>Cayman Islands</option>
  <option value='Central African Republic'>Central African Republic</option>
  <option value='Chad'>Chad</option>
  <option value='Chile'>Chile</option>
  <option value='China'>China</option>
  <option value='Christmas Island'>Christmas Island</option>
  <option value='Cocos (Keeling) Islands'>Cocos (Keeling) Islands</option>
  <option value='Colombia'>Colombia</option>
  <option value='Comoros'>Comoros</option>
  <option value='Republic of The Congo'>Republic of The Congo</option>
  <option value='The Democratic Republic of The Congo'>The Democratic Republic of The Congo</option>
  <option value='Cook Islands'>Cook Islands</option>
  <option value='Costa Rica'>Costa Rica</option>
  <option value='Cote Divoire'>Cote Divoire</option>
  <option value='Croatia'>Croatia</option>
  <option value='Cuba'>Cuba</option>
  <option value='Cyprus'>Cyprus</option>
  <option value='Czech Republic'>Czech Republic</option>
  <option value='Denmark'>Denmark</option>
  <option value='Djibouti'>Djibouti</option>
  <option value='Dominica'>Dominica</option>
  <option value='Dominican Republic'>Dominican Republic</option>
  <option value='Ecuador'>Ecuador</option>
  <option value='Egypt'>Egypt</option>
  <option value='El Salvador'>El Salvador</option>
  <option value='Equatorial Guinea'>Equatorial Guinea</option>
  <option value='Eritrea'>Eritrea</option>
  <option value='Estonia'>Estonia</option>
  <option value='Ethiopia'>Ethiopia</option>
  <option value='Falkland Islands (Malvinas)'>Falkland Islands (Malvinas)</option>
  <option value='Faroe Islands'>Faroe Islands</option>
  <option value='Fiji'>Fiji</option>
  <option value='Finland'>Finland</option>
  <option value='France'>France</option>
  <option value='French Guiana'>French Guiana</option>
  <option value='French Polynesia'>French Polynesia</option>
  <option value='French Southern Territories'>French Southern Territories</option>
  <option value='Gabon'>Gabon</option>
  <option value='Gambia'>Gambia</option>
  <option value='Georgia'>Georgia</option>
  <option value='Germany'>Germany</option>
  <option value='Ghana'>Ghana</option>
  <option value='Gibraltar'>Gibraltar</option>
  <option value='Greece'>Greece</option>
  <option value='Greenland'>Greenland</option>
  <option value='Grenada'>Grenada</option>
  <option value='Guadeloupe'>Guadeloupe</option>
  <option value='Guam'>Guam</option>
  <option value='Guatemala'>Guatemala</option>
  <option value='Guernsey'>Guernsey</option>
  <option value='Guinea'>Guinea</option>
  <option value='Guinea-bissau'>Guinea-bissau</option>
  <option value='Guyana'>Guyana</option>
  <option value='Haiti'>Haiti</option>
  <option value='Heard Island and Mcdonald Islands'>Heard Island and Mcdonald Islands</option>
  <option value='Vatican City'>Vatican City</option>
  <option value='Honduras'>Honduras</option>
  <option value='Hong Kong'>Hong Kong</option>
  <option value='Hungary'>Hungary</option>
  <option value='Iceland'>Iceland</option>
  <option value='India'>India</option>
  <option value='Indonesia'>Indonesia</option>
  <option value='Iran'>Iran</option>
  <option value='Iraq'>Iraq</option>
  <option value='Ireland'>Ireland</option>
  <option value='Isle of Man'>Isle of Man</option>
  <option value='Israel'>Israel</option>
  <option value='Italy'>Italy</option>
  <option value='Jamaica'>Jamaica</option>
  <option value='Japan'>Japan</option>
  <option value='Jersey'>Jersey</option>
  <option value='Jordan'>Jordan</option>
  <option value='Kazakhstan'>Kazakhstan</option>
  <option value='Kenya'>Kenya</option>
  <option value='Kiribati'>Kiribati</option>
  <option value='North Korea'>North Korea</option>
  <option value='South Korea'>South Korea</option>
  <option value='Kuwait'>Kuwait</option>
  <option value='Kyrgyzstan'>Kyrgyzstan</option>
  <option value='Laos'>Laos</option>
  <option value='Latvia'>Latvia</option>
  <option value='Lebanon'>Lebanon</option>
  <option value='Lesotho'>Lesotho</option>
  <option value='Liberia'>Liberia</option>
  <option value='Libyan Arab Jamahiriya'>Libyan Arab Jamahiriya</option>
  <option value='Liechtenstein'>Liechtenstein</option>
  <option value='Lithuania'>Lithuania</option>
  <option value='Luxembourg'>Luxembourg</option>
  <option value='Macao'>Macao</option>
  <option value='Macedonia'>Macedonia</option>
  <option value='Madagascar'>Madagascar</option>
  <option value='Malawi'>Malawi</option>
  <option value='Malaysia'>Malaysia</option>
  <option value='Maldives'>Maldives</option>
  <option value='Mali'>Mali</option>
  <option value='Malta'>Malta</option>
  <option value='Marshall Islands'>Marshall Islands</option>
  <option value='Martinique'>Martinique</option>
  <option value='Mauritania'>Mauritania</option>
  <option value='Mauritius'>Mauritius</option>
  <option value='Mayotte'>Mayotte</option>
  <option value='Mexico'>Mexico</option>
  <option value='Micronesia'>Micronesia</option>
  <option value='Moldova'>Moldova</option>
  <option value='Monaco'>Monaco</option>
  <option value='Mongolia'>Mongolia</option>
  <option value='Montenegro'>Montenegro</option>
  <option value='Montserrat'>Montserrat</option>
  <option value='Morocco'>Morocco</option>
  <option value='Mozambique'>Mozambique</option>
  <option value='Myanmar'>Myanmar</option>
  <option value='Namibia'>Namibia</option>
  <option value='Nauru'>Nauru</option>
  <option value='Nepal'>Nepal</option>
  <option value='Netherlands'>Netherlands</option>
  <option value='New Caledonia'>New Caledonia</option>
  <option value='New Zealand'>New Zealand</option>
  <option value='Nicaragua'>Nicaragua</option>
  <option value='Niger'>Niger</option>
  <option value='Nigeria'>Nigeria</option>
  <option value='Niue'>Niue</option>
  <option value='Norfolk Island'>Norfolk Island</option>
  <option value='Northern Mariana Islands'>Northern Mariana Islands</option>
  <option value='Norway'>Norway</option>
  <option value='Oman'>Oman</option>
  <option value='Pakistan'>Pakistan</option>
  <option value='Palau'>Palau</option>
  <option value='Palestine'>Palestine</option>
  <option value='Panama'>Panama</option>
  <option value='Papua New Guinea'>Papua New Guinea</option>
  <option value='Paraguay'>Paraguay</option>
  <option value='Peru'>Peru</option>
  <option value='Philippines'>Philippines</option>
  <option value='Pitcairn'>Pitcairn</option>
  <option value='Poland'>Poland</option>
  <option value='Portugal'>Portugal</option>
  <option value='Puerto Rico'>Puerto Rico</option>
  <option value='Qatar'>Qatar</option>
  <option value='Reunion'>Reunion</option>
  <option value='Romania'>Romania</option>
  <option value='Russia'>Russia</option>
  <option value='Rwanda'>Rwanda</option>
  <option value='Saint Helena'>Saint Helena</option>
  <option value='Saint Kitts and Nevis'>Saint Kitts and Nevis</option>
  <option value='Saint Lucia'>Saint Lucia</option>
  <option value='Saint Pierre and Miquelon'>Saint Pierre and Miquelon</option>
  <option value='Saint Vincent and The Grenadines'>Saint Vincent and The Grenadines</option>
  <option value='Samoa'>Samoa</option>
  <option value='San Marino'>San Marino</option>
  <option value='Sao Tome and Principe'>Sao Tome and Principe</option>
  <option value='Saudi Arabia'>Saudi Arabia</option>
  <option value='Senegal'>Senegal</option>
  <option value='Serbia'>Serbia</option>
  <option value='Seychelles'>Seychelles</option>
  <option value='Sierra Leone'>Sierra Leone</option>
  <option value='Singapore'>Singapore</option>
  <option value='Slovakia'>Slovakia</option>
  <option value='Slovenia'>Slovenia</option>
  <option value='Solomon Islands'>Solomon Islands</option>
  <option value='Somalia'>Somalia</option>
  <option value='South Africa'>South Africa</option>
  <option value='South Georgia and The South Sandwich Islands'>South Georgia and The South Sandwich Islands</option>
  <option value='Spain'>Spain</option>
  <option value='Sri Lanka'>Sri Lanka</option>
  <option value='Sudan'>Sudan</option>
  <option value='Suriname'>Suriname</option>
  <option value='Svalbard and Jan Mayen'>Svalbard and Jan Mayen</option>
  <option value='Swaziland'>Swaziland</option>
  <option value='Sweden'>Sweden</option>
  <option value='Switzerland'>Switzerland</option>
  <option value='Syria'>Syria</option>
  <option value='Taiwan'>Taiwan</option>
  <option value='Tajikistan'>Tajikistan</option>
  <option value='Tanzania'>Tanzania</option>
  <option value='Thailand'>Thailand</option>
  <option value='Timor-leste'>Timor-leste</option>
  <option value='Togo'>Togo</option>
  <option value='Tokelau'>Tokelau</option>
  <option value='Tonga'>Tonga</option>
  <option value='Trinidad and Tobago'>Trinidad and Tobago</option>
  <option value='Tunisia'>Tunisia</option>
  <option value='Turkey'>Turkey</option>
  <option value='Turkmenistan'>Turkmenistan</option>
  <option value='Turks and Caicos Islands'>Turks and Caicos Islands</option>
  <option value='Tuvalu'>Tuvalu</option>
  <option value='Uganda'>Uganda</option>
  <option value='Ukraine'>Ukraine</option>
  <option value='United Arab Emirates'>United Arab Emirates</option>
  <option value='United Kingdom'>United Kingdom</option>
  <option value='United States'>United States</option>
  <option value='United States Minor Outlying Islands'>United States Minor Outlying Islands</option>
  <option value='Uruguay'>Uruguay</option>
  <option value='Uzbekistan'>Uzbekistan</option>
  <option value='Vanuatu'>Vanuatu</option>
  <option value='Venezuela'>Venezuela</option>
  <option value='Viet Nam'>Viet Nam</option>
  <option value='Virgin Islands, British'>Virgin Islands, British</option>
  <option value='Virgin Islands, U.S.'>Virgin Islands, U.S.</option>
  <option value='Wallis and Futuna'>Wallis and Futuna</option>
  <option value='Western Sahara'>Western Sahara</option>
  <option value='Yemen'>Yemen</option>
  <option value='Zambia'>Zambia</option>
  <option value='Zimbabwe'>Zimbabwe</option>
  ";
}

function show_continent(){
  echo "<option value=''>Select continent</option>
  <option value='Africa'>Africa</option>
  <option value='Antarctica'>Antarctica</option>
  <option value='Asia'>Asia</option>
  <option value='Australia'>Australia</option>
  <option value='Europe'>Europe</option>
  <option value='Asia'>Asia</option>
  <option value='North America'>North America</option>
  <option value='South America'>South America</option>
  ";
}
?>
