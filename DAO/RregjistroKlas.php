<?php
    $link = mysqli_connect("localhost", "root", "", "kksh");
    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

    $emriklases= mysqli_real_escape_string( $link,$_POST['emriklases-txt']);
    $kapaciteti= mysqli_real_escape_string( $link,$_POST['kapaciteti-txt']);
    $dega= mysqli_real_escape_string( $link,$_POST['dega']);

    $idklases = "select * from qyteti where EmriDeges = '$dega';";
    $resultinsert = mysqli_query($link, $idklases);
    $row = mysqli_fetch_array($resultinsert);
    $iddeges = $row['IDQyteti'];
    if($iddeges <> '')
    {
        $sqlshtoklas = "insert into klasa (Qyteti,Kapaciteti,Emri) values('$iddeges','$kapaciteti','$emriklases');";
        if( $resultinsert = mysqli_query($link, $sqlshtoklas))
        {
            header('location: ../Admin/Adminpageconfirm.php');
        }
        else
        {
            echo "<script>
            alert('Something went wrong! Try agaoin');
            window.location.href='../Admin/Adminpageconfirm.php';
            </script>";
        }
    }
    else
    {
        echo "<script>
        alert('Something went wrong! Try again');
        window.location.href='../Admin/Adminpageconfirm.php';
        </script>";
    }
?>