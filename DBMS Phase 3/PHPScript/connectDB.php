<?php
    $conn = mysqli_connect("localhost", "nkodali", "lovinglife@9", "final");
    
    if (mysqli_connect_errno()){
        echo "<script>alert('Failed to connect to MySQL');</script>";
    }
?>
