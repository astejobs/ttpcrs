<?php
    require_once('header.php');
    require_once('connection.php');
    $activePage = "Blog";
    if(!isset($_SESSION['user'])) {
      header('Location:./login.php');
      exit;
    }
?>

<section id="main-section" class="clearfix">
<div class="container-fluid pt-5">
	

<!-- Body Section -->
<script src="assets/js/ckeditor.js"></script>

<div class="container mt-5">
      <div class="col-sm-12">                    
         
         <h3>Add News</h3>
                  <div class='alert alert-success d-none del-msg'><strong>Record Deleted Successfully!</strong>
                    <button class='close' data-dismiss='alert'>&times;</button>
                  </div>
                                
             <form id="newsForm" action="process-blog.php" class="form-horizontal" role="form" method="post">
                         
                  <div class="row">
                      <div class="col-sm-6">
                            <div class="form-group">
                                 <input type="text" class="form-control" required name="title" value="" placeholder="News Title" />                                        
                            </div>
                            <div class="form-group">
                                  <input type="text" class="form-control" required name="authorName" placeholder="Author Name" />
                            </div>
                            <div class="form-group">
                                  <input type="text" class="form-control" required id="postedDate" name="datePosted" placeholder="Select date" />
                            </div>
                      </div>
                      <div class="col-sm-6">                                                             
                            <div class="row" id="tagContaoner">
                                  <div class="tagItem col-sm-12 d-flex form-group" >
                                        <input type="text" required class="form-control mr-1" name="tagTitle[]" id="title_0" placeholder="Tag Title" />          
                                        <input type="text" required class="form-control" name="tagLink[]" id="link_0" placeholder="Tag Link" />                                    
                                  </div>
                                  <div class="col-sm-12 form-group">
                                         <input type="button" id="add_tag" value="Add Tag" class="btn btn-sm btn-dark float-right" />
                                         <input type="button" id="remove_tag" value="X" class="btn btn-sm btn-danger float-right mr-2" />
                                  </div>
                            </div>  
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">                               
                          <textarea id="editor" name="content" required>                               
                          </textarea>
                        </div>  
                    </div>
                  </div>

                  <div class="form-group ">
                       <input type="submit" id="submit" onSubmit="validate()" class="btn btn-info" value="Submit News">
                  </div>   
            </form>     



       </div> 
       </div>
       <div class="container">
       <h3>Published News</h3>
       <div class="row table-responsive">
           <table class="table table-striped table-bordered table-sm">
                <thead>
                  <tr>
                    <th class="th-sm">#
              
                    </th>
                    <th class="th-sm">Title
              
                    </th>
                    <th class="th-sm">Author
              
                    </th>
                    <th class="th-sm">Date Posted
              
                    </th>
                    <th class="th-sm">Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM blog ORDER BY date_posted desc LIMIT 20";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                        // output data of each row
                            $idx = 1;
                            while($row = $result->fetch_assoc()) { 
                    ?> 
                          <tr>
                            <td><?php echo $idx ?></td>
                            <td><?php echo $row["title"] ?></td>
                            <td><?php echo $row["author_name"] ?></td>
                            <td><?php echo $row["date_posted"] ?></td>
                            <td>
                                    <a style="cursor:pointer" class="copy-link" id="<?php echo $row['id']; ?>" data-toggle="tooltip" title="Copy Link"><i class="fa fa-clipboard" style="color:#1bb1dc"></i></a>
                                    <a href="edit-blog.php?id=<?php echo $row["id"]; ?>" data-toggle="tooltip" title="Edit News"><i class="fa fa-pencil-square" style="color:#1bb1dc"></i></a>
                                    <a style="cursor:pointer" class="remove"  id="<?php echo $row['id']; ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" style="color:#1bb1dc"></i></a>
                            </td>
                          </tr>
                    <?php
                            $idx++;
                            }
                        } else {
                        //echo "0 results";  onClick="copyToClipboard('<?php echo $id >')"
                        }
                        $conn->close();
                    ?>
                </tbody>
              </table>
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
   
   function copyToClipboard(text) { console.log("copying...");
         var input = document.body.appendChild(document.createElement("input"));
        
         input.value = url+"/blog-detail.php/id="+text;
         input.focus();
         input.select();
         document.execCommand('copy');
         input.parentNode.removeChild(input);
    };
   
   let editor;

   ClassicEditor
       .create( document.querySelector( '#editor' ), {
        //toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'News Heading', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'News Title', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'News Sub Title', class: 'ck-heading_heading3' }
            ]
        }
       })
       .then( newEditor => {
           editor = newEditor;
       })
       .catch( error => {
           console.error( error );
       });

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

  $("#submit").on('click', function() {
    var _contents = editor.getData();
    if (_contents == '') {
        alert('Please provide the contents.');
        return false;
    }
    return true;
  });

  $(".copy-link").click(function(e){ 
         var input = document.body.appendChild(document.createElement("input"));
         let id = $(this).attr('id'); console.log(id);
         let url = location.protocol+location.hostname+"/blog-detail.php?id="+id;
         input.value = url;
         input.focus();
         input.select();
         document.execCommand('copy');
         input.parentNode.removeChild(input);
  });
});

</script>

<!-- End Body Section -->

</div>
</section> 
</main><!-- End #main -->
<?php  
require_once('footer.php');

function url(){
    return sprintf(
      "%s://%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME']
    );
  }

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