<?php
    require_once('header.php');
    require_once('connection.php');
    /* $activePage = "Blog";
    if(!isset($_SESSION['user'])) {
      header('location:login.php');
      exit;
    } */
?>

<section id="main-section " class="clearfix">
<div class="container-fluid pt-5">
	

<!-- Body Section -->
<script src="assets/js/ckeditor.js"></script>

<div class="container mt-5">
      <div class="col-sm-12 pt-4">                    
         
         <p class=" p-2 bg-dark text-white font-weight-bold text-center">ADD USER</p>
                  <div class='alert alert-success d-none del-msg'><strong>User Deleted Successfully!</strong>
                    <button class='close' data-dismiss='alert'>&times;</button>
                  </div>
                                
             <form id="newsForm" action="process-user.php" class="form-horizontal" role="form" method="post">
                
                  <div class="row">
                      <div class="col-sm-12">
                          <?php
                              if(isset($_SESSION['success'])) 
                              { 
                                  echo "<div class='alert alert-success'><strong>".$_SESSION['success']."</strong> !";
                                  echo "<button class='close' data-dismiss='alert'>&times;</button></div>";
                                  unset($_SESSION['success']);
                              }
                              if(isset($_SESSION['error'])) 
                              { 
                               if (count($_SESSION['error']) > 0) : ?>
                                  <div class="text-danger">
                                    <?php foreach ($_SESSION['error'] as $error) : ?>
                                      <p><?php echo $error ?></p>
                                    <?php endforeach ?>
                                  </div>
                                <?php  endif;                             
                                unset($_SESSION['error']);
                              }
                          ?>
                          <span class="text-danger" id="errSpace"></span>
                      </div>
                     
                        <div class="col-md-6 form-group">
                              <label> <b>Name </b> <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" required name="name" value="" placeholder="Name" />                                        
                        </div>

                                                                                  
                        <div class="col-md-6 form-group">
                          <label> <b>Username </b> <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" required name="username" placeholder="Username" />
                        </div> 

                        
                        <div class="col-md-6 form-group">
                          <label> <b>Position </b> <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" required id="position" name="position" placeholder="Position" />
                        </div>

                        
                        <div class="col-md-6 form-group">
                          <label> <b>Site </b> <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" required id="site" name="site" placeholder="Site" />
                        </div>

                        <div class="col-md-6 form-group">
                          <label for="" class="control-label"> <b>User Type </b> <span class="text-danger">*</span></label>
                          <select class="form-control" name="role" required>
                              <!-- <option value="Please Select">Please Select</option> -->
                              <?php if( $_SESSION['ROLE']=='MANAGER' || $_SESSION['ROLE']=='ADMIN') { ?>
                                <option value="USER">USER</option>
                                <option value="SUPERVISOR">EXECUTIVE</option>
                              <?php //} ?>
                              <?php //if( $_SESSION['ROLE']=='ADMIN') { ?>
                                <option value="SUPERVISOR">SUPERVISOR</option>
                                <option value="SUPERVISOR">MANAGER</option>
                              <?php } ?>
                          </select>
                        </div>

                        
                        <div class="col-md-6 form-group">
                          <label> <b>Password </b> <span class="text-danger">*</span></label>
                          <input type="password" class="form-control" required id="password" name="password" placeholder="Password" />
                        </div> 

                        <div class="col-md-6 form-group">
                          <label> <b>Confirm Password </b> <span class="text-danger">*</span></label>
                          <input type="password" class="form-control" required id="confirmPassword" name="confirmPassword" placeholder="confirmPassword" />
                        </div>                 

                        <div class="col-md-6 form-group ">
                            <label>                                
                                <small>
                                    <!-- <em> -->
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        Fields marked with asterisk(*) are required
                                   <!--  </em> -->
                                </small>
                            </label>
                            <br>
                            <input type="submit" id="submit" name="submit" onSubmit="validate()" class="btn btn-info btn-block mb-5" value="Add User">
                        </div> 
                   </div>
            </form>     



       </div> 
       </div>
                    
   </div> 
   
   
<script src="assets/js/flatpickr.js"></script>

<script src="assets/js/blog.js"></script>

<script>
  var config =  {
           enableTime: true,
           dateFormat: "Y-m-d",
           enableTime: false,
           defaultDate : "today"
  };
   $('#postedDate').flatpickr(config);

   // Assuming there is a <button id="submit">Submit</button> in your application.
   /* document.querySelector( '#submit' ).addEventListener( 'click', () => {
       const editorData = editor.getData();

       console.log(editorData); 
   } );*/
$(document).ready(function() {  

  $(".remove").click(function(){ 
      var id = $(this).attr("id");
      console.log("Delete ID: "+id);

      if(confirm('Are you sure to remove this blog ?'))
      {
          $.ajax({
              url: 'delete-blog.php',
              type: 'GET',
              data: {id: id},
              error: function() {
                alert('Something is wrong');
              },
              success: function(data) { console.log(data);
                  $("#"+id).parent().parent().remove();
                  $("html, body").animate({ scrollTop: 0 }, "slow");
                  $(".del-msg").addClass("d-block");
                  //alert("Record removed successfully");  
              }
          });
      }
  });

  /* $("#submit").on('click', function() {
    var pwd = $("#password").val();
    var pwd2 = $("#confirmPassword").val();
    if (pwd != pwd2) {
        alert('Password and confirm does not match!');
        return false;
    }
    return true;
  }); */

});

</script>

<!-- End Body Section -->

</div>
</section> 
</main><!-- End #main -->
<?php  
require_once('footer.php');

/* function url(){
    return sprintf(
      "%s://%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME']
    );
} */

  /* GET FULL URL */
 /*  function url(){
    return sprintf(
      "%s://%s%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME'],
      $_SERVER['REQUEST_URI']
    );
  } */
?>