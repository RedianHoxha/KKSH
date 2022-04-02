
<?php
//$link = mysqli_connect("localhost", "root", "", "kksh");
require_once('../php/extra_function.php');
include('../authenticate/dbconnection.php');
if (!$link) {
  die('Could not connect: ' . mysqli_error($con));
}

$klasa = encryptValues($_GET['klasa']);
$dataKursit = $_GET['data'];
$orari = $_GET['orari'];
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
    <th>NR.</th>
    <th>Data Rregjistrimit</th>
    <th>Antarsimi</th>
    <th>Emer</th>
    <th>Mbiemer</th>
    <th>Atesia</th>
    <th>Gjinia</th>
    <th>Adresa</th>
    <th>ID</th>
  </tr>
  <tr>
  <?php 

$queryklasa ="SELECT * FROM klasa WHERE Emri = '$klasa'";
$klasa=mysqli_query($link, $queryklasa);
$rowklasa = mysqli_fetch_array($klasa);
$idklase = $rowklasa['ID'];

  $sqlquery="SELECT * FROM `kursantet` WHERE Datakursit = '$dataKursit' AND Orari = '$orari' AND IdKursi IN (SELECT IdKursi FROM programijavor WHERE idklase =$idklase);";
  if($result = mysqli_query($link,$sqlquery))
      {
        if(mysqli_num_rows($result) != 0)
        {
            $nrRendor = 1;
          while($row = mysqli_fetch_array($result))
          {
            ?>
                <td class="text-left"><?php echo $nrRendor ?></td>
                <td class="text-left"><?php echo $row['DataRregjistrimit'] ?></td>
                <td class="text-left"><?php echo 'A' ?></td>
                <td class="text-left"><?php echo decrypt($row['Emri']) ?></td>
                <td class="text-left"><?php echo decrypt($row['Mbiemri']) ?></td>
                <td class="text-left"><?php echo decrypt($row['Atesia']) ?></td>
                <td class="text-left"><?php echo $row['Gjinia'] ?></td>
                <td class="text-left"><?php echo decrypt($row['Vendbanimi']) ?></td>
                <td class="text-left"><?php echo decrypt($row['PersonalId']) ?></td>
              </tr>
              
            <?php 
        $nrRendor = $nrRendor + 1;    
        }
        }
        else
        {
          ?>
              <td class="text-left" colspan="9" style="text-align:center">Per klasen qe keni zgjedhur ne kete date nuk eshte rregjistruar asnje kursant.Ju lutem zgjidhni nje date tjeter</td> </tr>
            <?php
        }
      }   
      else 
      {
        echo "<script>
        alert('Something went wrong! Try again!');
        window.location.href='inputerpage.php';
        </script>";
      }
 ?>   
</table>
</body>