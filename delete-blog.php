<?php 
    session_start();
    require_once('connection.php');
    //Delete a News Blog 
    if(isset($_GET['id'])){
    
        
        $id = mysqli_real_escape_string($conn, $_GET['id']);
            
        $sql = "DELETE FROM blog WHERE id='".$id."'";
        
        if ($conn->query($sql) === TRUE) {
                $sql2 = "DELETE FROM blog_post_tags WHERE blog_id='".$id."'";
                if ($conn->query($sql2) === TRUE) {
                    echo "Blog has been deleted  successfully";
                } else {
                    echo "Blog tags not deleted!!";
                }
    
        } else {
            echo "Blog not deleted, please try again";
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit;
        }
        
        $conn->close();
        
    } 
?>