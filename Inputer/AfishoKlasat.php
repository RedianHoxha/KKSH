
<?php
//$link = mysqli_connect("localhost", "root", "", "kksh");
require_once('../php/extra_function.php');
include('../Authenticate/dbconnection.php');
if (!$link) {
  die('Could not connect: ' . mysqli_error($con));
}

$dataZgjedhur = $_GET['data'];
$idDeges = $_GET['id'];
mysqli_select_db($link,"ajax_demo");

?>
<!DOCTYPE html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>
<body>
<table id="tabela-kursanteve" class="table table-bordered" >
  <tr>
    <th>Emri Klases</th>
    <th>Te rregjistruar</th>
    <th>Kapaciteti</th>
    <th>Orari</th>
    <th>Zgjidh</th>
  </tr>
  <tr>
  <?php 
  $sqlquery="SELECT * FROM programijavor WHERE data = '$dataZgjedhur' AND idklase in (SELECT id FROM klasa WHERE  qyteti = '$idDeges');";

  if($result = mysqli_query($link,$sqlquery))
      {
        if(mysqli_num_rows($result) != 0)
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
            ?>
                <td class="text-left"><?php echo decrypt($emriKlases) ?></td>
                <td class="text-left"><?php echo $kursantet ?></td>
                <td class="text-left"><?php echo $kapacitetiKlases ?></td>
                <td class="text-left"><?php echo $orariKursit ?></td>
                <td class="text-left"><input type="radio" name="select" value="<?php echo $idKursi ?>">Choose</radio></td>
              </tr>
            <?php 
            }
        }
        else
        {
          ?>
              <td class="text-left" colspan="7" style="text-align:center">Per daten qe ju keni zgjedhur nuk ka vende te lira! Ju lutem zgjidhni nje date tjeter</td> </tr>
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