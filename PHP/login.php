<?php

$link = mysqli_connect("localhost", "root", "", "kksh");

if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}


   $username= mysqli_real_escape_string( $link,$_POST['username']);
   $password=mysqli_real_escape_string( $link,$_POST['password']);

$queryuser ="select * from staf where Username= ? and Password= ?";
$stmt = mysqli_stmt_init($link);
if(!mysqli_stmt_prepare($stmt,$queryuser))
{
    echo  'Prove e deshtuar';
}
else
{
    mysqli_stmt_bind_param($stmt, "ss" ,$username, $password);
    
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row =mysqli_fetch_assoc($result);
        if(mysqli_num_rows($result) > 0)
        {

           session_start();
            $_SESSION['UserID'] = $row['ID'];
            $_SESSION['user']= $username;
            
            if($row['Roli'] == "Admin")
            {
                header('location: Adminpageconfirm.php');
            }
            else if($row['Roli' ] == "Inputer")
            {
                header('location: ../PHP/Inputerpage.php');
            }
            else if($row['Roli' ] == "Konfirmues")
            {
                header('location: Confirmpage.php');
            }
            else if($row['Roli' ] == "Admindege")
            {
                header('location: ../PHP/Admindege.php');
            }
            else
            {
                
                header('location: ../HTML/Homepage.html');
            }
        }
        else
        {
            
            header('location: ../HTML/Homepage.html');
        }

    

}

?>