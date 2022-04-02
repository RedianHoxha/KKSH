<?php

session_start();
require_once('../php/extra_function.php');
include('../authenticate/dbconnection.php');
$user=$_SESSION['user'];
$iduseri = $_SESSION['UserID'];
//$link = mysqli_connect("localhost", "root", "", "kksh");

$query = "SELECT * FROM  staf WHERE ID = '$iduseri';";
$kursantet=mysqli_query($link, $query);
$row = mysqli_fetch_array($kursantet);
$degastafit = $row['Degakupunon'];

$querydega = "SELECT * FROM qyteti WHERE EmriDeges = '$degastafit';";
$dega=mysqli_query($link, $querydega);
$rowdega = mysqli_fetch_array($dega);
$idDeges = $rowdega['IDQyteti'];

$now = date('Y-m-d');

    $emri= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['emri-txt'])));
    $mbiemri= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['mbiemri-txt'])));
    $atesia= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['atesia-txt'])));
    $id= encryptValues(test_input( mysqli_real_escape_string( $link,$_POST['id-txt'])));
    $datelindja= test_input(mysqli_real_escape_string( $link,$_POST['datelindja-txt']));
    $vendbanim= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['vendbanim-txt'])));
    $tel= test_input(mysqli_real_escape_string( $link,$_POST['tel-txt']));
    $datakursit= test_input( mysqli_real_escape_string( $link,$_POST['datakursit']));
    $idkursi= test_input( mysqli_real_escape_string( $link,$_POST['select']));
    $gjinia= test_input( mysqli_real_escape_string( $link,$_POST['gjinia']));

      $querymerrtedhena = "SELECT * FROM  programijavor WHERE idkursi = '$idkursi';";
      $resulttedhenash = mysqli_query($link, $querymerrtedhena);
      $rowtedhena = mysqli_fetch_array($resulttedhenash);
      $idklase = $rowtedhena['idklase'];
      $orari = $rowtedhena['orari'];

   $shtokursant = "INSERT INTO kursantet(PersonalId,Emri,Mbiemri,Atesia,Datelindja,Vendbanimi,Telefoni,Dega,Datakursit,Orari,Statusi, IdKursi, DataRregjistrimit, Gjinia)
    VALUES ( '$id', '$emri', '$mbiemri', '$atesia','$datelindja', '$vendbanim', '$tel' , '$idDeges', '$datakursit','$orari','pabere', '$idkursi', '$now', '$gjinia');";
   
    
    if($resultinsert = mysqli_query($link, $shtokursant))
    {
       $queryshto = "INSERT INTO organizimkursantesh1 (idkursi, idkursanti,statusi ) VALUES ('$idkursi','$id','pabere');";
       mysqli_query($link, $queryshto);
       echo $datelindja;
       echo $shtokursant;
       echo $queryshto;
       header('location:../inputer/inputerpage.php');
    }
    else
    {
      echo "<script>
      alert('Something went wrong! Try again!');
      window.location.href='../inputer/inputerpage.php';
      </script>";
    } 
?>