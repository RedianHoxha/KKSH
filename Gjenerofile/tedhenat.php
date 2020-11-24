<?php

$link = mysqli_connect("localhost", "root", "", "kksh");

if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}

$jsonData = array();

$sqlquery = "select * from kursant;";
$resultinsert = mysqli_query($link, $sqlquery) or die(mysql_error());

//$res = json_encode(mysqli_fetch_array($resultinsert));

while ($array = mysqli_fetch_row($resultinsert)) {
   $jsonData[] = $array;
}
echo json_encode($jsonData);


?>

