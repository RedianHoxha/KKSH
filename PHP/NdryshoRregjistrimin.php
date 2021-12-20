<?php

session_start();
$user=$_SESSION['user'];
$iduseri = $_SESSION['UserID'];
$link = mysqli_connect("localhost", "root", "", "kksh");

$query = "select * from staf where ID = '$iduseri';";
$kursantet=mysqli_query($link, $query);
$row = mysqli_fetch_array($kursantet);
if($row['Roli'] <> "Inputer")
{
    echo "<script>
    alert('You don't have access to see this page! Session Failed!');
    window.location.href='../HTML/Homepage.html';
    </script>";
}

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
    
$idkursanti = $_GET['id'];

$kursanti = "select * from kursant where ID = ?;";
$stmt = mysqli_stmt_init($link);
if(!mysqli_stmt_prepare($stmt,$kursanti))
{
    echo  'Prove e deshtuar';
}
else
{
    mysqli_stmt_bind_param($stmt, "s" ,$idkursanti);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row =mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
    <head>
        <title>Kryqi i Kuq Shqipetar</title>
        <link href='../CSS/Inputerstyle.css' rel='stylesheet' />
    </head>
    <body>
        <div id="Form">
            <form action="../PHP/RuajNdryshimet.php" method="POST">
                <div id="hello">
                    <p id="hello-p">Welcome :)</p>
                </div>
                <div id="emri">
                    <p id="emri">Emri</p>
                    <input class="input100" id="emri-txt" type="text" 
                    name="emri-txt" value="<?php echo  $row['Emri']; ?>" ><br>

                    <p id="atesia">Atesia</p>
                    <input class="input100" id="atesia-txt" type="text" 
                    name="atesia-txt" value="<?php echo  $row['Atesia']; ?>" >

                    <p id="mbiemri">Mbiemri</p>
                    <input class="input100" id="mbiemri-txt" type="text" 
                    name="mbiemri-txt" value="<?php echo  $row['Mbiemri']; ?>" ><br>
                </div>
                <div id="id">
                    <p id="id">ID Personale</p>
                    <input class="input100" id="id-txt" type="text" 
                    name="id-txt" value="<?php echo  $row['ID']; ?>">
                </div><br>
                <div id="datvendlindje">
                    <p id="datelindja">Datelindja</p>
                    <input class="input100" id="datelindja-txt" type="date" name="datelindja-txt" value="<?php echo  $row['Datelindja']; ?>">

                    <p id="vendbanim">Venbanim</p>
                    <input class="input100" id="vendbanim-txt" type="text" 
                    name="vendbanim-txt" value="<?php echo  $row['Vendbanimi']; ?>">
                </div>
                <div id="tel">
                    <p id="telefoni">Telefoni</p>
                    <input class="input100" id="tel-txt" type="number" 
                    name="tel-txt" value="<?php echo  $row['Telefoni']; ?>">
                </div><br>
                <div id="datakursit">
                <p id="datakursit">Data dhe Orari i Kursit<span style="color:red">   Kontrollo orarin para se te besh rregjistrimin</span></p>
                <input class="input100" id="datakursit" type="date" name="datakursit" value="<?php echo  $row['Datakursit']; ?>"><br>

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