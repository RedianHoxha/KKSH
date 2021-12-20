<?php 
   $link = mysqli_connect("localhost", "root", "", "kksh");

   if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}

    $instruktori= mysqli_real_escape_string( $link,$_POST['instruktori']);
    $klasa=mysqli_real_escape_string( $link,$_POST['klasa']);
    $data= mysqli_real_escape_string( $link,$_POST['datakursit']);
    $ora=mysqli_real_escape_string( $link,$_POST['orari']);

    $queryshtoprogram ="insert into programijavor(idklase,idinstruktori,orari,data) values ('$klasa','$instruktori','$ora','$data');";

    if($resultinsert = mysqli_query($link, $queryshtoprogram))
    {
       header('location:../Admin/Admindege.php');
    }
    else
    {
      echo "<script>
      alert('Something went wrong! Try again');
      window.location.href='../Admin/Adminpageconfirm.php';
      </script>";
  }
?>