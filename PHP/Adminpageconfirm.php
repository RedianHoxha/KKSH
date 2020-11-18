<?php

session_start();
//require('session.php');
$user=$_SESSION['user'];
$iduseri = $_SESSION['UserID'];
$link = mysqli_connect("localhost", "root", "", "kksh");
//echo $iduseri;
//echo $user;

$query = "select * from staf where ID = '$iduseri';";
$kursantet=mysqli_query($link, $query);
$row = mysqli_fetch_array($kursantet);
if($row['Roli'] <> "Admin")
{
    header('location: ../HTML/Homepage.html');
}

if($link === false){
die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<head>
    <title>Kryqi i Kuq Shqipetar</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Admintestimecss.css" />
</head>
<body>
    <div id="top">
        <div id="logout">
            <button onclick="location.href = '../PHP/Logout.php';" id="myButton" >Dil <?php echo $user ?></button>
            <button onclick="location.href = '';" id="myButton" >Gjenero file mujore </button>
            <button onclick="location.href = '../PHP';" id="myButton" >Gjenero file javore </button>
        </div>
    </div>
    <div id="bottom">
        <div id="Staf">
            <div>
              <button onclick="location.href = 'Shtostaf.php';" id="addbutton" >Shto Staf</button>
            </div>
            <div id="tabela">
                <table id="stafi">  
                    <tr>
                        <th>Emri</th>
                        <th>Mbiemer</th>
                        <th>Rol</th>
                        <th>Dega</th>
                        <th>Username</th>
                        <th>Telefoni</th>
                    </tr>
                    <tr>
                            <?php $sqlquery="Select * from staf";
                            $kursantet=mysqli_query($link, $sqlquery);
                            while ($row = mysqli_fetch_array($kursantet)) { ?> 

                        <td><?php echo $row['Emri']; ?></td>
                        <td><?php echo $row['Mbiemri']; ?></td>
                        <td><?php echo $row['Roli']; ?></td>
                        <td><?php echo $row['Degakupunon']; ?></td>
                        <td><?php echo $row['Username']; ?></td>
                        <td><?php echo $row['Telefoni']; ?></td>

                    </tr> 
                    <?php } ?>
                </table>
            </div><br>
        </div>
        <div id="Dege">
               <div>
                    <button onclick="location.href = 'Shtodege.php';" id="addButton" >Shto Dege</button> 
               </div>
            <div id="tabela">
                    <table id="dega">  
                        <tr>
                            <th>Emri</th>
                        </tr>
                        <tr>
                        <?php $sqlquery="Select * from qyteti";
                            $kursantet=mysqli_query($link, $sqlquery);
                            while ($row = mysqli_fetch_array($kursantet)) { ?> 

                        <td><?php echo $row['EmriDeges']; ?></td>
                        </tr> 
                        <?php } ?>
                    </table>
                </div><br>
            </div>
        <div id="Klase">
            <div id="tabela">
                <div>
                 <button onclick="location.href = 'Shtoklase.php';" id="addButton" >Shto Klase</button>
                </div>
                <table id="klasa">  
                    <tr>
                        <th>Idetifikimi</th>
                        <th>Qyteti</th>
                        <th>Kapaciteti</th> 
                    </tr>
                    <tr>
                    <?php $sqlquery="Select * from klasa";
                            $kursantet=mysqli_query($link, $sqlquery);
                            while ($row = mysqli_fetch_array($kursantet)) { ?> 

                        <td><?php echo $row['Emri']; ?></td>
                        <td><?php echo $row['Qyteti']; ?></td>
                        <td><?php echo $row['Kapaciteti']; ?></td>
                    </tr> 
                    <?php } ?>
                </table>
            </div><br>
        </div>
    </div>
</body>
</html>