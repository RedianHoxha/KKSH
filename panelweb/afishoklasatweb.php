
<?php
require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');
//$link = mysqli_connect("localhost", "root", "", "kksh");
if (!$link) {
  die('Could not connect: ' . mysqli_error($con));
}

$dataZgjedhur = $_GET['data'];
$city = $_GET['id'];

$sqlqyeti = "SELECT * FROM qyteti WHERE EmriDeges = '$city';";
$resultqyteti = mysqli_query($link,$sqlqyeti);
$rowqyteti = mysqli_fetch_array($resultqyteti);
$cityId = $rowqyteti['IDQyteti'];

mysqli_select_db($link,"ajax_demo");

?>
<!DOCTYPE html>
<body>
<table id="tabela-kursanteve" class="table" >
    <thead>
  <tr class="table-light">
    <th>Te rregjistruar ne kete kurs</th>
    <th>Kapaciteti i Klases</th>
    <th>Klasa</th>
    <th>Orari</th>
    <th>Data</th>
    <th>Zgjidh</th>
  </tr>
    </thead>
  <tr>
  <?php 
  $sqlquery="SELECT * FROM programijavor WHERE data = '$dataZgjedhur' AND idklase IN (SELECT id FROM klasa WHERE  qyteti = '$cityId');";

  if($result = mysqli_query($link,$sqlquery))
      {
        if(mysqli_num_rows($result) > 0)
          {
          while($row = mysqli_fetch_array($result))
          {
             $idKlase = $row['idklase'];
             $idKursi = $row['idkursi'];
             $orariKursit = $row['orari'];
    
             $sqlKlasa = "select * from klasa where ID= '$idKlase';";
             $resultKlasa = mysqli_query($link,$sqlKlasa);
             $rowKlasa = mysqli_fetch_array($resultKlasa);
            
             $emriKlases = $rowKlasa['Emri'];
             $kapacitetiKlases = $rowKlasa['Kapaciteti'];
    
             $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi = '$idKursi';";
             $resultKursante = mysqli_query($link,$kursanteneKurs);
             $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
    
             $kursantet = $rowKasiKursantesh['Sasia'];

             if($kapacitetiKlases > $kursantet)
             {
            ?>
                <td class="text-left"><?php echo $kursantet ?></td>
                <td class="text-left" style="text-align: center;"><?php echo $kapacitetiKlases ?></td>
                <td class="text-left" style="text-align: center;"><?php echo decrypt($emriKlases) ?></td>
                <td class="text-left" style="text-align: center;"><?php echo $orariKursit ?></td>
                <td class="text-left" style="text-align: center;"><?php echo $dataZgjedhur ?></td>
                <td class="text-left " style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $idKursi ?>"required>Zgjidh</input></td>
              </tr>
            <?php 
            }
          }
        }
        else
        {
          ?>
              <td class="text-left" colspan="7" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka vende te lira! Ju lutem zgjidhni nje date tjeter</td>              </tr>
            <?php
        }
      }   
      else 
      {
        echo "<script>
        alert('Something went wrong! Try again!');
        window.location.href='webpage.php';
        </script>";
      }
 ?>   
</table>
</body>