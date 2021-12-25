<?php 
   $link = mysqli_connect("localhost", "root", "", "kksh");

   if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}

    $idPlanifikimi = $_GET['edit'];

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    $instruktori= test_input(mysqli_real_escape_string( $link,$_POST['instruktori']));
    $klasa=test_input(mysqli_real_escape_string( $link,$_POST['klasa']));
    $data= test_input(mysqli_real_escape_string( $link,$_POST['datakursit']));
    $ora=test_input(mysqli_real_escape_string( $link,$_POST['orari']));

    $queryshtoprogram ="UPDATE programijavor set idinstruktori = '$instruktori', orari = '$ora', data = '$data', idklase = '$klasa'  WHERE idkursi = '$idPlanifikimi';";

    if($resultinsert = mysqli_query($link, $queryshtoprogram))
    {
        echo "<script>
        alert('OK');
        window.location.href='../admin/Admindege.php';
        </script>";
    }
    else
    {
      echo "<script>
      alert('Something went wrong! Try again');
      window.location.href='../admin/Admindege.php';
      </script>";
  }
?>