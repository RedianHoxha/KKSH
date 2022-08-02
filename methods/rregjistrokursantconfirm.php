<?php

session_start();
require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');
$user=$_SESSION['user'];
$iduseri = $_SESSION['UserID'];

$query = "SELECT * FROM  staf WHERE ID = '$iduseri';";
$kursantet=mysqli_query($link, $query);
$row = mysqli_fetch_array($kursantet);
$degastafit = $row['Degakupunon'];

$querydega = "SELECT * FROM qyteti WHERE EmriDeges = '$degastafit';";
$dega=mysqli_query($link, $querydega);
$rowdega = mysqli_fetch_array($dega);
$idDeges = $rowdega['IDQyteti'];

$now = date('Y-m-d');

    $emri= encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['emri-txt']))));
    $mbiemri= encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['mbiemri-txt']))));
    $atesia= encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['atesia-txt']))));
    $id= encryptValues(strtoupper(test_input( mysqli_real_escape_string( $link,$_POST['id-txt']))));
    $datelindja= test_input(mysqli_real_escape_string( $link,$_POST['datelindja-txt']));
    $vendbanim= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['vendbanim-txt'])));
    $tel= test_input(mysqli_real_escape_string( $link,$_POST['tel-txt']));
    $amza= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['amza-txt'])));
    $seria= encryptValues(test_input( mysqli_real_escape_string( $link,$_POST['deshmi-txt'])));

    $paymentNumber = '11';
    $email = 'testemail@gmail.com';


      $checkifexist="SELECT * FROM kursantet WHERE PersonalId = '$id' and Statusi = 'pabere'";
      $resultifexist = mysqli_query($link, $checkifexist);
      $userexist = mysqli_num_rows($resultifexist);
      if($userexist){
         echo '<script>
           alert("Ky person eshte rregjistruar ne nje kurs tjeter ne ditet ne vijim!\n Modifiko planifikimin ekzistues");
           window.location.href="../inputer/bejndryshime.php";
           </script>';
      }else{
         $shtokursant = "INSERT INTO kursantet(PersonalId,Emri,Mbiemri,Atesia,Datelindja,Vendbanimi,Telefoni,Dega,Statusi,  DataRregjistrimit, Gjinia, BankPayment, BankName ,Amza, NrSerisDeshmis, Email)
         VALUES ( '$id', '$emri', '$mbiemri', '$atesia','$datelindja', '$vendbanim', '$tel' , '$idDeges','perfunduar',  '$now', '$gjinia',$paymentNumber,'Sporteliiiiiiiii','$amza','$seria', '$email');";
         $resultinsert = mysqli_query($link, $shtokursant) or die(mysqli_error($link));
         if($resultinsert)
         {
            header('location:../confirm/confirmpage.php');
         }
         else
         {
           echo '<script>
           alert("Something went wrong! Try again!");
           window.location.href="../confirm/confirmpage.php";
           </script>';
         } 
      }
?>