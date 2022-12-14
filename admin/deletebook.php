<?php
include "../database/db.php";
include "../authentation.php";

$target = $_SESSION['target'];
$type = $target['type'];
if($type !== "admin"){
    header("Location:../index.php");
    exit();
}

$bookid=$_REQUEST['bookid'];

$select = $conn -> query("Select isbn,booktitle,author FROM books WHERE bookid='$bookid'");

if($select){
    $row = mysqli_fetch_assoc($select);
    $isbn = $row['isbn'];
    $booktitle = $row['booktitle'];
    $author = $row['author'];
}

$delete = $conn -> query("DELETE FROM books WHERE bookid='$bookid'");

$status = '';
if ($delete) {
    $record = "DELETE | Book ID: " . $bookid . ", ISBN: " . $isbn . ", Book Title: " . $booktitle . ", Author: " . $author . ", Delete time: " . date("Y-m-d H:i:s", time() - 6 * 60 * 60) . "\n";
    file_put_contents("Record.txt", $record, FILE_APPEND) > 0;
}

header("Location: managebook.php?"); 
