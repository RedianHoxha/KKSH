<?php 
            
            session_start();
            $user=$_SESSION['user'];
            //require('session.php');
            $iduseri = $_SESSION['UserID'];
            $link = mysqli_connect("localhost", "root", "", "kksh");
            //echo $iduseri;
    
            $query = "select * from staf where ID = '$iduseri';";
            $kursantet=mysqli_query($link, $query);
            $row = mysqli_fetch_array($kursantet);
            //echo $row['Roli'];
            if($row['Roli'] <> "Admin")
            {
                header('location: ../HTML/Homepage.html');
            }

        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
}?>


<!DOCTYPE html>
<head>
    <title>Kryqi i Kuq Shqipetar</title>
   <link href='../CSS/Shtostafstyle.css' rel='stylesheet' /> 
</head>
<body>
    <div id="top-page">
        <button onclick="location.href = '../PHP/Adminpageconfirm.php';" id="myButton" > Home</button>
        <button onclick="location.href = '../PHP/Logout.php';" id="myButton" > Dil <?php echo $user ?></button>
    </div>
    <div id="Form">
            <form action="../PHP/Rregjistrodege.php" method="POST">
                        <div id="hello">
                                 <img src="../Images/KKSH_logo.PNG" alt="Simply Easy Learning" id="KKSH_logo">
                        </div>
                        <div id="tedhenapersonale">
                            <p id="emri">Emri Deges</p>
                            <input class="input100" id="emrideges-txt" type="text" 
                            name="emrideges-txt" placeholder="..." autocomplete="off"><br>
                            
                           </div><br><br> 
                           <div>
                            <button type="submit" id="rregjistro-button">Rregjistro</button>
                        </div>    
        </form>
    </div>
</body>
</html>
