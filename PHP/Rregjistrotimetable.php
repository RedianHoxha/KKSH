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
       header('location:../PHP/Admindege.php');
    }
    else
    {
       echo "Dicka shkoi gabim ne rregjistrimine e programit!";
    }
?>