<?php 
            session_start();
            $user=$_SESSION['user'];
            $iduseri = $_SESSION['UserID'];
            $link = mysqli_connect("localhost", "root", "", "kksh");
    
            $query = "select * from staf where ID = '$iduseri';";
            $staf=mysqli_query($link, $query);
            $row = mysqli_fetch_array($staf);
            $dega = $row['Degakupunon'];

            if($row['Roli'] <> "Admindege")
            {
                echo "<script>
                alert('You don't have access to see this page! Session Failed!');
                window.location.href='../HTML/Homepage.html';
                </script>";
            }
            $queryqyteti = "select * from qyteti where EmriDeges = '$dega';";
            $klasa=mysqli_query($link, $queryqyteti);
            $row = mysqli_fetch_array($klasa);
            $idqyteti = $row['IDQyteti'];

        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
}?>

<!DOCTYPE html>
<head>
    <title>Kryqi i Kuq Shqiptar</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Admindege_Stilizime.css" />
</head>
<body>

    <button onclick="location.href = '../Authenticate/Logout.php';" id="myButton" > Dil <?php echo $user ?></button><br>
    <div id="add_button">
             <button onclick="location.href = 'shtoplanifikim.php';" id="addbutton" >Shto Planifikim</button>
        </div>
    <img src="../Images/KKSH_logo.PNG" alt="Simply Easy Learning" id="KKSH_logo">

    <p id="welcome">Welcome</p><br>

    <div id="organisation_table">
        
        <div id="tabela">
        <table id="organizim_javor">  
                    <tr>
                        <th>Klasa</th>
                        <th>Instruktori</th>
                        <th>Orari</th>
                        <th>Data</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <?php 
                        $firstday = date('Y-m-d', strtotime("monday -1 week"));
                        $lastday = date('Y-m-d', strtotime("sunday 0 week"));
                        $sqlquery="SELECT * FROM `programijavor` WHERE data BETWEEN '$firstday' AND '$lastday' ORDER BY data ASC;";
                        echo "<script>console.log('Debug Objects: " . $sqlquery .  "' );</script>";
                        $kursantet=mysqli_query($link, $sqlquery);
                        while ($row = mysqli_fetch_array($kursantet)) { 

                            $idKlase = $row['idklase'];
                            $sqlKlasa = "SELECT * FROM klasa where ID = '$idKlase';";
                            $klasa = mysqli_query($link, $sqlKlasa);
                            $rowKlasa = mysqli_fetch_array($klasa);
                            
                            $idInstruktori = $row['idinstruktori'];
                            $sqlInstruktori = "SELECT * FROM staf where ID =  '$idInstruktori';";
                            $instruktori = mysqli_query($link, $sqlInstruktori);
                            $rowInstruktori = mysqli_fetch_array($instruktori);
                            ?> 

                        <td><?php echo $rowKlasa['Emri']; ?></td>
                        <td><?php echo $rowInstruktori['Emri']; ?>  <?php echo $rowInstruktori['Mbiemri']; ?></td>
                        <td><?php echo $row['orari']; ?></td>
                        <td><?php echo $row['data']; ?></td>
                        <td class="text-left"><button onclick="location.href = '../php/ndryshoplanifikim.php?id=<?php echo $row['idkursi'];?>'" >Modifiko</button></td>
                    </tr> 
                    <?php } ?>
                </table>

        </div>
    </div>
</body>
</html>