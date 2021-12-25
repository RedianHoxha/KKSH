<?php
session_start();
$user=$_SESSION['user'];
$iduseri = $_SESSION['UserID'];
$link = mysqli_connect("localhost", "root", "", "kksh");

$query = "select * from staf where ID = '$iduseri';";
$kursantet=mysqli_query($link, $query);
$row = mysqli_fetch_array($kursantet);
$dega = $row['Degakupunon'];


if($row['Roli'] <> "Inputer")
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
}

$idPlanifikimi = $_GET['id'];
$planifikim  = "Select * from programijavor where idkursi = ?";
$stmt = mysqli_stmt_init($link);
if(!mysqli_stmt_prepare($stmt,$planifikim))
{
    echo  'Prove e deshtuar';
}
else
{
    mysqli_stmt_bind_param($stmt, "s" ,$idPlanifikimi);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row =mysqli_fetch_assoc($result);
    $idInstruktori = $row['idinstruktori'];
    $idKlase = $row['idklase'];
    $idOrarikursit = $row['data'];
}
?>

<!DOCTYPE html>
<head>
    <title>Kryqi i Kuq Shqiptar</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Admindege_Stilizime.css" />
</head>
<body>
    
<button onclick="location.href = '../admin/Admindege.php';" id="myButton" > Ktheu</button>
<button onclick="location.href = '../Authenticate/Logout.php';" id="myButton" > Dil <?php echo $user ?></button><br>
<img src="../Images/KKSH_logo.PNG" alt="Simply Easy Learning" id="KKSH_logo">
    <p id="welcome">Welcome</p><br>
    <div id="form">
        <form action="../DAO/modifikotimetable.php?edit=<?php echo $idPlanifikimi ?>" method="POST">
            <div id="instruktori">
                <label for="instruktori">Instruktori:</label>
                    <select id="instruktori" name="instruktori" style="width:15%;">
                    <?php 
                       $sqlqueryinstruktori="Select * from staf where Degakupunon = '$dega'";
                        $instruktoret=mysqli_query($link, $sqlqueryinstruktori);
                        while ($row = mysqli_fetch_array($instruktoret)) { 
                            ?>
                            <option value="<?php echo $row['ID']; ?>"><?php echo $row['Emri']?> <?php echo $row['Mbiemri']?></option>
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
                    <option value="<?php echo $row['ID']; ?>"><?php echo $row['Emri']?></option>
                    <?php } ?>
                    </select>
            </div>
            <div id="datakursit">
                <p id="datakursit">Data dhe Orari i Kursit</p>
                <input class="input100" id="datakursit" type="date" name="datakursit" value="<?php echo  $idOrarikursit; ?>"><br>

                <label for="orari"></label>
                <select id="orari" name="orari" style="width:15%;">
                  <option value="paradite">9-1</option>
                  <option value="mesdite">1-5</option>
                  <option value="mbasdite">5-9</option>

                </select>
        </div><br>  
            <div>
                <button type="submit" id="save-button">Modifiko</button>
            </div> 
       </form>
    </div>
</body>
</html>