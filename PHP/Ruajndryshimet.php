<?php
    //$link = mysqli_connect("localhost", "root", "", "kksh");
    require_once('../php/extra_function.php');
    include('../Authenticate/dbconnection.php');
    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }
      $idkursanti = $_GET['id'];

    $emri= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['emri-txt'])));
    $mbiemri= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['mbiemri-txt'])));
    $atesia= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['atesia-txt'])));
    $id= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['id-txt'])));
    $datelindja= test_input(mysqli_real_escape_string( $link,$_POST['datelindja-txt']));
    $vendbanim= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['vendbanim-txt'])));
    $tel = test_input(mysqli_real_escape_string( $link,$_POST['tel-txt']));
    
    $datakursit= test_input(mysqli_real_escape_string( $link,$_POST['datakursit']));
    $idkursi= test_input( mysqli_real_escape_string( $link,$_POST['select']));


    $querymerrtedhena = "Select * from programijavor where idkursi = '$idkursi';";
    $resulttedhenash = mysqli_query($link, $querymerrtedhena);
    $rowtedhena = mysqli_fetch_array($resulttedhenash);
    $idklase = $rowtedhena['idklase'];
    $orari = $rowtedhena['orari'];
    
    $updetorow = "update kursantet set PersonalId = '$id',  Datakursit = '$datakursit', Orari = '$orari', Telefoni = '$tel',Vendbanimi = '$vendbanim',Datelindja = '$datelindja',Atesia = '$atesia',Emri = '$emri', Mbiemri = '$mbiemri' where ID = '$idkursanti'";
    if($runupdetin  =mysqli_query($link, $updetorow))
    {
        $selectexistorganizim = "SELECT * FROM `organizimkursantesh1` WHERE idkursanti='$id' AND statusi = 'pabere'";
        $resulttedhenashexistorganizim = mysqli_query($link, $selectexistorganizim);
        $rowtedhenaexistonperson = mysqli_fetch_array($resulttedhenashexistorganizim);
        $idkursiexistuees =  $rowtedhenaexistonperson['idkursi'];

        $querydeleteexistorganizim = "UPDATE `organizimkursantesh1`SET statusi='ndryshuar' WHERE idkursanti='$id' and idkursi = $idkursiexistuees";

        if(mysqli_query($link, $querydeleteexistorganizim)){
            $quryshto = "insert into organizimkursantesh1 (idkursi, idkursanti,statusi ) values ('$idkursi','$id', 'pabere');";
            mysqli_query($link, $quryshto);
            //echo $quryshto;
            header('location: ../inputer/bejndryshime.php');
        }
        else{
            //echo 'Posht';
            echo "<script>
            alert('Something went wrong douring delete first registration for this person! Try again!');
            window.location.href='../inputer/inputerpage.php';
            </script>";
        }  
    }
    else
    {
        //echo 'PoshtFare';
        echo "<script>
        alert('Something went wrong! Try again!');
        window.location.href='../inputer/inputerpage.php';
        </script>";
    }
?>