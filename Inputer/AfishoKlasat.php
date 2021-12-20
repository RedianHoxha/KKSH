
<?php
$link = mysqli_connect("localhost", "root", "", "kksh");
if (!$link) {
  die('Could not connect: ' . mysqli_error($con));
}

session_start();
$user=$_SESSION['user'];
$idUseri = $_SESSION['UserID'];

$dataZgjedhur = $_GET['data'];

$query = "select * from staf where ID = '$idUseri';";
$kursantet=mysqli_query($link, $query);
$row = mysqli_fetch_array($kursantet);
$degaStafit = $row['Degakupunon'];

mysqli_select_db($link,"ajax_demo");
$sql="SELECT * FROM programijavor WHERE data = '".$dataZgjedhur."'";

if($result = mysqli_query($link,$sql))
    {
      while($row = mysqli_fetch_array($result)) {
        $idKlase = $row['idklase'];
        $idKursi = $row['idkursi'];
        $orariKursit = $row['orari'];

        $sqlKlasa = "select * from klasa where ID= '$idKlase'; ";
        $resultKlasa = mysqli_query($link,$sqlKlasa);
        $rowKlasa = mysqli_fetch_array($resultKlasa);
        
        $emriKlases = $rowKlasa['Emri'];
        $kapacitetiKlases = $rowKlasa['Kapaciteti'];

        $kursanteneKurs = "select Count(organizimkursantesh.idkursi) as Sasia from organizimkursantesh where organizimkursantesh.statusi = 'pabere' and organizimkursantesh.idkursi = '$idKursi';";
        $resultKursante = mysqli_query($link,$kursanteneKurs);
        $rowKasiKursantesh = mysqli_fetch_array($resultKursante);

        $kursantet = $rowKasiKursantesh['Sasia'];
        echo "<table>
              <tr>
              <th>Emri Klases</th>
              <th>Te rregjistruar</th>
              <th>Kapaciteti</th>
              <th>Orari</th>
              <th>ID Kursi</th>
              </tr>";

              echo "<tr>";
              echo "<td>" . $emriKlases . "</td>";
              echo "<td>" . $kursantet . "</td>";
              echo "<td>" . $kapacitetiKlases . "</td>";
              echo "<td>" . $orariKursit. "</td>";
              echo "<td>" . $idKursi. "</td>";
              echo "</tr>";
        echo "</table>";
    }
}
else
{
    echo "Nuk ka kurse ne kete date";
}
?>