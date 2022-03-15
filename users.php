<?php
  
    require_once('header.php');
    //$activePage = "Blog";  

?>

<link href='assets/js/DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
 
<section id="main-section" class="clearfix">
	<div class="container-fluid pt-5">
	

<!-- Body Section -->
<main id="main">
  
  <div class="row">
   <div class="col-sm-12">
       <div class="container-fluid mt-5"> 
       <p class=" p-2 font-weight-bold text-center">MANAGE ACCOUNTS</p>
           <div class="row mt-3">
                <div class="col-sm-8 mt-3">
                    <div class="form-group">                       
                        <input type="search" id="searchQuery" placeholder="Search Name / username" class="form-control btn-search">
                    </div>                        
                </div>                    
                <div class="col-sm-2 form-group mt-3">
                    <button id="mySearchButton" class="btn btn-success btn-block">Search</button>
                </div>
                <div class="col-sm-2 form-group mt-3">
                    <a href="create-user.php" class="btn btn-info btn-block"><i class="fa fa-user-plus pr-2"></i>Add Account</a>
                </div>
           </div>
       </div>
       <?php
        if(isset($_SESSION['msg'])) 
        { 
            echo "<div class='alert alert-success'><strong>".$_SESSION['msg']."</strong> !";
            echo "<button class='close' data-dismiss='alert'>&times;</button></div>";
            unset($_SESSION['msg']);
        }
        ?> 
        <div class='alert d-none del-msg'><strong><span><span></strong>
            <button class='close' data-dismiss='alert'>&times;</button>
        </div>
   </div>
  </div>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th class="th-sm">#</th>
                            <th class="th-sm">Name</th>
                            <th class="th-sm">Position</th>
                            <th class="th-sm">Site</th>
                            <th class="th-sm">Role</th>
                            <th class="th-sm">Action</th>
                        </tr>
                    </thead>
                   
            </table>
        </div>     
    </div>
   </main>
   
   <!-- End #main -->
<!-- End Body Section -->


</div>
</section> 


</main><!-- End #main -->

<?php
require_once('footer.php');
?>
<script src="assets/js/DataTables/datatables.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script>
    $(document).ready(function() {
        
        var table = $('#myTable').DataTable({
            "lengthMenu": [ 5, 10 ],
            responsive: true,
            searchPlaceholder: "Search records",
            search: "",
            columnDefs: [
                { orderable: false, targets: 5 }
                ],
            //order: [[0, 'desc']],
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url':'ajaxfile-users.php'
            },
            'columns': [
                { data: 'username' },
                { data: 'name' },
                { data: 'position' },
                { data: 'site' },
                { data: 'role' },
                { data: function ( row, type, set ) {
                    <?php if(isset($_SESSION['ID'])) { ?>
                        return `<a href="edit-user.php?id=${row.id}" class="mx-1" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square" style="color:#1bb1dc"></i></a>`+
                            `<a style="cursor:pointer" class="remove"  id="${row.id}" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" style="color:#1bb1dc"></i></a>`;
                    <?php } else {?>
                        return "";
                    <?php } ?>
                    
                } },
            ]
        });
        //$('#myTable_filter').remove();
        $('#myTable_filter').css("display","none");
       

        $('#mySearchButton').on( 'keyup, click', function () {
            table.search($('#searchQuery').val()).draw();
        });

        $(document).on("click", ".remove", function() {
            var id = $(this).attr("id");
            var parent = $(this).parent().parent();
            console.log("Delete ID: "+id);

            if(confirm('Are you sure to remove this user ?'))
            {
                $.ajax({
                    url: 'delete_record.php?delete=user',
                    type: 'POST',
                    data: {id: id},
                    error: function() {
                        alert('Something is wrong');
                    },
                    success: function(data) { 
                        console.log(data);
                        console.log(data.msg);
                        console.log(data.status);
                        if(data.status==200) {
                            parent.fadeOut('slow', function() {$(this).remove(); });
                            $(".del-msg").addClass("d-block"); 
                            $(".del-msg").addClass("alert-success"); 
                            $(".del-msg").find("span").text(data.msg); 
                        } else {
                            $(".del-msg").addClass("d-block"); 
                            $(".del-msg").addClass("alert-danger"); 
                            $(".del-msg").find("span").text(data.msg); 
                        }
                    }
                });
            }
            
        });
    });

</script>