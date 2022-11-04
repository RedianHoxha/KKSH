<?php
//$link = mysqli_connect("localhost", "root", "", "kksh");
require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');
if ($link === false) {
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

$idPlanifikimi = $_GET['edit'];
$instruktori = test_input(mysqli_real_escape_string($link, $_POST['instruktori']));
$klasa = test_input(mysqli_real_escape_string($link, $_POST['klasa']));
$data = test_input(mysqli_real_escape_string($link, $_POST['datakursit']));
$ora = test_input(mysqli_real_escape_string($link, $_POST['orari']));

$queryshtoprogram = "UPDATE programijavor SET idinstruktori = '$instruktori', orari = '$ora', data = '$data', idklase = '$klasa'  WHERE idkursi = '$idPlanifikimi';";

if ($resultinsert = mysqli_query($link, $queryshtoprogram)) {
  echo "<script>
        alert('Modification gone successfully');
        window.location.href='../admin/admindege.php';
        </script>";
} else {
  echo "<script>
      alert('Something went wrong! Try again');
      window.location.href='../admin/admindege.php';
      </script>";
}
?>