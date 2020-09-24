let darkMode = localStorage.getItem("darkMode");

function redeem(){
    alert('Coupon code reedemed');
  }

function validateForm() {
  var x = document.forms["registerForm"]["password_1"].value;
  var y = document.forms["registerForm"]["password_2"].value;
  if (x.length < 8) {
    var element = document.getElementById("passerror");
    element.innerHTML = "Password must contain at least 8 Characters";
    return false;
  }
  if (x != y) {
    var element = document.getElementById("passmatch");
    element.innerHTML = "Passwords do not match";
    return false;
  }
}

const enableDarkMode = () => {
  $('.modal-content,input,select,textarea').not('.custom-select-sm,.btn-rounded,.picker__select--month,.picker__select--year,.form-control-sm').toggleClass('dark-card-admin');
  $('.dropdown-menu').toggleClass('dark-card-admin');
  $('.dropdown-item').toggleClass('white-text');
  $('.form-group').toggleClass('white-text');
  $('hr').toggleClass('white');
  $('.navbar-brand').toggleClass('white-text');
  $('nav').toggleClass('navbar-dark');
  $('.card,.list-group-item').toggleClass('dark-card-admin');
  $('body').toggleClass('black');
  $(this).toggleClass('white text-dark btn-outline-black');
  $('body').toggleClass('dark-bg-admin');
  $('button,.btn,.fab').not('.picker__button--clear,.picker__button--today,.picker__button--close,.picker__nav--next,.picker__nav--prev').toggleClass('white-text');
  $('h6, .card, p, td, th, i, li a,a, h4,h3,h2,h1,h5,.fas,input,select,textarea,strong').not(
    '#slide-out i, #slide-out a, .dropdown-item i, .dropdown-item, .fa, .fa-star, .page-link,.fab,.picker__select--month,.picker__select--year,.picker__weekday,.custom-select-sm,.form-control-sm,.btn,.red-text').toggleClass('white-text');
  $('.btn-dash').toggleClass('grey blue').toggleClass('lighten-3 darken-3');
  $('.gradient-card-header').toggleClass('white black lighten-4');
  $('.list-panel a').toggleClass('navy-blue-bg-a text-white').toggleClass('list-group-border');
};

    $('.datepicker').pickadate({
        // Escape any “rule” characters with an exclamation mark (!).
        format: 'dd-mm-yyyy',
        formatSubmit: 'yyyy-mm-dd',
    });

   $('.expdate').pickadate({
    // Escape any “rule” characters with an exclamation mark (!).
        format: 'dd-mm-yyyy',
        formatSubmit: 'yyyy-mm-dd',
        min: true
    });

    $(document).ready(function() {
      $('.mdb-select').materialSelect();
      });
      
      function dark(e){
        darkMode = localStorage.getItem("darkMode");
        if ((window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches || (darkMode != "disabled"))) {
          if(darkMode != "disabled"){
            enableDarkMode();
          }
          }
        }

        window.print=dark();

          
          window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) { 
            darkMode = localStorage.getItem("darkMode");
            if ((window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) && darkMode != "disabled"){
              localStorage.setItem("darkMode", "enabled");
            }else if((window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) && darkMode != "enabled"){
              localStorage.setItem("darkMode", "disabled");
            }else{
              darkMode = localStorage.getItem("darkMode");
              if(darkMode != "enabled"){
                localStorage.setItem("darkMode", "enabled");
              }else{
                localStorage.setItem("darkMode", "disabled");
              }
              e.preventDefault();
              enableDarkMode();
            }

          });
          
      
        $(function () {
          $('#dark-mode').on('click', function (e) {
            darkMode = localStorage.getItem("darkMode");
            if(darkMode != "enabled"){
              localStorage.setItem("darkMode", "enabled");
            }else{
              localStorage.setItem("darkMode", "disabled");
            }
            e.preventDefault();
            enableDarkMode();
          });
        });    
        
 
 var states = ["Afghanistan","Albania","Algeria","Andorra","Angola",
 "Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria",
 "Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize",
 "Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil",
 "British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia",
 "Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic",
 "Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica",
 "Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic",
 "Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt",
 "El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia",
 "Falkland Islands","Faroe Islands","Fiji","Finland","France",
 "French Polynesia","French West Indies","Gabon","Gambia","Georgia",
 "Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam",
 "Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong",
 "Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel",
 "Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait",
 "Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania",
 "Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta",
 "Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro",
 "Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles",
 "New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine",
 "Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania",
 "Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal",
 "Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea",
 "South Sudan","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden",
 "Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia",
 "Turkey","Turkmenistan","Turks &amp; Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom",
 "United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen",
 "Zambia","Zimbabwe"];
 states.sort();

$('.country').mdbAutocomplete({
data: states
});

var conti = ["North America","South America","Asia","Europe","Australia","Africa"];

conti.sort();

$('.continent').mdbAutocomplete({
data: conti
});




                  // Get the elements
   var from_input = $('.sdate').pickadate(),
   from_picker = from_input.pickadate('picker')
 var to_input = $('.edate').pickadate(),
   to_picker = to_input.pickadate('picker')
       from_picker.set('min', true)
       to_picker.set('min', true)

 // Check if there’s a “from” or “to” date to start with and if so, set their appropriate properties.
 if (from_picker.get('value')) {
   to_picker.set('min', from_picker.get('select'))
 }
 if (to_picker.get('value')) {
   from_picker.set('max', to_picker.get('select'))
 }

 // Apply event listeners in case of setting new “from” / “to” limits to have them update on the other end. If ‘clear’ button is pressed, reset the value.
 from_picker.on('set', function (event) {
   if (event.select) {
     to_picker.set('min', from_picker.get('select'))
   } else if ('clear' in event) {
     to_picker.set('min', true)
     to_picker1.set('max', false)
   }
 });
 to_picker.on('set', function (event) {
   if (event.select) {
     from_picker.set('max', to_picker.get('select'))
   } else if ('clear' in event) {
           from_picker.set('min', true)
     from_picker.set('max', false)
   }
});


                     // Get the elements
                     var from_input1 = $('.cidate').pickadate(),
                     from_picker1 = from_input1.pickadate('picker')
                     var to_input1 = $('.codate').pickadate(),
                     to_picker1 = to_input1.pickadate('picker')
                     from_picker1.set('min', true)
                     to_picker1.set('min', true)
                     
                     // Check if there’s a “from” or “to” date to start with and if so, set their appropriate properties.
                     if (from_picker1.get('value')) {
                     to_picker1.set('min', from_picker1.get('select'))
                     }
                     if (to_picker1.get('value')) {
                     from_picker1.set('max', to_picker1.get('select'))
                     }
                     
                     // Apply event listeners in case of setting new “from” / “to” limits to have them update on the other end. If ‘clear’ button is pressed, reset the value.
                     from_picker1.on('set', function (event) {
                     if (event.select) {
                       to_picker1.set('min', from_picker1.get('select'));
                     } else if ('clear' in event) {
                       to_picker1.set('min', true)
                       to_picker1.set('max', false)
                     }
                     })
                     to_picker1.on('set', function (event) {
                     if (event.select) {
                       from_picker1.set('max', to_picker1.get('select'))
                     } else if ('clear' in event) {
                       from_picker1.set('min', true)
                       from_picker1.set('max', false)
                     }
                     })