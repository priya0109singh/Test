<?php
require("database.php");

if(isset($_GET['deleteid'])){
    $id = $_GET['deleteid'];

    $sql="delete from `banners` where id= $id";
    $result =mysqli_query($conn,$sql);
    if($result){
    //  echo "Deleted Successfull";
    header('location:banner.php');    
}else{
        die(mysqli_error($conn));
    }
}
 





?>