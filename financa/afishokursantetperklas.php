<?php
//$link = mysqli_connect("localhost", "root", "", "kksh");
require_once('../methods/extra_function.php');
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
        <table id="tabela-kursanteve" class="table table-striped table-bordered table-sm">
            <tr>
                <th>ID</th>
                <th>Emri</th>
                <th>Mbiemri</th>
                <th>Atesia</th>
                <th>Telefoni</th>
                <th>Banka</th>
                <th>Referenca e Pageses</th>
                <th>Data Rregjistrimit</th>
            </tr>
            <tr>
                <?php 
                $queryklasa ="SELECT * FROM klasa WHERE Emri = '$klasa'";
                $klasa=mysqli_query($link, $queryklasa);
                $rowklasa = mysqli_fetch_array($klasa);
                $idklase = $rowklasa['ID'];

                $sqlquery="SELECT * FROM `kursantet` WHERE Statusi='pabere' AND Datakursit = '$dataKursit' AND Orari = '$orari' AND IdKursi IN (SELECT IdKursi FROM programijavor WHERE idklase =$idklase);";
                $kursantet=mysqli_query($link, $sqlquery);
                while ($row = mysqli_fetch_array($kursantet)) { ?>
                    <td class="text-left"><?php echo decrypt($row['PersonalId']); ?></td>
                    <td class="text-left"><?php echo decrypt($row['Emri']); ?></td>
                    <td class="text-left"><?php echo decrypt($row['Mbiemri']); ?></td>
                    <td class="text-left"><?php echo decrypt($row['Atesia']); ?></td>
                    <td class="text-left"><?php echo $row['Telefoni']; ?></td>
                    <td class="text-left"><?php echo $row['BankName']; ?></td>
                    <td class="text-left"><?php echo $row['BankPayment']; ?></td>
                    <td class="text-left"><?php echo $row['DataRregjistrimit']; ?></td>
                </tr>
            <?php } ?>
        </table>        
    </body>
</html>