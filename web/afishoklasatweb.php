
<?php
$link = mysqli_connect("localhost", "root", "", "kksh");
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
<table id="tabela-kursanteve" >
  <tr>
    <th>Te rregjistruar ne kete kurs</th>
    <th>Kapaciteti i Klases</th>
    <th>Orari</th>
    <th>Zgjidh</th>
  </tr>
  <tr>
  <?php 
  $sqlquery="SELECT * FROM programijavor WHERE data = '$dataZgjedhur' AND idklase in (SELECT id FROM klasa WHERE  qyteti = '$cityId');";

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
    
             $kursanteneKurs = "select Count(organizimkursantesh1.idkursi) as Sasia from organizimkursantesh1 where organizimkursantesh1.statusi = 'pabere' and organizimkursantesh1.idkursi = '$idKursi';";
             $resultKursante = mysqli_query($link,$kursanteneKurs);
             $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
    
             $kursantet = $rowKasiKursantesh['Sasia'];

             if($kapacitetiKlases > $kursantet)
             {
            ?>
                <td class="text-left"><?php echo $kursantet ?></td>
                <td class="text-left" style="text-align: center;"><?php echo $kapacitetiKlases ?></td>
                <td class="text-left" style="text-align: center;"><?php echo $orariKursit ?></td>
                <td class="text-left" style="text-align: center;"><input type="radio" name="select" value="<?php echo $idKursi ?>">Choose</radio></td>
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