<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "jonilazejna1";

$conn = new mysqli($host, $user, $pass, $dbname);

if($conn->connect_error){
    die("Diqka shkoi gabim: "  . $conn->connect_error); 
}





?>