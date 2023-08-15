<?php 
    session_start();
    include('../authenticate/dbconnection.php');

    $shtokolone = "ALTER TABLE kursantet ADD COLUMN BankName VARCHAR(50);";
    $kursantet=mysqli_query($link, $shtokolone);

    if($kursantet){
        echo "Succes";
    }else{
        echo "Error";
    }
    ?>