<?php
session_start();
require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');
//$link = mysqli_connect("localhost", "root", "", "kksh");

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$user = $_SESSION['user'];
$iduseri = $_SESSION['UserID'];

$idplanifikimToDelete = $_GET['id'];

$queryFshiplanifikim = "DELETE FROM programijavor where idkursi = $idplanifikimToDelete;";
if ($runfshiUser = mysqli_query($link, $queryFshiplanifikim)) {

    header('location: ../admin/admindege.php');
} else {
    echo "<script>
            alert('Something went wrong! Try again!');
            window.location.href='../admin/admindege.php';
            </script>";
}
?>