<?php
include_once("connection.php");
require 'functions.php';

    if(isset($_POST["export-to-excel"]))
    {

        $query = "SELECT * FROM registrations";    
        
        // Execute the database query
        $result = mysqli_query($conn, $query) or die("Error Contact Dev Team!");
        
        $records = array();
        while( $rows = mysqli_fetch_assoc($result) ) {
            $records[] = $rows;
        }
        
        exportToExcel($records);
    }
    if(isset($_POST["export"]))
    {
        $site = "";
        if(isset($_POST['testLocation'])) {
            $site = $_POST['testLocation'];
        }
        if($site == "Please Select") {
            $site = ""; 
        }

        $from_date  = date('Y-m-d');
        if(isset($_POST['fromDate']) && !empty($_POST['fromDate'])) {            
            $from_date  = $_POST['fromDate'];
        }
        $to_date  = date('Y-m-d');
        if(isset($_POST['toDate']) && !empty($_POST['toDate'])) {
            $to_date  = $_POST['toDate'];
        }

        $q = "SELECT * FROM `registrations` WHERE `id`>'0' ";
        if($site && !empty($site)){
            $q .= " AND `testLocation` LIKE '%".$site."%' AND testDate BETWEEN '" . $from_date . "' AND  '" . $to_date . "' ";
        } else {
            $q .= " AND `testDate` BETWEEN '" . $from_date . "' AND  '" . $to_date . "' ";
        }
       
        // Execute the database query
        $result = mysqli_query($conn, $q) or die("Error");
            
        $records = array();
        while( $rows = mysqli_fetch_assoc($result) ) {
            $records[] = $rows;
        }
        
        exportToExcel($records);
    }

?>