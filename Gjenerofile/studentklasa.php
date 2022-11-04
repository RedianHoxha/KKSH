<?php
require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');
//$link = mysqli_connect("localhost", "root", "", "kksh");
if ($link === false) {
   die("ERROR: Could not connect. " . mysqli_connect_error());
}

$klasa = encryptValues($_GET['klasa']);

$dataKursit = $_GET['data'];
$orari = $_GET['orari'];

$jsonData = array();
$jsonDataCopy = array();

$queryklasa = "SELECT * FROM klasa WHERE Emri = '$klasa'";
$klasa = mysqli_query($link, $queryklasa);
$rowklasa = mysqli_fetch_array($klasa);
$idklase = $rowklasa['ID'];

$sqlklasa = "SELECT DataRregjistrimit, Emri, Mbiemri, Atesia, Datelindja, Gjinia, Vendbanimi,PersonalId FROM kursantet WHERE Datakursit='$dataKursit' AND Orari = '$orari' AND IdKursi IN (SELECT idkursi FROM programijavor WHERE idklase = '$idklase')";
$resultinsert = mysqli_query($link, $sqlklasa) or die(mysql_error());

$increment = 1;
while ($array = mysqli_fetch_row($resultinsert)) {
   $jsonDataCopy[] = $array;

   $jsonDataCopy[0] = $increment;
   $jsonDataCopy[1] = date('d/m/Y', strtotime($array[0]));
   $jsonDataCopy[2] = "A";
   $jsonDataCopy[3] = decrypt($array[1]);
   $jsonDataCopy[4] = decrypt($array[2]);
   $jsonDataCopy[5] = decrypt($array[3]);
   $jsonDataCopy[6] = date('d/m/Y', strtotime($array[4]));
   $jsonDataCopy[7] = $array[5];
   $jsonDataCopy[8] = decrypt($array[6]);
   $jsonDataCopy[9] = decrypt($array[7]);

   $jsonData[] = $jsonDataCopy;
   $jsonDataCopy = [];

   $increment += 1;
}
echo json_encode($jsonData);
?>