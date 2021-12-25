<?php

    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }


    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    $emri= test_input(mysqli_real_escape_string( $link,$_POST['name']));
    $mbiemri= test_input(mysqli_real_escape_string( $link,$_POST['surname']));
    $datelindja= test_input(mysqli_real_escape_string( $link,$_POST['bday']));
    $atesia= test_input(mysqli_real_escape_string( $link,$_POST['father']));
    $id=test_input( mysqli_real_escape_string( $link,$_POST['id']));
    $email=test_input(mysqli_real_escape_string( $link,$_POST['email']));
    $tel= test_input(mysqli_real_escape_string( $link,$_POST['phone']));

    $vendbanim= test_input(mysqli_real_escape_string( $link,$_POST['adress']));
    $qyteti=  test_input(mysqli_real_escape_string( $link,$_POST['city']));
    $datakursit=test_input( mysqli_real_escape_string( $link,$_POST['datakursit']));
    $idkursi=test_input( mysqli_real_escape_string( $link,$_POST['select']));

      $querymerrtedhena = "Select * from programijavor where idkursi = '$idkursi';";
      $resulttedhenash = mysqli_query($link, $querymerrtedhena);
      $rowtedhena = mysqli_fetch_array($resulttedhenash);
      $idklase = $rowtedhena['idklase'];
      $orari = $rowtedhena['orari'];


   $shtokursant = "insert into kursant(ID, Emri, Mbiemri, Atesia, Datelindja, Vendbanimi,Telefoni, Dega, Datakursit, Orari, email, Statusi)
    values ( '$id', '$emri', '$mbiemri', '$atesia','$datelindja', '$vendbanim', '$tel' , '$qyteti', '$datakursit','$orari','$email','pabere');";
   
    echo  $shtokursant;
    
    if($resultinsert = mysqli_query($link, $shtokursant))
    {
       $quryshto = "insert into organizimkursantesh (idkursi, idkursanti,statusi ) values ('$idkursi','$id', 'pabere');";
       mysqli_query($link, $quryshto);
       echo "<script>
       alert('Rregjistrimi u be me sukses');
       window.location.href='webpage.html';
       </script>";
    }
    else
    {
      echo "<script>
      alert('Something went wrong! Try again!');
      window.location.href='webpage.html';
      </script>";
    } 
?>