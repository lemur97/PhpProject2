<?php


$server = "localhost"; 
$user = "lucka";
$pass = "ABC1234xyz";
$dbname = "todo_app";

$db = new mysqli($server, $user, $pass, $dbname);

if($db->connect_errno){
    echo $db->connect_error;
}else{
   // echo "OK";
}