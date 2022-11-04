<?php


require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');

$getusers = "SELECT * FROM kursantet WHERE Statusi ='perfunduar' and Amza = '' AND NrSerisDeshmis = ''";

$kursantet = mysqli_query($link, $getusers);
while ($row = mysqli_fetch_array($kursantet)) {

    $idkursnti = $row['ID'];
    $idpersonaleKursanti = $row['PersonalId'];
    $fshikursantngaplanifikimi = "UPDATE organizimkursantesh1  SET statusi = 'Munges' WHERE idkursanti = '$idpersonaleKursanti'";
    echo $fshikursantngaplanifikimi;
    $sqlupdate = "UPDATE kursantet SET Statusi = 'Munges' , Orari = '', Datakursit = '0000-00-00' , IdKursi = '0' WHERE ID = $idkursnti";
    $result = mysqli_query($link, $sqlupdate) or die(mysqli_error($link));

    if ($result) {
        $runupdetinorganizim = mysqli_query($link, $fshikursantngaplanifikimi) or die(mysqli_error($link));
        if ($runupdetinorganizim) {
            echo "Modiko sukse";
        } else {
            echo "Modifiko error";
        }
    } else {
        echo "Error";
    }
}


?>