
<?php

    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $id= mysqli_real_escape_string( $link,$_POST['id-txt']);
    $amza= mysqli_real_escape_string( $link,$_POST['amza-txt']);
    $seria= mysqli_real_escape_string( $link,$_POST['deshmi-txt']);

    //echo $id . $amza;

    $vendosamzen = "update kursant set Amza= '$amza', NrSerisDeshmis = '$seria' where ID = '$id'";
    //echo $vendosamzen;
    if($runupdetin  =mysqli_query($link, $vendosamzen))
    {
        header('location: Confirmpage.php');
    }
    else
    {
        echo "Ndodhi nje gabim ne vendosjen e amzes";
    }



?>