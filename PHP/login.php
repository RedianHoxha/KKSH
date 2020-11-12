<?php
$link = mysqli_connect("localhost", "root", "", "kksh");

if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}


   $username= mysqli_real_escape_string( $link,$_POST['username']);
   $password=mysqli_real_escape_string( $link,$_POST['password']);

   //echo $username, $password;

   $queryekzistonuser = "select * from staf where Username= '$username' and Password= '$password';";
   echo $queryekzistonuser;
   $resultuseri = mysqli_query($link, $queryekzistonuser);
   $row = mysqli_fetch_array($resultuseri);

   session_start();
   $_SESSION['user']= $username;
   
    if($row['Roli'] == "Admin")
    {
        header('location: Adminpageconfirm.php');
    }
    else if($row['Roli']== "Rregjistrues")
    {
        header('location: ../HTML/Inputerpage.php');
    }
    else
    {
        header('location: Confirmpage.php');
    }


?>