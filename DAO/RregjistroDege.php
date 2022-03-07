<?php

    $link = mysqli_connect("localhost", "root", "", "kksh");
    require_once('../php/extra_function.php');
    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    $emrideges= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['emrideges-txt'])));
    $adersa = test_input(mysqli_real_escape_string( $link,$_POST['adresa-txt']));
    $shtodege = "insert into qyteti (EmriDeges, Adresa) values ('$emrideges', '$adersa');";

    if($resultinsert = mysqli_query($link, $shtodege))
    {
        header('location: ../admin/adminpageconfirm.php');
    }
    else
    {
        echo "<script>
        alert('Something went wrong! Try again');
        window.location.href='../admin/adminpageconfirm.php';
        </script>";
    }
?>