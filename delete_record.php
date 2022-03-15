<?php
 session_start();
 require_once('connection.php');

    if(isset($_POST['id'])) {
        
        if(isset($_GET['delete'])) {
            $id = mysqli_real_escape_string($conn, $_POST['id']);
        
            if(!empty($id)){
                    
                $sql = "DELETE FROM users WHERE id='".$id."'";
                
                if ($conn->query($sql) === TRUE) {
                    header('Content-Type: application/json');
                    echo json_encode(array('status' => 200,'msg' => "User has been deleted  successfully"));
                    exit;                   
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array('status' => 405, 'msg' => "User not deleted, please try again"));
                    exit;
                }
            }
        }

        $id = mysqli_real_escape_string($conn, $_POST['id']);
        
        if(!empty($id)){
                
            $sql = "DELETE FROM registrations WHERE id='".$id."'";
            
            if ($conn->query($sql) === TRUE) {
                header('Content-Type: application/json');
                echo json_encode(array('status' => 200,'msg' => "Record has been deleted  successfully"));
                exit;                   
            } else {
                header('Content-Type: application/json');
                echo json_encode(array('status' => 405, 'msg' => "Record not deleted, please try again"));
                exit;
            }
        }

    }
    mysql_close();
?>