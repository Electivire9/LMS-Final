<?php
include "../database/db.php";
include "../authentation.php";
session_start();
$target = $_SESSION['target'];
// to do: verify field names 
$type = $target['type'];
if ($type == "cust")
    $userid = $target['id'];
else {
    header("Location:../index.php");
    exit();
}

$recordid=$_REQUEST['id'];
$query = "Update records set returndate='".date('Y-m-d')."' WHERE recordid=$recordid"; 

$result = mysqli_query($conn,$query) or die (mysqli_error($con));
echo "<script>alert('Return Successful.');location.href='loan.php';</script>";

?>