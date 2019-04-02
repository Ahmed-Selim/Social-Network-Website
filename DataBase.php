<?php

$conn = mysqli_connect("localhost", "root", "");
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

$sql = "create database if not exists cs74" ;
if (!mysqli_query($conn,$sql))
    echo "Error creating 'cs74' database: " . mysqli_error($conn) ;

$conn = mysqli_connect("localhost", "root", "" , "cs74");
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

$sql = "create table if not exists profile (
id int primary key auto_increment,
fname varchar (255) not null ,
lname varchar (255) not null ,
uname varchar (255) not null ,
pass blob ,
email varchar (255) unique ,
gender varchar (7) not null ,
birth date not null ,
pic text not null ,
city varchar (255) ,
status varchar (7) ,
about text
)" ;
if (!mysqli_query($conn,$sql))
    echo "Error creating 'profile' table: " . mysqli_error($conn) ;

$sql = "create table if not exists call_me (
id int ,
phone varchar(11) unique ,
foreign key (id) references profile (id) 
)" ;
if (!mysqli_query($conn,$sql))
    echo "Error creating 'call_me' table: " . mysqli_error($conn) ;

$sql = "create table if not exists friendship (
id int ,
friend int ,
primary key (id,friend) ,
foreign key (id) references profile (id) ,
foreign key (friend) references profile (id)
)" ;
if (!mysqli_query($conn,$sql))
    echo "Error creating 'friendship' table: " . mysqli_error($conn) ;

$sql = "create table if not exists request (
id int ,
request int ,
primary key (id,request) ,
foreign key (id) references profile (id) ,
foreign key (request) references profile (id)
)" ;
if (!mysqli_query($conn,$sql))
    echo "Error creating 'request' table: " . mysqli_error($conn) ;

$sql = "create table if not exists post (
id int ,
caption varchar (255) not null ,
image_url text ,
post_time datetime ,
is_public varchar (7) not null ,
foreign key (id) references profile (id)
)" ;
if (!mysqli_query($conn,$sql))
    echo "Error creating 'post' table: " . mysqli_error($conn) ;

?>
