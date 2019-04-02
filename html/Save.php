<?php
session_start();
$conn = mysqli_connect("localhost", "root", "" , "cs74");
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

$sql = 'update profile set id = ' .$_SESSION["id"] ;

if ($_POST["about"] != ""){
     $sql .= ' , about = "' . $_POST["about"] . '"';
}

if ($_POST["birth"] != ""){
     $sql .= ' , birth = "' . $_POST["birth"] . '"';
}

if ($_POST["city"] != ""){
     $sql .= ' , city = "' . $_POST["city"] . '"';
}

if ($_POST["email"] != ""){
     $sql .= ' , email = "' . $_POST["email"] . '"';
}

if ($_POST["gender"] != ""){
     $sql .= ' , gender = "' . $_POST["gender"] . '"';
}

if ($_POST["lname"] != ""){
     $sql .= ' , lname = "' . $_POST["lname"] . '"';
}

if ($_POST["pass"] != ""){
     $sql .= ' , pass = AES_ENCRYPT("' . $_POST["pass"] . '","Ahmed")';
}

if ($_POST["rmpic"] == "T" ){
    $_POST["pic"] = $_POST["gender"] ;
}

if ($_POST["pic"] != ""){
     $sql .= ' , pic = "../image/' . $_POST["pic"] . '"';
    $query = 'insert into post values ('.$_SESSION["id"].',"User has changed his/her profile picture","../image/'.$_POST["pic"].'",NOW(),"private")';
    if(!mysqli_query($conn,$query))
        die ("Error inserting new post: ".mysqli_connect_error()) ;
}

if ($_POST["status"] != ""){
     $sql .= ' , status = "' . $_POST["status"] . '"';
}

if ($_POST["uname"] != ""){
     $sql .= ' , uname = "' . $_POST["uname"] . '"';
}

if ($_POST["fname"] != ""){
     $sql .= ' , fname = "' . $_POST["fname"] . '"';
}

$sql .= ' where id = ' . $_SESSION["id"] ;

if(!mysqli_query($conn,$sql))
    die("Error Updating profile: " . mysqli_connect_error());

if ($_POST["loop"] > 0) {
    $sql = 'delete from call_me where phone in (' ;
    $first = false ;
    for ($i = 1 ; $i <= $_POST["loop"] ; ++$i) {
        if (array_key_exists($i,$_POST)){
            if ($first)
                $sql .= ' , ' ;
            $sql .= '"' . $_POST[$i] .'"' ;
            $first = true ;
        }
    }
    $sql .= ')' ;

    if(!mysqli_query($conn,$sql))
        die("Error Deleting phones: " . mysqli_connect_error());
}

if ($_POST["phono"] != ""){
    $sql = 'insert into call_me values ('.$_SESSION["id"].',"' .$_POST["phono"]. '")' ;
    if(!mysqli_query($conn,$sql))
        die("Error inserting phone: " . mysqli_connect_error());
}

header("Location: Account.php");

?>