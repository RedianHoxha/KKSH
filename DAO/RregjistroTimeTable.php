<?php
//$link = mysqli_connect("localhost", "root", "", "kksh");
require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');
if ($link === false) {
   die("ERROR: Could not connect. " . mysqli_connect_error());
}

$instruktori = test_input(mysqli_real_escape_string($link, $_POST['instruktori']));
$klasa = test_input(mysqli_real_escape_string($link, $_POST['klasa']));
$data = test_input(mysqli_real_escape_string($link, $_POST['datakursit']));
$ora = test_input(mysqli_real_escape_string($link, $_POST['orari']));

$queryshtoprogram = "INSERT INTO programijavor(idklase,idinstruktori,orari,data) VALUES ('$klasa','$instruktori','$ora','$data');";

if ($resultinsert = mysqli_query($link, $queryshtoprogram)) {
   header('location:../admin/admindege.php');
} else {
   echo "<script>
      alert('Something went wrong! Try again');
      window.location.href='../admin/adminpageconfirm.php';
      </script>";
}
?>