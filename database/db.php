<?php 

// todo: name of db
$conn = mysqli_connect('localhost','root','','lms') or die("connection failed:".mysqli_connect_error());

// $sql = "CREATE TABLE IF NOT EXISTS personnel (
//     id INT(6) AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(30) NOT NULL,
//     email VARCHAR(30) NOT NULL UNIQUE,
//     phone VARCHAR(20) NOT NULL,
//     password VARCHAR(100) NOT NULL,
//     type VARCHAR(10) NOT NULL DEFAULT 'cust',
//     expireDate VARCHAR(30) NULL
//     )";

// mysqli_query($conn,$sql) or die("Error creating table: " .mysqli_error($conn));
 

?>