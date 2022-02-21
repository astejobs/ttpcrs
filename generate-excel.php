<?php
include_once("connection.php");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_POST["export-to-excel"]))
{

    $query = "SELECT * FROM registrations";    
    
    // Execute the database query
    $result = mysqli_query($conn, $query) or die(mysql_error());

    $now_date = DATE('m-d-Y H:i');
    $file_ending = "xlsx";
    
    $tasks = array();
    while( $rows = mysqli_fetch_assoc($result) ) {
        $tasks[] = $rows;
    }
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'Patient Name');
    $sheet->setCellValue('B1', 'D.O.B');
    $sheet->setCellValue('C1', 'Gender');
    $sheet->setCellValue('D1', 'Passport Number');
    $sheet->setCellValue('E1', 'Contact No.');
    $sheet->setCellValue('F1', 'Nationality');
    $sheet->setCellValue('G1', 'NRIC/FIN No.');
    $sheet->setCellValue('H1', 'Test Type');
    $sheet->setCellValue('I1', 'Test Date');
    $sheet->setCellValue('J1', 'Test Time');
    $sheet->setCellValue('K1', 'Test Location');
    $sheet->setCellValue('L1', 'Clinic Name');
    $sheet->setCellValue('M1', 'Physician/ MCR');
    $sheet->setCellValue('N1', 'Payment Mode');
    $sheet->setCellValue('O1', 'Payment Ref. No.');
    $sheet->setCellValue('P1', 'Staff Code');

    //Create Styles Array
    $styleArray = array(
        /* 'borders' => array(
            'outline' => array(
                'borderStyle' => Border::BORDER_THICK,
                'color' => array('argb' => 'ffffff'),
            ),
        ), */
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'startColor' => array('argb' => '1bb1dc')
        ),
        'font' => array(
            'bold' => true,
            'color' => array('argb' => 'ffffff'),
            'size' => 12
        )
    );

    //Retrieve Highest Column (e.g AE)
    $highestColumn = $sheet->getHighestColumn();

    //set first row bold
    $sheet->getStyle('A1:' . $highestColumn . '1' )->applyFromArray($styleArray);
    $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(24);    
    foreach (range('A',$highestColumn) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
  
$writer = new Xlsx($spreadsheet);
    $rowCount = 2;
    foreach ($tasks as $element) {
        $sheet->setCellValue('A' . $rowCount, $element['patientName']);
        $sheet->setCellValue('B' . $rowCount, $element['dob']);
        $sheet->setCellValue('C' . $rowCount, $element['gender']);
        $sheet->setCellValue('D' . $rowCount, $element['passportNumber']);
        $sheet->setCellValue('E' . $rowCount, $element['contactNumber']);
        $sheet->setCellValue('F' . $rowCount, $element['nationality']);
        $sheet->setCellValue('G' . $rowCount, $element['nric_fin_number']);
        $sheet->setCellValue('H' . $rowCount, $element['testType']);
        $sheet->setCellValue('I' . $rowCount, $element['testDate']);
        $sheet->setCellValue('J' . $rowCount, $element['testTime']);
        $sheet->setCellValue('K' . $rowCount, $element['testLocation']);
        $sheet->setCellValue('L' . $rowCount, $element['clinicName']);
        $sheet->setCellValue('M' . $rowCount, $element['physician_mcr']);
        $sheet->setCellValue('N' . $rowCount, $element['paymentMode']);
        $sheet->setCellValue('O' . $rowCount, $element['paymentRefNo']);
        $sheet->setCellValue('P' . $rowCount, $element['staffCode']);
        $rowCount++;
    }    
        
    
    $writer = new Xlsx($spreadsheet);
    HEADER("Content-Type: application/vnd.ms-excel");
    HEADER("Content-Disposition: attachment; filename=MDT_DB_$now_date.$file_ending");
    $writer->save('php://output');
}
?>