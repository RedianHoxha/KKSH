<?php
session_start();
require_once('../php/extra_function.php');
$user=$_SESSION['user'];
$iduseri = $_SESSION['UserID'];
$link = mysqli_connect("localhost", "root", "", "kksh");

$query = "select * from staf where ID = '$iduseri';";
$kursantet=mysqli_query($link, $query);
$row = mysqli_fetch_array($kursantet);
$degastafit = $row['Degakupunon'];

$querydega = "select * from qyteti where EmriDeges = '$degastafit';";
$dega=mysqli_query($link, $querydega);
$rowdega = mysqli_fetch_array($dega);
$idDeges = $rowdega['IDQyteti'];

$idkursi= test_input(mysqli_real_escape_string( $link,$_GET['id']));

    $emri= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['emri-txt'])));
    $mbiemri= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['mbiemri-txt'])));
    $atesia= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['atesia-txt'])));
    $id= encryptValues(test_input( mysqli_real_escape_string( $link,$_POST['id-txt'])));
    $datelindja= test_input(mysqli_real_escape_string( $link,$_POST['datelindja-txt']));
    $vendbanim= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['vendbanim-txt'])));
    $tel= test_input(mysqli_real_escape_string( $link,$_POST['tel-txt']));

      $querymerrtedhena = "Select * from programijavor where idkursi = '$idkursi';";
      $resulttedhenash = mysqli_query($link, $querymerrtedhena);
      $rowtedhena = mysqli_fetch_array($resulttedhenash);
      $idklase = $rowtedhena['idklase'];
      $data = $rowtedhena['data'];
      $orari = $rowtedhena['orari'];

   $shtokursant = "insert into kursantet(PersonalId,Emri,Mbiemri,Atesia,Datelindja,Vendbanimi,Telefoni,Dega,Datakursit,Orari,Statusi)
    values ( '$id', '$emri', '$mbiemri', '$atesia','$datelindja', '$vendbanim', '$tel' , '$idDeges', '$data','$orari','pabere');";
   
    
    if($resultinsert = mysqli_query($link, $shtokursant))
    {
      $queryshto = "insert into organizimkursantesh1 (idkursi, idkursanti,statusi ) values ('$idkursi','$id','pabere');";
      mysqli_query($link, $queryshto);
      // echo $shtokursant;
      // echo $queryshto;
      // echo $idkursi;
      // echo $orari;
      header('location:../inputer/bejndryshime.php');
    }
    else
    {
      echo "<script>
      alert('Something went wrong! Try again!');
      window.location.href='../inputer/inputerpage.php';
      </script>";
    } 
?>