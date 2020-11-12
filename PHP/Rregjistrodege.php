<?php

    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

    $emrideges= mysqli_real_escape_string( $link,$_POST['emrideges-txt']);

    $shtodege = "insert into qyteti (EmriDeges) values ('$emrideges');";

    if($resultinsert = mysqli_query($link, $shtodege))
    {
        header('location: Adminpageconfirm.php');
    }
    else
    {
        echo "Ka ndodhur nje gabim ne shtimine deges se re";
    }



?>