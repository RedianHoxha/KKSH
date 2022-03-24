
<?php
$link = mysqli_connect("localhost", "root", "", "kksh");
if (!$link) {
  die('Could not connect: ' . mysqli_error($con));
}
require_once('../php/extra_function.php');

$dataZgjedhur = $_GET['data'];
$city = $_GET['id'];

$sqlqyeti = "SELECT * FROM qyteti WHERE EmriDeges = '$city';";
$resultqyteti = mysqli_query($link,$sqlqyeti);
$rowqyteti = mysqli_fetch_array($resultqyteti);
$cityId = $rowqyteti['IDQyteti'];

$klasid = array();
$klasnr = 0;

$sqlklasa = "SELECT * FROM klasa WHERE Qyteti = $cityId;";
$resultklasa = mysqli_query($link,$sqlklasa);
while($rowklasa = mysqli_fetch_array($resultklasa))
          {
            $klasid[$klasnr] = $rowklasa['ID'];
            $klasnr += 1;
          }

mysqli_select_db($link,"ajax_demo");

?>
<!DOCTYPE html>
<body>
<table id="tabela-kursanteve" class="table" >
    <thead>
  <tr class="table-light">
    <th>Orari</th>
    <th>Data</th>
    <th>Zgjidh</th>
  </tr>
    </thead>
  <tr>
  <?php 
 
    $sqlquery="SELECT COUNT(*) FROM organizimkursantesh1 WHERE statusi ='pabere' AND idkursi IN (SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '9:00 - 13:00')";
 
    if($result = mysqli_query($link,$sqlquery)){

            if(mysqli_num_rows($result)< 37){

            $registered = mysqli_num_rows($result);
            $mbetje = $registered / 12;

                if($mbetje <= 1 ){
                    $idKlase = $klasid[0];
                }else if($mbetje > 1 && $mbetje <= 2){
                    $idKlase = $klasid[1];
                }
                else{
                    $idKlase = $klasid[2];
                }
                $selectidkursi = "SELECT idkursi FROM programijavor WHERE idklase = $idKlase AND data = '$dataZgjedhur' AND orari = '9:00 - 13:00'";
                $resultkursi = mysqli_query($link,$selectidkursi);
                $rowkursi= mysqli_fetch_array($resultkursi);
                if($rowkursi>0){
                ?>
                    <td class="text-left" style="text-align: center;">9:00 - 13:00</td>
                    <td class="text-left" style="text-align: center;"><?php echo $dataZgjedhur ?></td>
                    <td class="text-left " style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowkursi['idkursi'] ?>"required>Zgjidh</input></td>
                </tr>
                <?php 
                }else{
                    ?>
                    <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka kurs ne orarin 9:00 - 13:00!</td></tr>
                    <?php
                }}
                else{
                ?>
                <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka vende te lira ne orarin 9:00 - 13:00!</td></tr>
                <?php
                }}else{
            ?>
              <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk kurs ne orarin 9:00 - 13:00!!</td></tr>
            <?php
        }

        $sqlquerymesdit="SELECT COUNT(*) FROM organizimkursantesh1 WHERE statusi ='pabere' AND idkursi IN (SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '13:00 - 17:00')";
        if($resultmesdit = mysqli_query($link,$sqlquerymesdit)){
        if(mysqli_num_rows($resultmesdit) < 37){

            $registered = mysqli_num_rows($result);
            $mbetje = $registered / 12;
            if($mbetje <= 1 ){
                $idKlase = $klasid[0];
            }else if($mbetje > 1 && $mbetje <= 2){
                $idKlase = $klasid[1];
            }
            else{
                $idKlase = $klasid[2];
            }
                $selectidkursidrek = "SELECT idkursi FROM programijavor WHERE idklase = $idKlase AND data = '$dataZgjedhur' AND orari = '13:00 - 17:00'";
                $resultkursidrek = mysqli_query($link,$selectidkursidrek);
                    $rowkursidrek= mysqli_fetch_array($resultkursidrek);
                    if($rowkursidrek > 0){
                    ?>
                        <td class="text-left" style="text-align: center;">13:00 - 17:00</td>
                        <td class="text-left" style="text-align: center;"><?php echo $dataZgjedhur ?></td>
                        <td class="text-left " style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowkursidrek['idkursi'] ?>"required>Zgjidh</input></td>
                    </tr>
                    <?php 
                }else{
                    ?>
                    <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka kurs ne orarin 13:00 - 17:00!</td></tr>
                    <?php
                }}
        else{
            ?>
              <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka vende te lira ne orarin 13:00 - 17:00!</td></tr>
            <?php
        }
    }else{
            ?>
              <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk kurs ne orarin 13:00 - 17:00!</td></tr>
            <?php
        }

        $sqlquerymbasdite="SELECT COUNT(*) FROM organizimkursantesh1 WHERE statusi ='pabere' AND idkursi IN (SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '17:00 - 21:00')";
        if($resultbasdite = mysqli_query($link,$sqlquerymbasdite)){
        if(mysqli_num_rows($resultbasdite) < 37){

            $registered = mysqli_num_rows($result);
            $mbetje = $registered / 12;
            if($mbetje <= 1 ){
                $idKlase = $klasid[0];
            }else if($mbetje > 1 && $mbetje <= 2){
                $idKlase = $klasid[1];
            }
            else{
                $idKlase = $klasid[2];
            }
                $selectidkursimbasdit = "SELECT idkursi FROM programijavor WHERE idklase = $idKlase AND data = '$dataZgjedhur' AND orari = '17:00 - 21:00'";
                $resultkursimbasdi = mysqli_query($link,$selectidkursimbasdit);
                $rowkursimbasdit= mysqli_fetch_array($resultkursimbasdi);
                if($rowkursimbasdit>0){
            ?>
                <td class="text-left" style="text-align: center;">17:00 - 21:00</td>
                <td class="text-left" style="text-align: center;"><?php echo $dataZgjedhur ?></td>
                <td class="text-left " style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowkursimbasdit['idkursi'] ?>"required>Zgjidh</input></td>
              </tr>
              <?php 
                }else{
                    ?>
                    <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka kurs ne orarin 13:00 - 17:00!</td></tr>
                    <?php
                }}
        else{
            ?>
              <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka vende te lira ne orarin 17:00 - 21:00!</td></tr>
            <?php
        }
        }else{
            ?>
              <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk kurs ne orarin 17:00 - 21:00!</td></tr>
            <?php
        }

      // }   
    //   else 
    //   {
    //     echo "<script>
    //     alert('Something went wrong! Try again!');
    //     window.location.href='webpage.php';
    //     </script>";
    //   }
 ?>   
</table>
</body>