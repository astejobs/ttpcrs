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
           <div class="row mt-3">
                <div class="col-sm-10 mt-3">
                    <div class="form-group">                       
                        <input type="search" id="searchQuery" placeholder="Search patient name / passport no. / nric / fin" class="form-control btn-search">
                    </div>                        
                </div>                    
                <div class="col-sm-2 form-group mt-3">
                    <button id="mySearchButton" class="btn btn-success btn-block">Search</button>
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
                            <th class="th-sm">Patient Name</th>
                            <th class="th-sm">D.O.B</th>
                            <th class="th-sm">Gender</th>
                            <th class="th-sm">Passport</th>
                            <th class="th-sm">NRIC_FIN</th>
                            <th class="th-sm">Test Type</th>
                            <th class="th-sm">Test Date</th>
                            <th class="th-sm">Test Time</th>
                            <th class="th-sm">Action</th>
                        </tr>
                    </thead>
                   
            </table>
        </div>                              
        <div class="form-group float-right mt-3">
            <?php if(isset($_SESSION['ID'])) { ?>
                <form action="generate-excel.php" method="POST">
                    <button type="submit" id="export" class="btn btn-dark px-5" name="export-to-excel">Export All</button>
                </form>
            <?php } ?>
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
                { orderable: false, targets: 2 },
                { orderable: false, targets: 7 },
                { orderable: false, targets: 8 },
                { orderable: false, targets: 9 }
                ],
            order: [[1, 'asc']],
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url':'ajaxfile.php'
            },
            'columns': [
                { data: 'id' },
                { data: 'patientName' },
                { data: function (row) { console.log("called");
                    if (row.dob == null) return "";
                    const dob = moment(row.dob).format('DD/MM/YYYY');
                    return (dob=="Invalid date") ? "" : dob;
                } },
                { data: 'gender' },
                { data: 'passportNumber' },
                { data: 'nric_fin_number' },
                { data: 'testType' },
                { data: function (row) {
                    if (row.testDate == null) return "";
                    const td = moment(row.testDate).format('DD/MM/YYYY');
                    return (td=="Invalid date") ? "" : td;
                } },
                { data: function (row) {
                    if (row.testTime == null) return "";
                    const tt = moment(row.testTime, 'hh:mm A');
                    return moment(tt).format('LT');
                } },
                { data: function ( row, type, set ) {
                    <?php if(isset($_SESSION['ID'])) { ?>
                        return `<a href="print-label.php?id=${row.id}" data-toggle="tooltip" title="Print Label"><i class="fa fa-clipboard" style="color:#1bb1dc"></i></a>`+
                            `<a href="edit-registration.php?id=${row.id}" class="mx-1" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square" style="color:#1bb1dc"></i></a>`+
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

            if(confirm('Are you sure to remove this registration ?'))
            {
                $.ajax({
                    url: 'delete_record.php',
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