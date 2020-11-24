<?php

    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $emri= mysqli_real_escape_string( $link,$_POST['emri-txt']);
    $mbiemri= mysqli_real_escape_string( $link,$_POST['mbiemri-txt']);
    $atesia= mysqli_real_escape_string( $link,$_POST['atesia-txt']);
    $id= mysqli_real_escape_string( $link,$_POST['id-txt']);
    $datelindja= mysqli_real_escape_string( $link,$_POST['datelindja-txt']);
    $vendbanim= mysqli_real_escape_string( $link,$_POST['vendbanim-txt']);
    $tel= mysqli_real_escape_string( $link,$_POST['tel-txt']);
    $datakursit= mysqli_real_escape_string( $link,$_POST['datakursit']);
    $idkursi= mysqli_real_escape_string( $link,$_POST['idkursi']);


      $querymerrtedhena = "Select * from programijavor where idkursi = '$idkursi';";
      $resulttedhenash = mysqli_query($link, $querymerrtedhena);
      $rowtedhena = mysqli_fetch_array($resulttedhenash);

      $idklase = $rowtedhena['idklase'];
      $orari = $rowtedhena['orari'];



   $shtokursant = "insert into kursant(ID,Emri,Mbiemri,Atesia,Datelindja,Vendbanimi,Telefoni,Dega,Datakursit,Orari, Statusi)
    values ( '$id', '$emri', '$mbiemri', '$atesia','$datelindja', '$vendbanim', '$tel' , '$dega', '$datakursit','$orari','pabere');";
   
    
    if($resultinsert = mysqli_query($link, $shtokursant))
    {
       $quryshto = "insert into organizimkursantesh (idkursi, idkursanti,statusi ) values ('$idkursi','$id', 'pabere');";
       mysqli_query($link, $quryshto);
       header('location:../PHP/Inputerpage.php');
    }
    else
    {
       echo "Dicka shkoi gabim ne rregjistrimine kursantit!";
    }



?>