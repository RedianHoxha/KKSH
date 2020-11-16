<?php

session_start();
$user=$_SESSION['user'];
$link = mysqli_connect("localhost", "root", "", "kksh");
//echo $user;

if($link === false){
die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
    <head>
        <title>Kryqi i Kuq Shqipetar</title>
        <link rel="stylesheet" type="text/css"  href="../CSS/Adminstilizo.css">
    </head>
    <body>
            <div id="loginbutton">
                <button onclick="location.href = '../PHP/Logout.php';" id="myButton" >Dil <?php echo $user ?></button>
            </div>
            <div id="mainaddbutton">
                    <button onclick="location.href = 'Shtostaf.php';" id="addbutton" >Shto Staf</button>
                    <button onclick="location.href = 'Shtoklase.php';" id="addButton" >Shto Klase</button>
                    <button onclick="location.href = 'Shtodege.php';" id="addButton" >Shto Dege</button>
            </div>  
            <div id="filebutton">
                <button onclick="location.href = '../PHP/Inputerpage.php';" id="myButton" >Gjenero filen e te dhenave javore</button>
                <button onclick="location.href = '../PHP/Inputerpage.php';" id="myButton" >Gjenero filen e te dhenave mujore</button>

            </div>
    </body>
</html>
