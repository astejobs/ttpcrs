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
   $searchQuery = " and (username like '%".$searchValue."%' or 
        name like '%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from users");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from users WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$userQuery = "select * from users WHERE 1 ".$searchQuery." order by created DESC, ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$userRecords = mysqli_query($conn, $userQuery);
$data = array();

$index=1;
while ($row = mysqli_fetch_assoc($userRecords)) {
   $data[] = array( 
      "id"=>$index,
      "name"=>$row['name'],
      "position"=>$row['position'],
      "site"=>$row['site'],
      "role"=>$row['role']
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