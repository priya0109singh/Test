<?php

require("database.php");


$sql = "SELECT * FROM `banners`";
$result = mysqli_query($conn, $sql);
$data = array();


if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row; 
    }
}


mysqli_close($conn);


header('Content-Type: application/json');
echo json_encode($data);
?>
