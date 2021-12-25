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

    $emri= test_input(mysqli_real_escape_string( $link,$_POST['emri-txt']));
    $mbiemri= test_input(mysqli_real_escape_string( $link,$_POST['mbiemri-txt']));
    $atesia= test_input(mysqli_real_escape_string( $link,$_POST['atesia-txt']));
    $id= test_input(mysqli_real_escape_string( $link,$_POST['id-txt']));
    $datelindja= test_input(mysqli_real_escape_string( $link,$_POST['datelindja-txt']));
    $vendbanim= test_input(mysqli_real_escape_string( $link,$_POST['vendbanim-txt']));
    $tel = test_input(mysqli_real_escape_string( $link,$_POST['tel-txt']));
    
    $datakursit= test_input(mysqli_real_escape_string( $link,$_POST['datakursit']));
    $idkursi = test_input(mysqli_real_escape_string( $link,$_POST['idkursi']));


     $querymerrtedhena = "Select * from programijavor where idkursi = '$idkursi';";
      $resulttedhenash = mysqli_query($link, $querymerrtedhena);
      $rowtedhena = mysqli_fetch_array($resulttedhenash);
      $idklase = $rowtedhena['idklase'];
      $orari = $rowtedhena['orari'];
    
    $updetorow = "update kursant set Datakursit = '$datakursit', Orari = '$orari', Telefoni = '$tel',Vendbanimi = '$vendbanim',Datelindja = '$datelindja',Atesia = '$atesia',Emri = '$emri', Mbiemri = '$mbiemri' where ID = '$id'";
    if($runupdetin  =mysqli_query($link, $updetorow))
    {
        
        $quryshto = "insert into organizimkursantesh (idkursi, idkursanti,statusi ) values ('$idkursi','$id', 'pabere');";
        mysqli_query($link, $quryshto);
        header('location: ../inputer/bejndryshime.php');
    }
    else
    {
         echo "<script>
        alert('Something went wrong! Try again!');
        window.location.href='../inputer/inputerpage.php';
        </script>";
    }
?>