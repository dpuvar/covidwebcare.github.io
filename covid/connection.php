<?php
$username="root";
$password="";
$server="localhost";
$db="hospital_inquiry";

$conn= mysqli_connect($server,$username,$password,$db);

if($conn){
    //connection succesfull
   // echo "Success connecting to the db";
}
 if(!$conn){
        die("connection to this database failed due to" . mysqli_connect_error());
    }
    // echo "Success connecting to the db";


?>