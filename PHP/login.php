<?php
$link = mysqli_connect("localhost", "root", "", "kksh");

if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}


   $username= mysqli_real_escape_string( $link,$_POST['username']);
   $password=mysqli_real_escape_string( $link,$_POST['password']);

   //echo $username, $password;

//    $queryekzistonuser = "select * from staf where Username= '$username' and Password= '$password';";
//    echo $queryekzistonuser;
//    $resultuseri = mysqli_query($link, $queryekzistonuser);
//    $row = mysqli_fetch_array($resultuseri);

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
       // $numrirreshtave = $stmt->rowCount();
        if(mysqli_num_rows($result) > 0)
        {

            session_start();
            $_SESSION['user']= $username;
            
            if($row['Roli'] == "Admin")
            {
                header('location: Adminpageconfirm.php');
            }
            else if($row['Roli']== "Rregjistrues")
            {
                header('location: ../PHP/Inputerpage.php');
            }
            else
            {
                header('location: Confirmpage.php');
            }
        }
        else
        {
            echo "error";
        }

    

}

?>