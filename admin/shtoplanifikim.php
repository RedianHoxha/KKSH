<?php 
            session_start();           
            require_once('../php/extra_function.php');
            $user=$_SESSION['user'];
            $iduseri = $_SESSION['UserID'];
            $link = mysqli_connect("localhost", "root", "", "kksh");
    
            $query = "select * from staf where ID = '$iduseri';";
            $staf=mysqli_query($link, $query);
            $row = mysqli_fetch_array($staf);
            $dega = $row['Degakupunon'];

            if(decrypt($row['Roli']) <> "Admindege")
            {
                echo "<script>
                alert('You don't have access to see this page! Session Failed!');
                window.location.href='../html/homepage.html';
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
    <link rel="stylesheet" type="text/css" href="../css/admindegestilizime.css" />
</head>
<body>
    
<button onclick="location.href = '../admin/admindege.php';" id="myButton" > Ktheu</button>
<button onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo decrypt($user) ?></button><br>
    <img src="../images/kkshlogo.PNG" alt="Simply Easy Learning" id="KKSH_logo">
    <p id="welcome">Welcome</p><br>
    <div id="form">
        <form action="../dao/rregjistrotimetable.php" method="POST">
            <div id="instruktori">
                <label for="instruktori">Instruktori:</label>
                    <select id="instruktori" name="instruktori" style="width:15%;">
                    <?php 
                        $roli = encryptValues("Instruktor");
                        $sqlqueryinstruktori="Select * from staf where Degakupunon = '$dega' and Roli ='$roli'";
                        $instruktoret=mysqli_query($link, $sqlqueryinstruktori);
                        while ($row = mysqli_fetch_array($instruktoret)) { 
                    ?>
                    <option value="<?php echo $row['ID']; ?>"><?php echo decrypt($row['Emri'])?> <?php echo decrypt($row['Mbiemri'])?></option>
                    <?php } ?>
                    </select>
            </div>
            <br>
            <div id="klasa">
                <label for="klasa">Klasa:</label>
                    <select id="klasa" name="klasa" style="width:15%;">
                    <?php 
                        $sqlklasa="Select * from klasa where Qyteti = '$idqyteti'";
                        $klasa=mysqli_query($link, $sqlklasa);
                        while ($row = mysqli_fetch_array($klasa)) { 
                    ?>
                    <option value="<?php echo $row['ID']; ?>"><?php echo decrypt($row['Emri'])?></option>
                    <?php } ?>
                    </select>
            </div>
            <div id="datakursit">
                <p id="datakursit">Data dhe Orari i Kursit</p>
                <input class="input100" id="datakursit" type="date" name="datakursit" required><br>

                <label for="orari"></label>
                <select id="orari" name="orari" style="width:15%;" required>
                  <option value="9:00 - 13:00">9:00 - 13:00</option>
                  <option value="13:00 - 17:00">13:00 - 17:00</option>
                  <option value="17:00 -21:00">17:00 -21:00</option>

                </select>
        </div><br>  
            <div>
                <button type="submit" id="save-button">Rregjistro</button>
            </div> 
       </form>
    </div>
</body>
</html>