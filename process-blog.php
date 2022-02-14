<?php 
session_start();
require_once('connection.php');
//Update Existing News Blog 
if(isset($_GET['edit'])){

  if(isset($_POST['id'])){ 
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $author_name = mysqli_real_escape_string($conn, $_POST['authorName']);
    $date_posted = mysqli_real_escape_string($conn, $_POST['datePosted']);
  
    $tagTitles = $_POST['tagTitle'];
    $tagLinks = $_POST['tagLink'];
    
      $sql = "UPDATE blog SET author_name='".$author_name."', date_posted='".$date_posted."', title='".$title."', content='".$content."' WHERE id='".$id."'";
      
      if ($conn->query($sql) === TRUE) {            
            echo "Blog Added Successfully";
            $_SESSION['msg']="News blog has been updated  successfully"; 
            header('Location:./blog-home.php');
            //wp_redirect("blog-home.php"); 
            exit;
      } else {
        $_SESSION['msg']="Error: News blog was not updated, please try again"; 
        header('Location:./blog-home.php');
        //wp_redirect("blog-home.php");
        exit;
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
       
      $conn->close();
   
     
  }
  
} else {  //Add New Blog 

  if(isset($_POST['title'])){
  
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $author_name = mysqli_real_escape_string($conn, $_POST['authorName']);
    $date_posted = mysqli_real_escape_string($conn, $_POST['datePosted']);
  
    $tagTitles = $_POST['tagTitle'];
    $tagLinks = $_POST['tagLink'];
      
      $sql = "INSERT INTO blog (author_name,date_posted,title,content) VALUES ('$author_name','$date_posted','$title','$content')";
      
      if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
         if($last_id != '') { echo "Row Id ".$last_id;
            foreach($tagTitles as $key => $title)
              {
                if($title != '' && $tagLinks[$key] != '')
                {
                  $title_tag = mysqli_real_escape_string($conn, $title);
                  $link_tag = mysqli_real_escape_string($conn, $tagLinks[$key]);
                 
                  $sqlTags = "INSERT INTO blog_post_tags (blog_id,link,title) VALUES ('$last_id','$link_tag','$title_tag')";
                  if ($conn->query($sqlTags) === TRUE) { 
                    echo "Tag added";
                  } else {
                    $_SESSION['msg']="Error: News blog Tags were not added, Please try again"; 
                    echo "Error in Tags: " . $sql . "<br>" . $conn->error;
                    header('Location:./blog-home.php');
                    //wp_redirect("blog-home.php");
                    exit;
                  }
                } 
             }
            echo "Blog Added Successfully";
            $_SESSION['msg']="News blog was added  successfully";
            header('Location:./blog-home.php');
            //wp_redirect("blog-home.php");
            exit;
          }      
  
       } else {
        $_SESSION['msg']="Error: News blog was not added, please try again";
        echo "Error: " . $sql . "<br>" . $conn->error;
        header('Location:./blog-home.php');
        //wp_redirect("blog-home.php");
        exit;
      }
       
      $conn->close();
     
    }
}

    function insertTags($conn, $blog_id, $tagTitles, $tagLinks) {
      foreach($tagTitles as $key => $title)
      {
          if($title != '' && $tagLinks[$key] != '')
          {
            $insData = array("blog_id"=>$blog_id, "link"=>mysqli_real_escape_string($conn, $tagLinks[$key]), "title"=>mysqli_real_escape_string($conn, $title));
            $columns = implode(", ",array_keys($insData));
            $values  = implode(", ", $insData);
            /* echo "cols \n";
            print_r($columns);
            echo "values \n";
            print_r($values); */

            $sqlTags = "INSERT INTO `blog_post_tags` ($columns) VALUES ($values)";
            if ($conn->query($sqlTags) === TRUE) {              
              return true;
              
            } else {
              return false;
            }
          } 
      }
    }
?>