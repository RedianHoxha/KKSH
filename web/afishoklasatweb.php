
<?php
$link = mysqli_connect("localhost", "root", "", "kksh");
if (!$link) {
  die('Could not connect: ' . mysqli_error($con));
}

$dataZgjedhur = $_GET['data'];
mysqli_select_db($link,"ajax_demo");

?>
<!DOCTYPE html>
<body>
<table id="tabela-kursanteve" >
  <tr>
    <th>Emri Klases</th>
    <th>Te rregjistruar</th>
    <th>Kapaciteti</th>
    <th>Orari</th>
    <th>ID Kursi</th>
    <th>Zgjidh</th>
  </tr>
  <tr>
  <?php 
  $sql="SELECT * FROM programijavor WHERE data = '".$dataZgjedhur."'";

 //echo $sql;
  if($result = mysqli_query($link,$sql))
      {
      //  if(mysqli_fetch_array($result) > 0)
      //    {
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
    
             $kursanteneKurs = "select Count(organizimkursantesh.idkursi) as Sasia from organizimkursantesh where organizimkursantesh.statusi = 'pabere' and organizimkursantesh.idkursi = '$idKursi';";
             $resultKursante = mysqli_query($link,$kursanteneKurs);
             $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
    
             $kursantet = $rowKasiKursantesh['Sasia'];

             if($kapacitetiKlases > $kursantet)
             {
            ?>
                <td class="text-left"><?php echo $emriKlases ?></td>
                <td class="text-left"><?php echo $kursantet ?></td>
                <td class="text-left"><?php echo $kapacitetiKlases ?></td>
                <td class="text-left"><?php echo $orariKursit ?></td>
                <td class="text-left"><?php echo $idKursi ?></td>
                <td class="text-left"><input type="radio" name="select" value="<?php echo $idKursi ?>">Choose</radio></td>
              </tr>
            <?php 
            }
          }
        }
        else
        {
          ?>
              <td class="text-left" colspan="7" style="text-align:center">Per daten qe ju keni zgjedhur nuk ka vende te lira</td>              </tr>
            <?php
        }
      // }   
      // else 
      // {
      //   echo "<script>
      //   alert('Something went wrong! Try again!');
      //   window.location.href='webpage.php';
      //   </script>";
      // }
 ?>   
</table>
</body>