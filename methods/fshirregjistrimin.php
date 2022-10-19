<?php
    session_start();
    require_once('../methods/extra_function.php');
    include('../authenticate/dbconnection.php');
    //$link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $user=$_SESSION['user'];
    $iduseri = $_SESSION['UserID'];
    $query = "SELECT * FROM  staf WHERE ID = '$iduseri';";
    $kursantet=mysqli_query($link, $query);
    $row = mysqli_fetch_array($kursantet);
    $roli = decrypt($row['Roli']);

    $idKursanti = $_GET['id'];

    $getInformationForKursant = "SELECT * FROM kursantet WHERE ID = '$idKursanti'";
    $runGetInformationForKursant = mysqli_query($link, $getInformationForKursant);
    $informationForKursant = mysqli_fetch_array($runGetInformationForKursant);
    $personalId = $informationForKursant['PersonalId'];

    $fshikursantngaplanifikimi = "UPDATE organizimkursantesh1  SET statusi = 'Fshire' where idkursanti = '$personalId' AND statusi = 'pabere'";

    if($runupdetinorganizim  = mysqli_query($link, $fshikursantngaplanifikimi))
    {

        $fshiKursant = "DELETE FROM kursantet  where ID = '$idKursanti'";
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