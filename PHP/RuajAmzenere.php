<?php
    //$link = mysqli_connect("localhost", "root", "", "kksh");
    require_once('../php/extra_function.php');
    include('../Authenticate/dbconnection.php');
    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $idkursanti = $_GET['id'];

    $id= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['id-txt'])));
    $amza= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['amza-txt'])));
    $seria= encryptValues(test_input( mysqli_real_escape_string( $link,$_POST['deshmi-txt'])));

    $vendosamzen = "update kursantet set Amza= '$amza', NrSerisDeshmis = '$seria', Statusi= 'perfunduar' where ID = '$idkursanti'";
    
    if($runupdetin  =mysqli_query($link, $vendosamzen))
    {
        $quryupdetostatusinkursantit = "update organizimkursantesh1 set statusi = 'Perfunduar' where  idkursanti = '$id';";
        mysqli_query($link, $quryupdetostatusinkursantit);
        header('location: ../confirm/confirmpage.php');
    }
    else
    {
        echo "<script>
        alert('Something went wrong! Try again!');
        window.location.href='../confirm/confirmpage.php';
        </script>";
    }
?>