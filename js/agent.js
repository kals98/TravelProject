

    $(document).ready(function() {
    
        $('.datatable').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search Your Data",
            }
        });
    
    });
    

    
    $(document).ready(function () {
    
        $('.deletebtn').on('click', function() {
            
            $('#deletemodal').modal('show');
    
                $tr = $(this).closest('tr');
    
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();
    
                console.log(data);
    
                $('#delete_id_tour').val(data[0].trim());
          
        });
    });
    

    
    $(document).ready(function () {
        $('.editbtn').on('click', function() {
            
            $('#editmodal').modal('show');
    
            
                $tr = $(this).closest('tr');
    
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();
    
                console.log(data);
    
                $('#update_id_tour').val(data[0].trim());
                $('#name').val(data[1].trim());
                $('#country').val(data[2].trim());
                $('#continent').val(data[3].trim());
                $('#price').val(data[4].trim());
        });
    });
    



  
  $(document).ready(function () {
  
      $('.deletebtn1').on('click', function() {
          
          $('#delete_book_modal').modal('show');
  
              $tr = $(this).closest('tr');
  
              var data = $tr.children("td").map(function() {
                  return $(this).text();
              }).get();
  
              console.log(data);
  
              $('#delete_id').val(data[0].trim());
        
      });
  });

  
  

  
  $(document).ready(function () {
      $('.editbtn1').on('click', function() {
          
          $('#edit_book_modal').modal('show');
  
          
              $tr = $(this).closest('tr');
  
              var data = $tr.children("td").map(function() {
                  return $(this).text();
              }).get();
  
              console.log(data);
              $('#update_id').val(data[0].trim());
              $('#sdate').val(data[2]);
              $('#edate').val(data[3].trim());
              $('#nop').val(data[4].trim());
              $('#cost').val(data[5].trim());
              $('#user_id').val(data[6].trim());
              $('#tour_id').val(data[7].trim());
      });
  });

  $(document).ready(function () {
    
    $('.deletebtn2').on('click', function() {
        
        $('#delete_user_modal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#delete_id_tour').val(data[0].trim());
      
    });
});



$(document).ready(function () {
    $('.editbtn2').on('click', function() {
        
        $('#edit_user_modal').modal('show');

        
            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#uid').val(data[0].trim());
            $('#uname').val(data[1].trim());
            $('#uusername').val(data[2].trim());
            $('#uemail').val(data[3].trim());
            $('#uuser_type').val(data[4].trim());
            $('#uphno').val(data[5].trim());
            $('#udob').val(data[6].trim());
    });
});
  
      
  $(document).ready(function () {
    
    $('.cancbtn').on('click', function() {
        
        $('#cancelmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

           
            $('#book_id1').val(data[0].trim());
            $('#tour_id1').val(data[7].trim());
      
    });
});



$(document).ready(function () {
    $('.revbtn').on('click', function() {
        
        $('#reviewmodal').modal('show');

        
            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            
            $('#book_id2').val(data[0].trim());
            $('#tour_id2').val(data[7].trim());
    });
});
