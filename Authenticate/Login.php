<?php

require_once('../php/extra_function.php');
include('../Authenticate/dbconnection.php');

if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}

   $username= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['username'])));
   $password= encryptValues(mysqli_real_escape_string( $link,$_POST['password']));

$queryuser ="select * from staf where Username= ? and Password= ?";
$stmt = mysqli_stmt_init($link);
if(!mysqli_stmt_prepare($stmt,$queryuser))
{
    echo "<script>
        alert('Retry');
        window.location.href='../html/index.php';
        </script>";
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
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
            
            if(decrypt($row['Roli']) == "Admin")
            {
                header('location: ../admin/adminpageconfirm.php');
            }
            else if(decrypt($row['Roli']) == "Inputer")
            {
                header('location: ../inputer/inputerpage.php');
            }
            else if(decrypt($row['Roli']) == "Confirmues")
            {
                header('location: ../confirm/confirmpage.php');
            }
            else if(decrypt($row['Roli']) == "Admindege")
            {
                header('location: ../admin/admindege.php');
            }
            else if(decrypt($row['Roli']) == "webrole")
            {
                header('location: ../web/webpage.html');
            }
            else
            {
                header('location: ../html/index.php');
            }
        }
        else
        {
            echo "<script>
            alert('Login failed! Username or Password wrong');
            window.location.href='../html/index.php';
            </script>";
        }
}
?>