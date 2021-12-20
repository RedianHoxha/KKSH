<?php 
        session_start();
        $user=$_SESSION['user'];
        $iduseri = $_SESSION['UserID'];
        $link = mysqli_connect("localhost", "root", "", "kksh");
        
        $query = "select * from staf where ID = '$iduseri';";
        $kursantet=mysqli_query($link, $query);
        $row = mysqli_fetch_array($kursantet);
        $degastafit = $row['Degakupunon'];
    
        if($row['Roli'] <> "Inputer")
        {
            echo "<script>
            alert('You don't have access to see this page! Session Failed!');
            window.location.href='../HTML/Homepage.html';
            </script>";
        }
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
}?>


<!DOCTYPE html>
<head>
    <title>Kryqi i Kuq Shqipetar</title>
    <link href='../CSS/Inputerstyle.css' rel='stylesheet' />

        <script>
            function showclass(str) 
            {
                document.getElementById("txtHint").innerHTML = str;
                var data = str.toString();
                if (str == "") 
                {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                } else 
                {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() 
                    {
                        if (this.readyState == 4 && this.status == 200) 
                        {
                            document.getElementById("txtHint").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET","AfishoKlasat.php?data="+str,true);
                    xmlhttp.send();
                }
            }
        </script>
</head>
<body>
    <div id="top-page">
        <button onclick="location.href = '../Inputer/BejNdryshime.php';" id="myButton" >Bej ndryshime</button>
        <button onclick="location.href = '../Authenticate/Logout.php';" id="myButton" > Dil <?php echo $user ?></button>
    </div>
    <div id="Form">
            <form action="../PHP/Rregjistro.php" method="POST">
                <div id="hello">
                    <p id="hello-p">Welcome :)</p>
                </div>
                <div id="emri">
                    <p id="emri">Emri</p>
                    <input class="input100" id="emri-txt" type="text" 
                    name="emri-txt" placeholder="Emri" autocomplete="off"><br>

                    <p id="atesia">Atesia</p>
                    <input class="input100" id="atesia-txt" type="text" 
                    name="atesia-txt" placeholder="Atesia" autocomplete="off">

                    <p id="mbiemri">Mbiemri</p>
                    <input class="input100" id="mbiemri-txt" type="text" 
                    name="mbiemri-txt" placeholder="Mbiemri" autocomplete="off"><br>
                </div>
                <div id="id">
                    <p id="id">ID Personale</p>
                    <input class="input100" id="id-txt" type="text" 
                    name="id-txt" placeholder="ID" autocomplete="off">
                </div><br>
                <div id="datvendlindje">
                    <p id="datelindja">Datelindja</p>
                    <input class="input100" id="datelindja-txt" type="date" name="datelindja-txt">

                    <p id="vendbanim">Venbanim</p>
                    <input class="input100" id="vendbanim-txt" type="text" 
                    name="vendbanim-txt" placeholder="Adresa ku banon" autocomplete="off">
                </div>
                <div id="tel">
                    <p id="telefoni">Telefoni</p>
                    <input class="input100" id="tel-txt" type="number" 
                    name="tel-txt" placeholder="Telefoni" autocomplete="off">
                </div><br>
                <div id="datakursit">
                        <p id="datakursit">Data dhe Orari i Kursit<span style="color:red">   Kontrollo orarin para se te besh rregjistrimin</span></p>
                        <input class="input100" id="datakursit" type="date" name="datakursit" onchange="showclass(this.value)"><br>
                        <div id="txtHint"></div>
                </div>
                <div id="idkursi">
                    <p id="idkursi">Id kursit ku do rregjistrohet kursanti</p>
                    <input class="input100" id="idkursi" type="number" 
                    name="idkursi" placeholder="ID Kursi" autocomplete="off">
                </div><br>
                <div>
                    <button type="submit" id="rregjistro-button">Rregjistro</button>
                </div>    
        </form>
    </div>
</body>
</html>
