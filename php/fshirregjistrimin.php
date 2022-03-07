<?php
    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

      $idKursanti = $_GET['id'];


    $fshikursantngaplanifikimi = "DELETE FROM organizimkursantesh1 where idkursanti = '$idKursanti'";

    if($runupdetinorganizim  = mysqli_query($link, $fshikursantngaplanifikimi))
    {
        $fshiKursant = "DELETE FROM kursantet  where ID = '$idKursanti'";
        if($runfshiorganizim = mysqli_query($link, $fshiKursant))
        {
            header('location: ../inputer/bejndryshime.php');
        }
        else
        {
            echo $fshiKursant;
            // echo "<script>
            // alert('Something went wrong! Try again!');
            // window.location.href='../inputer/inputerpage.php';
            // </script>";
        }
    }
    else
    {
        $fshiKursant = "DELETE FROM kursantet  where ID = '$idKursanti'";
        if($runpaorganizim = mysqli_query($link, $fshiKursant))
        {
            header('location: ../inputer/bejndryshime.php');
        }
        else
        {
            echo $fshiKursant;
            // echo "<script>
            // alert('Something went wrong! Try again!');
            // window.location.href='../inputer/inputerpage.php';
            // </script>";
        }
    }



    if($runupdetin  =mysqli_query($link, $fshiKursant))
    {
        header('location: ../inputer/bejndryshime.php');
    }
    else
    {
        echo $fshiKursant;
        // echo "<script>
        // alert('Something went wrong! Try again!');
        // window.location.href='../inputer/inputerpage.php';
        // </script>";
    }
?>