<?php
if(isset($_POST["export-to-excel"]))
{
    include_once("connection.php");

    $sql_query = "SELECT * FROM registrations";
    $resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
    $tasks = array();
    while( $rows = mysqli_fetch_assoc($resultset) ) {
        $tasks[] = $rows;
    }
    
    // Submission from
    $filename = "CRS_data_export_".date('Ymd') . ".xls";		 
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    ExportFile($tasks);
    //$_POST["ExportType"] = '';
    exit();
       
}
function ExportFile($records) {
	$heading = false;
		if(!empty($records))
		  foreach($records as $row) {
			if(!$heading) {
			  // display field/column names as a first row
			  echo implode("\t", array_keys($row)) . "\n";
			  $heading = true;
			}
			echo implode("\t", array_values($row)) . "\n";
		  }
		exit;
}

//$sheet->setCellValue('A1', $row['patientName']);
    
    /* for ($i = 0, $l = sizeof($rows); $i < $l; $i++) {
        $sheet->setCellValueByColumnAndRow($i + 1, 1, $rows[$i]);
    } */
    
    /* for ($i = 0, $l = sizeof($tasks); $i < $l; $i++) { // row $i
        $j = 0;
        foreach ($tasks[$i] as $k => $v) { // column $j
            //if($j==0 || $j==19 || $j==20 || $j==21 || $j==22) { continue; }
            $sheet->setCellValueByColumnAndRow($j + 1, ($i + 1 + 1), $v);
            $j++;
        }
    } */
?>