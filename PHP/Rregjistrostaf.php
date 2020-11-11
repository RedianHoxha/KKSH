<?php

    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $emri= mysqli_real_escape_string( $link,$_POST['emri-txt']);
    $mbiemri= mysqli_real_escape_string( $link,$_POST['mbiemri-txt']);
    $id= mysqli_real_escape_string( $link,$_POST['id-txt']);
    $username= mysqli_real_escape_string( $link,$_POST['username-txt']);
    $password= mysqli_real_escape_string( $link,$_POST['password-txt']);
    $roli= mysqli_real_escape_string( $link,$_POST['roli']);
    $tel= mysqli_real_escape_string( $link,$_POST['tel-txt']);
    $dega= mysqli_real_escape_string( $link,$_POST['dega']);
    //echo $vendbanim . $orari . $datakursit. $dega;

    $shtostaf = "insert into staf(ID,Emri,Mbiemri,Username,Password,Roli,Degakupunon,Telefoni)
     values ( '$id', '$emri', '$mbiemri', '$username','$password', '$roli','$dega', '$tel');";
    //echo $shtokursant;
     
     if($resultinsert = mysqli_query($link, $shtostaf))
     {
        header('location:../PHP/Adminpage.php');
     }
     else
     {
        echo "Dicka shkoi gabim ne rregjistrimine kursantit!";
     }



?>