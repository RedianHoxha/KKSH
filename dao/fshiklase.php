<?php
    session_start();
    require_once('../php/extra_function.php');
    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $user=$_SESSION['user'];
    $iduseri = $_SESSION['UserID'];

    $idKlasoDelete = $_GET['id'];

    $queryFshiKlase = "DELETE FROM klasa where ID = '$idKlasoDelete';";
    if($runfshiKlase = mysqli_query($link, $queryFshiKlase)){
        
        header('location: ../admin/adminpageconfirm.php');
    }
    else{
        echo "<script>
            alert('Something went wrong! Try again!');
            window.location.href='../admin/adminpageconfirm.php';
            </script>";
    }
?>