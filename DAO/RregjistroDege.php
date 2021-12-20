<?php

    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
    $emrideges= mysqli_real_escape_string( $link,$_POST['emrideges-txt']);

    $shtodege = "insert into qyteti (EmriDeges) values ('$emrideges');";

    if($resultinsert = mysqli_query($link, $shtodege))
    {
        header('location: ../Admin/Adminpageconfirm.php');
    }
    else
    {
        echo "<script>
        alert('Something went wrong! Try again');
        window.location.href='../Admin/Adminpageconfirm.php';
        </script>";
    }
?>