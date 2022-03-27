<?php
    session_start();
    require_once('../php/extra_function.php');
    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $user=$_SESSION['user'];
    $iduseri = $_SESSION['UserID'];

    $idDegeToDelete = $_GET['id'];

    $queryFshiDege = "DELETE FROM qyteti where IDQyteti = '$idDegeToDelete';";
    if($runfshiDege = mysqli_query($link, $queryFshiDege)){
        
        header('location: ../admin/adminpageconfirm.php');
    }
    else{
        echo "<script>
            alert('Something went wrong! Try again!');
            window.location.href='../admin/adminpageconfirm.php';
            </script>";
    }
?>