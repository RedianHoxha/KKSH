<?php

    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

    $emriklases= mysqli_real_escape_string( $link,$_POST['emriklases-txt']);
    $kapaciteti= mysqli_real_escape_string( $link,$_POST['kapaciteti-txt']);
    $dega= mysqli_real_escape_string( $link,$_POST['dega']);

    $idklases = "select * from qyteti where EmriDeges = '$dega';";
    //echo $idklases;
    $resultinsert = mysqli_query($link, $idklases);
    $row = mysqli_fetch_array($resultinsert);
    $iddeges = $row['IDQyteti'];
    //echo $iddeges;
    if($iddeges <> '')
        {
            $sqlshtoklas = "insert into klasa (Qyteti,Kapaciteti,Emri) values('$iddeges','$kapaciteti','$emriklases');";
            echo $sqlshtoklas;
    
            if( $resultinsert = mysqli_query($link, $sqlshtoklas))
            {
               header('location: Adminpageconfirm.php');
               echo "jemi ketu";
            }
            else
            {
                echo "Dicka shkoi gabim ne shtimine deges se re";
            }
    }
    else
    {
        echo "kjo dege nuk ekziston ne kompanin tuaj";
    }


?>