<?php
session_start() ;
$caption = $_POST["caption"] ;
$img = "../image/".$_POST["img"] ;
$type = $_POST["type"] ;

$conn = mysqli_connect("localhost", "root", "" , "cs74");
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

$sql = 'insert into post values ('.$_SESSION["id"].',"'.$caption.'","'.$img.'",NOW(),"'.$type.'")';
if(!mysqli_query($conn,$sql))
    die ("Error inserting new post: ".mysqli_connect_error()) ;
header("Location: Home.php");
?>