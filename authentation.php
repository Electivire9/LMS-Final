<?php
session_start();
if(!isset($_SESSION['target'])){
    header("Location: ../index.php");
    exit();
}

?>