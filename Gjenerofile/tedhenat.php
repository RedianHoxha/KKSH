<?php
require_once('../php/extra_function.php');
$link = mysqli_connect("localhost", "root", "", "kksh");
if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}

$degazgjedhur = encryptValues($_GET['dega']);
$startDate = $_GET['start'];
$endDate = $_GET['end'];
$jsonData = array();
$firstday = date('Y-m-d', strtotime("monday -1 week"));
$lastday = date('Y-m-d', strtotime("sunday 0 week"));
$sqlQyteti = "SELECT * FROM qyteti where EmriDeges = '$degazgjedhur'";
$qytetet=mysqli_query($link, $sqlQyteti);
$row = mysqli_fetch_array($qytetet);
$dega = $row['IDQyteti'];
$sqlquery = "SELECT Emri,Atesia,Mbiemri,PersonalId,Datelindja,Amza,NrSerisDeshmis FROM kursantet WHERE Dega= '$dega' AND Statusi = 'perfunduar' AND Datakursit BETWEEN '$startDate' AND '$endDate';";
//$sqlquery = "SELECT Emri,Atesia,Mbiemri,PersonalId,Datelindja,Amza,NrSerisDeshmis FROM kursantet WHERE Dega= '$dega' AND Statusi = 'perfunduar';";
$resultinsert = mysqli_query($link, $sqlquery) or die(mysql_error());

while ($array = mysqli_fetch_row($resultinsert)) {
   $array[0] = decrypt($array[0]);
   $array[1] = decrypt($array[1]);
   $array[2] = decrypt($array[2]);
   $array[3] = decrypt($array[3]);
   $array[5] = decrypt($array[5]);
   $array[6] = decrypt($array[6]);
   $jsonData[] = $array;
}
echo json_encode($jsonData);
?>

