<?php
    $link = mysqli_connect("localhost", "root", "", "kksh");
    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    $emriklases= test_input(mysqli_real_escape_string( $link,$_POST['emriklases-txt']));
    $kapaciteti=test_input(mysqli_real_escape_string( $link,$_POST['kapaciteti-txt']));
    $dega= test_input(mysqli_real_escape_string( $link,$_POST['dega']));

    $idklases = "select * from qyteti where EmriDeges = '$dega';";
    $resultinsert = mysqli_query($link, $idklases);
    $row = mysqli_fetch_array($resultinsert);
    $iddeges = $row['IDQyteti'];
    if($iddeges <> '')
    {
        $sqlshtoklas = "insert into klasa (Qyteti,Kapaciteti,Emri) values('$iddeges','$kapaciteti','$emriklases');";
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