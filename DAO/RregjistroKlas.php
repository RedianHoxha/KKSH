<?php
    require_once('../php/extra_function.php');
    include('../authenticate/dbconnection.php');
    //$link = mysqli_connect("localhost", "root", "", "kksh");
    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
    $emriklases= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['emriklases-txt'])));
    $kapaciteti=test_input(mysqli_real_escape_string( $link,$_POST['kapaciteti-txt']));
    $dega=test_input(mysqli_real_escape_string( $link,$_POST['dega']));

    $idklases = "SELECT * FROM  qyteti WHERE EmriDeges = '$dega';";
    $resultinsert = mysqli_query($link, $idklases);
    $row = mysqli_fetch_array($resultinsert);
    $iddeges = $row['IDQyteti'];
    if($iddeges <> '')
    {
        $sqlshtoklas = "INSERT INTO klasa (Qyteti,Kapaciteti,Emri) VALUES ('$iddeges','$kapaciteti','$emriklases');";
        if( $resultinsert = mysqli_query($link, $sqlshtoklas))
        {
            header('location: ../admin/adminpageconfirm.php');
        }
        else
        {
            echo "<script>
            alert('Something went wrong! Try again! ');
            window.location.href='../admin/adminpageconfirm.php';
            </script>";
        }
    }
    else
    {
        echo "<script>
        alert('Something went wrong! Try again! Klasa doesnt exist');
        window.location.href='../admin/adminpageconfirm.php';
        </script>";
    }
?>