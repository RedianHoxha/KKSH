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

    $id= test_input(mysqli_real_escape_string( $link,$_POST['id-txt']));
    $datakursit= test_input(mysqli_real_escape_string( $link,$_POST['datakursit']));
    $orari = test_input(mysqli_real_escape_string( $link,$_POST['orari']));
    $tel = test_input(mysqli_real_escape_string( $link,$_POST['tel-txt']));

    $vendosamzen = "update kursant set Datakursit = '$datakursit', ORari = '$orari', Telefoni = '$tel' where ID = '$id'";
    if($runupdetin  =mysqli_query($link, $vendosamzen))
    {
        header('location: ../Inputer/BejNdryshime.php');
    }
    else
    {
        echo "<script>
        alert('Something went wrong! Try again!');
        window.location.href='../Inputer/Inputerpage.php';
        </script>";
    }
?>