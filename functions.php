<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;

//FUNCTION TO EXPORT PASSED RECORDS AS EXCEL FROM REGISTRATIONS TABLE
function exportToExcel($records) { 
    
    $now_date = DATE('m-d-Y H:i');
    $file_ending = "xlsx";

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'S No.');
    $sheet->setCellValue('B1', 'Date');
    $sheet->setCellValue('C1', 'Time');
    $sheet->setCellValue('D1', 'Test Location');
    $sheet->setCellValue('E1', 'Name');
    $sheet->setCellValue('F1', 'Passport');
    $sheet->setCellValue('G1', 'NRIC/FIN');
    $sheet->setCellValue('H1', 'Nationality');
    $sheet->setCellValue('I1', 'Contact Number');
    $sheet->setCellValue('J1', 'Email');
    $sheet->setCellValue('K1', 'Service Type');
    $sheet->setCellValue('L1', 'Test Code/Type');
    $sheet->setCellValue('M1', 'Specimen Type');
    $sheet->setCellValue('N1', 'Mode of Payment');
    $sheet->setCellValue('O1', 'Payment Ref');
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
    foreach ($records as $key => $element) {
        $dobDate=date_create($element['dob']);
        $testDate=date_create($element['testDate']);
        $testTime=date_create($element['testTime']);

        
        $sheet->setCellValue('A' . $rowCount, $key+1);
        $sheet->setCellValue('B' . $rowCount, date_format($testDate,"d/m/Y"));
        $sheet->setCellValue('C' . $rowCount, date_format($testTime,"h:i A"));
        $sheet->setCellValue('D' . $rowCount, $element['testLocation']);
        $sheet->setCellValue('E' . $rowCount, $element['patientName']);
        $sheet->setCellValue('F' . $rowCount, $element['passportNumber']);
        $sheet->setCellValue('G' . $rowCount, $element['nric_fin_number']);
        $sheet->setCellValue('H' . $rowCount, $element['nationality']);
        $sheet->setCellValue('I' . $rowCount, $element['contactNumber']);
        $sheet->setCellValue('J' . $rowCount, $element['email']);
        $sheet->setCellValue('K' . $rowCount, $element['serviceType']);
        $sheet->setCellValue('L' . $rowCount, $element['testType']);
        $sheet->setCellValue('M' . $rowCount, $element['specimenType']);
        $sheet->setCellValue('N' . $rowCount, $element['paymentMode']);
        $sheet->setCellValue('O' . $rowCount, $element['paymentRefNo']);
        $sheet->setCellValue('P' . $rowCount, $element['staffCode']);
        $rowCount++;
    }    
        
    
    $writer = new Xlsx($spreadsheet);
    HEADER("Content-Type: application/vnd.ms-excel");
    HEADER("Content-Disposition: attachment; filename=CRS_REG_$now_date.$file_ending");
    $writer->save('php://output');

}

?>