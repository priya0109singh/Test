<?php 
session_start();
require('database.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $title = $_POST['title'];
    $zone = $_POST['zone'];
    $banner_type = $_POST['banner_type'];
    $store = $_POST['store'];

  
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

  
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
 
        $sql = "INSERT INTO banners (title, zone, banner_type, store, image_path, created_at) 
                VALUES ('$title', '$zone', '$banner_type', '$store', '$targetFile', NOW())";
        
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
            header("location:banner.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "File upload failed";
    }

    // Close database connection
    mysqli_close($conn);
}
?>

