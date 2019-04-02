<?php
session_start();
$conn = mysqli_connect("localhost", "root", "" , "cs74");
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

$id = $_POST["id"] ;

if ($_POST["hide"] == "addrequest"){
    $sql = 'insert into request values ('.$_SESSION["id"].','.$id.')' ;
    echo $sql .'<br>';
    if (!mysqli_query($conn,$sql))
        die("Error adding friend request: " . mysqli_connect_error());
    header("Location: Search.php") ;
}
else {
    $sql = 'delete from request where id = ' . $id . ' and request = '.$_SESSION["id"] ;
    if ($_POST["hide"] == "accept") {
        $sql .= ' ; insert into friendship values ('.$_SESSION["id"].','.$id.'),('.$id.','.$_SESSION["id"].');' ;
    }
    if(!mysqli_multi_query($conn, $sql))
        die("Error removing friend request: " . mysqli_connect_error());
    header("Location: FriReq.php");

}

?>