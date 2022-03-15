<?php
## Database configuration
include 'connection.php';
## Read value
$draw = $_POST['draw'];
/* if($draw == 2) {
   $draw = 1;
} */
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (patientName like '%".$searchValue."%' or 
        passportNumber like '%".$searchValue."%' or 
        nric_fin_number like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from registrations");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from registrations WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from registrations WHERE 1 ".$searchQuery." order by created DESC, ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

$index=$row+1;
while ($row = mysqli_fetch_assoc($empRecords)) { 
   $data[] = array( 
      "username"=>$index,
      "id"=>$row['id'],
      "patientName"=>$row['patientName'],
      "dob"=>$row['dob'],
      "gender"=>$row['gender'],
      "nric_fin_number"=>$row['nric_fin_number'],
      "passportNumber"=>$row['passportNumber'],
      "testDate"=>$row['testDate'],
      "testTime"=>$row['testTime'],
      "testType"=>$row['testType']
   );
   $index++;
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);

?>