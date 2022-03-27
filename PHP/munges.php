<?php
    session_start();
    require_once('../php/extra_function.php');
    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $user=$_SESSION['user'];
    $iduseri = $_SESSION['UserID'];
    $query = "select * from staf where ID = '$iduseri';";
    $kursantet=mysqli_query($link, $query);
    $row = mysqli_fetch_array($kursantet);
    $roli = decrypt($row['Roli']);

    $idKursanti = $_GET['id'];


    $fshikursantngaplanifikimi = "DELETE FROM organizimkursantesh1 where idkursanti = '$idKursanti'";

    if($runupdetinorganizim  = mysqli_query($link, $fshikursantngaplanifikimi))
    {
        $fshiKursant = "UPDATE kursantet SET Statusi='Munges' WHERE ID = '$idKursanti' and Statusi='pabere'";
        if($runfshiorganizim = mysqli_query($link, $fshiKursant))
        {
            if(strcmp($roli,"Inputer") == 0)
            {
                 header('location: ../inputer/bejndryshime.php');
            }
            else if(strcmp($roli,"Confirmues") == 0)
            {
                header('location: ../confirm/confirmpage.php');
            }
        }
        else
        {
            echo "<script>
            alert('Something went wrong! Try again!');
            window.location.href='../inputer/inputerpage.php';
            </script>";
        }
    }
?>