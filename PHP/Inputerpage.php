<?php 
            
        //     session_start();
        //     include('session.php');
        //     $user=$_SESSION['user'];
        //     $link = mysqli_connect("localhost", "root", "", "kksh");
        //     //echo $user;

        //     $iduseri = $_SESSION['UserID'];
        //     $query = "select * from staf where ID = '$iduseri';";
        //     $kursantet=mysqli_query($link, $query);
        //     $row = mysqli_fetch_array($kursantet);
        //     echo $row['Roli'];
        //     if($row['Roli'] <> "Rregjistrues")
        //     {
        //         header('location: ../HTML/Homepage.html');
        //     }
    
        // if($link === false){
        //     die("ERROR: Could not connect. " . mysqli_connect_error());

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
        if($row['Roli'] <> "Inputer")
        {
            header('location: ../HTML/Homepage.html');
        }

    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
}?>


<!DOCTYPE html>
<head>
    <title>Kryqi i Kuq Shqipetar</title>
    <link href='../CSS/Inputerstyle.css' rel='stylesheet' />
</head>
<body>
    <div id="top-page">
        <button onclick="location.href = '../PHP/Bejndryshime.php';" id="myButton" >Bej ndryshime</button>
        <button onclick="location.href = '../PHP/Logout.php';" id="myButton" > Dil <?php echo $user ?></button>
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
                        <div id="dega">
                            <label for="dega">Dega e Kursantit:</label>
                            <select id="dega" name="dega" style="width:15%;">
                            <?php $sqlquery="Select * from qyteti";
                                    $qytetet=mysqli_query($link, $sqlquery);
                                    while ($row = mysqli_fetch_array($qytetet)) { ?>

                                <option value="<?php echo $row['EmriDeges']; ?>"><?php echo $row['EmriDeges']; ?></option>
                                <?php } ?>
                            </select>
                        </div> <br>
                        <div id="datakursit">
                                <p id="datakursit">Data dhe Orari i Kursit<span style="color:red">   Kontrollo orarin para se te besh rregjistrimin</span></p>
                                <input class="input100" id="datakursit" type="date" name="datakursit"><br>

                                <label for="orari"></label>
                                <select id="orari" name="orari" style="width:15%;">
                                  <option value="paradite">9-1</option>
                                  <option value="mesdite">1-5</option>
                                  <option value="mbasdite">5-9</option>
    
                                </select>
                        </div>
                        <div>
                            <button type="submit" id="rregjistro-button">Rregjistro</button>
                        </div>    
        </form>
    </div>
</body>
</html>
