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
    $id= test_input(mysqli_real_escape_string( $link,$_POST['id-txt']));
    $username= test_input(mysqli_real_escape_string( $link,$_POST['username-txt']));
    $password= test_input(mysqli_real_escape_string( $link,$_POST['password-txt']));
    $roli= test_input(mysqli_real_escape_string( $link,$_POST['roli']));
    $tel= test_input(mysqli_real_escape_string( $link,$_POST['tel-txt']));
    $dega= test_input(mysqli_real_escape_string( $link,$_POST['dega']));
    //echo $vendbanim . $orari . $datakursit. $dega;

    $shtostaf = "insert into staf(ID,Emri,Mbiemri,Username,Password,Roli,Degakupunon,Telefoni)
     values ( '$id', '$emri', '$mbiemri', '$username','$password', '$roli','$dega', '$tel');";
    //echo $shtokursant;
     
     if($resultinsert = mysqli_query($link, $shtostaf))
     {
        header('location:../Admin/Adminpageconfirm.php');
     }
     else
     {
      echo "<script>
      alert('Something went wrong! Try agaoin');
      window.location.href='../Admin/Adminpageconfirm.php';
      </script>";
  }
?>