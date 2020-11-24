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
if($row['Roli'] <> "Konfirmues")
{
    header('location: ../HTML/Homepage.html');
}

if($link === false){
die("ERROR: Could not connect. " . mysqli_connect_error());
}

$idkursanti = $_GET['id'];
//echo $idkursanti;

$kursanti = "select * from kursant where ID = ?;";
//echo $kursanti;
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
            <form action="../PHP/RuajAmzenere.php" method="POST">
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
                                    <input class="input100" id="tel-txt" type="text" 
                                    name="tel-txt" value="<?php echo  $row['Telefoni']; ?>">
                                </div><br>
                                <div id="amza">
                                    <p id="amza">Amza (09-989-01)</p>
                                    <input class="input100" id="amza-txt" type="text" 
                                    name="amza-txt" placeholder="Amza" autocomplete="off">
                                </div>
                                <div id="deshmi">
                                    <p id="deshmi">Nr i Seris se Deshmise (070001)</p>
                                    <input class="input100" id="deshmi-txt" type="text" 
                                    name="deshmi-txt" placeholder="Nr Seris se Deshmis" autocomplete="off">
                                </div><br>
                                <div>
                                <button type="submit" id="rregjistro-button">Rregjistro</button>
                            </div> 
            </form>
        </div>
    </body> 
</html>