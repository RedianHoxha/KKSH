
<?php
$link = mysqli_connect("localhost", "root", "", "kksh");
if (!$link) {
  die('Could not connect: ' . mysqli_error($con));
}

session_start();
$user=$_SESSION['user'];
$iduseri = $_SESSION['UserID'];

$datazgjedhur = $_GET['data'];


$query = "select * from staf where ID = '$iduseri';";
$kursantet=mysqli_query($link, $query);
$row = mysqli_fetch_array($kursantet);
$degastafit = $row['Degakupunon'];

mysqli_select_db($link,"ajax_demo");
$sql="SELECT * FROM programijavor WHERE data = '".$datazgjedhur."'";

if($result = mysqli_query($link,$sql))
    {
            while($row = mysqli_fetch_array($result)) {

                $idklase = $row['idklase'];
                $idkursi = $row['idkursi'];
                $orarikursit = $row['orari'];

                $sqlklasa = "select * from klasa where ID= '$idklase'; ";
                $resultklasa = mysqli_query($link,$sqlklasa);
                $rowklasa = mysqli_fetch_array($resultklasa);
                
                $emriklases = $rowklasa['Emri'];
                $kapacitetiklases = $rowklasa['Kapaciteti'];

                $kursantenekurs = "select Count(organizimkursantesh.idkursi) as Sasia from organizimkursantesh where organizimkursantesh.statusi = 'pabere' and organizimkursantesh.idkursi = '$idkursi';";
                $resultkursante = mysqli_query($link,$kursantenekurs);
                $rowsasikursantesh = mysqli_fetch_array($resultkursante);

                $kursantet = $rowsasikursantesh['Sasia'];

                echo "<table>
        <tr>
        <th>Emri Klases</th>
        <th>Te rregjistruar</th>
        <th>Kapaciteti</th>
        <th>Orari</th>
        <th>ID Kursi</th>

        </tr>";

        echo "<tr>";
        echo "<td>" . $emriklases . "</td>";
        echo "<td>" . $kursantet . "</td>";
        echo "<td>" . $kapacitetiklases . "</td>";
        echo "<td>" . $orarikursit. "</td>";
        echo "<td>" . $idkursi. "</td>";
        echo "</tr>";

        echo "</table>";
        //mysqli_close($link);

        }

}
else
{
    echo "Nuk ka kurse ne kete date";
}




?>