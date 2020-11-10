
<?php

$link = mysqli_connect("localhost", "root", "", "kksh");

if($link === false){
die("ERROR: Could not connect. " . mysqli_connect_error());
}

$id= mysqli_real_escape_string( $link,$_POST['id-txt']);
$datakursit= mysqli_real_escape_string( $link,$_POST['datakursit']);
$orari = mysqli_real_escape_string( $link,$_POST['orari']);
$tel   =mysqli_real_escape_string( $link,$_POST['tel-txt']);
//echo $id . $amza;

$vendosamzen = "update kursant set Datakursit = '$datakursit', ORari = '$orari', Telefoni = '$tel' where ID = '$id'";
//echo $vendosamzen;
if($runupdetin  =mysqli_query($link, $vendosamzen))
{
    header('location: Bejndryshime.php');
}
else
{
    echo "Ndodhi nje gabim ne vendosjen e amzes";
}



?>