<?php

    //$link = mysqli_connect("localhost", "root", "", "kksh");
    require_once('../methods/extra_function.php');
    include('../authenticate/dbconnection.php');
    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $emri= encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['emri-txt']))));
    $mbiemri= encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['mbiemri-txt']))));
    $id= encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['id-txt']))));
    $username= encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['username-txt']))));
    $password= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['password-txt'])));
    $roli= encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['roli']))));
    $tel= test_input(mysqli_real_escape_string( $link,$_POST['tel-txt']));
    $dega= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['dega'])));


    $queryStaf = "INSERT INTO staf(ID,Emri,Mbiemri,Username,Password,Roli,Degakupunon,Telefoni)
    VALUES ( '$id', '$emri', '$mbiemri', '$username','$password', '$roli','$dega', '$tel');";
    

    if($resultinsert = mysqli_query($link, $queryStaf))
    {
        header('location:../admin/adminpageconfirm.php');
    }
    else
    {
        echo "<script>
        alert('Something went wrong! Try agaoin');
        window.location.href='../admin/adminpageconfirm.php';
        </script>";
    }
?>