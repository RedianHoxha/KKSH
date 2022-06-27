<?php
    session_start();
    require_once('../methods/extra_function.php');
    include('../authenticate/dbconnection.php');
    //$link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $user=$_SESSION['user'];
    $iduseri = $_SESSION['UserID'];

    $idDegeToDelete = $_GET['id'];

    $queryFshiDege = "DELETE FROM qyteti WHERE IDQyteti = '$idDegeToDelete';";
    $runfshiDege = mysqli_query($link, $queryFshiDege) or die(mysqli_error($link));
    if($runfshiDege){
        
        header('location: ../admin/adminpageconfirm.php');
    }
    else{
        echo "<script>
            alert('Something went wrong! Try again!');
            window.location.href='../admin/adminpageconfirm.php';
            </script>";
    }
?>