<?php

    //$link = mysqli_connect("localhost", "root", "", "kksh");
    require_once('../methods/extra_function.php');
    include('../authenticate/dbconnection.php');
    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }    

    $idUserToDelete = $_GET['id'];

    $emri= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['emri-txt'])));
    $mbiemri= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['mbiemri-txt'])));
    $id= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['id-txt'])));
    $username= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['username-txt'])));
    $password= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['password-txt'])));
    $roli= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['roli'])));
    $tel= test_input(mysqli_real_escape_string( $link,$_POST['tel-txt']));
    $dega= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['dega'])));

    $queryExistUser = "SELECT * FROM staf WHERE UniqueId = $idUserToDelete";
    if($resultExistUser = mysqli_query($link, $queryExistUser)){
        $existsUsers = mysqli_num_rows($resultExistUser);

        if($existsUsers == 0){
          $queryStaf = "INSERT INTO staf(ID,Emri,Mbiemri,Username,Password,Roli,Degakupunon,Telefoni)
          VALUES ( '$id', '$emri', '$mbiemri', '$username','$password', '$roli','$dega', '$tel');";
        }else{
          $queryStaf="UPDATE `staf` SET `ID`='$id', `Emri`='$emri',`Mbiemri`='$mbiemri',`Username`='$username',
          `Password`='$password',`Roli`='$roli',`Degakupunon`='$dega',`Telefoni`='$tel' WHERE  UniqueId = $idUserToDelete";
        }

        echo $queryStaf;
        if($resultinsert = mysqli_query($link, $queryStaf))
        {
           header('location:../admin/adminpageconfirm.php');
        }
        else
        {
          echo "<script>
          alert('Something went wrong1! Try agaoin');
          window.location.href='../admin/adminpageconfirm.php';
          </script>";
        }
    }else{
      echo "<script>
      alert('Something went wrong! Try again');
      window.location.href='../admin/adminpageconfirm.php';
      </script>";
    }
?>