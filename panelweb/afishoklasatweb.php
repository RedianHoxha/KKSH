
<?php
require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');
//$link = mysqli_connect("localhost", "root", "", "kksh");
if (!$link) {
  die('Could not connect: ' . mysqli_error($con));
}

$dataZgjedhur = $_GET['data'];
$city = $_GET['id'];
$isSunday;

$timestamp = strtotime($dataZgjedhur);
$weekday= date("l", $timestamp );
$normalized_weekday = strtolower($weekday);
if ($normalized_weekday == "sunday") {
  $isSunday = true;
} else {
  $isSunday = false;
}

$sqlqyeti = "SELECT * FROM qyteti WHERE EmriDeges = '$city';";
$resultqyteti = mysqli_query($link,$sqlqyeti);
$rowqyteti = mysqli_fetch_array($resultqyteti);
$cityId = $rowqyteti['IDQyteti'];

$klasparaditeid = array();
$klasparaditenrnr = 0;

$klasmesditid = array();
$klasmesditnr = 0;

$klaspasditeid = array();
$klaspasditenr = 0;

$klasdiele = array();
$klasdieleenr = 0;


mysqli_select_db($link,"ajax_demo");

if($isSunday){
  $sqlklasadiele = "SELECT * FROM programijavor WHERE orari='09:00 - 15:00' AND  data='$dataZgjedhur' AND idklase IN (SELECT ID FROM klasa WHERE Qyteti = $cityId)";
  echo $sqlklasadiele;
  $resultklasadiele = mysqli_query($link,$sqlklasadiele);
  while($rowklasadiele = mysqli_fetch_array($resultklasadiele))
      {
        $klasdiele[$klasdieleenr] = $rowklasadiele['idklase'];
        $klasdieleenr += 1;
      }

      echo $klasdieleenr;
}else{
  $sqlklasaparadite = "SELECT * FROM programijavor WHERE orari='9:00 - 13:00' AND  data='$dataZgjedhur' AND idklase IN (SELECT ID FROM klasa WHERE Qyteti = $cityId)";
  $resultklasaparadite = mysqli_query($link,$sqlklasaparadite);
  while($rowklasaparadite = mysqli_fetch_array($resultklasaparadite))
      {
        $klasparaditeid[$klasparaditenrnr] = $rowklasaparadite['idklase'];
        $klasparaditenrnr += 1;
      }

  $sqlklasamesdit = "SELECT * FROM programijavor WHERE orari='13:00 - 17:00' AND  data='$dataZgjedhur' AND idklase IN (SELECT ID FROM klasa WHERE Qyteti = $cityId)";
  $resultklasamesdit = mysqli_query($link,$sqlklasamesdit);
  while($rowklasamesdit = mysqli_fetch_array($resultklasamesdit))
      {
        $klasmesditid[$klasmesditnr] = $rowklasamesdit['idklase'];
        $klasmesditnr += 1;
      }

  $sqlklasapasdite = "SELECT * FROM programijavor WHERE orari='17:00 - 21:00' AND  data='$dataZgjedhur' AND idklase IN (SELECT ID FROM klasa WHERE Qyteti = $cityId)";
  $resultklasapasdite = mysqli_query($link,$sqlklasapasdite);
  while($rowklasapasdite = mysqli_fetch_array($resultklasapasdite))
      {
        $klaspasditeid[$klaspasditenr] = $rowklasapasdite['idklase'];
        $klaspasditenr += 1;
      }
}


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
 if(!$isSunday){
    $sqlquery="SELECT * FROM organizimkursantesh1 WHERE statusi ='pabere' AND idkursi IN (SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '9:00 - 13:00')";
    if($klasparaditenrnr>0){
      $result = mysqli_query($link,$sqlquery);
            $max = $klasparaditenrnr * 12;
            $registered = mysqli_num_rows($result);
            if( $registered< $max){
            $mbetje = $registered / 12;

                if($mbetje < 1 ){
                    $idKlase = $klasparaditeid[0];
                }else if($mbetje >= 1 && $mbetje < 2){
                    $idKlase = $klasparaditeid[1];
                }else if($mbetje >= 2 && $mbetje < 3){
                    $idKlase = $klasparaditeid[2];
                }else{
                    $idKlase = $klasparaditeid[3];
                }

                $selectidkursi = "SELECT idkursi FROM programijavor WHERE idklase = $idKlase AND data = '$dataZgjedhur' AND orari = '9:00 - 13:00'";
                $resultkursi = mysqli_query($link,$selectidkursi);
                $rowkursi= mysqli_fetch_array($resultkursi);
                if($rowkursi>0){
                ?>
                    <td class="text-left" style="text-align: center;">9:00 - 13:00</td>
                    <td class="text-left" style="text-align: center;"><?php echo $dataZgjedhur ?></td>
                    <td class="text-left" style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowkursi['idkursi'] ?>"required>Zgjidh</input></td>
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
              <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka kurs ne orarin 9:00 - 13:00!!</td></tr>
            <?php
        }

        $sqlquerymesdit="SELECT * FROM organizimkursantesh1 WHERE statusi ='pabere' AND idkursi IN (SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '13:00 - 17:00')";
        if($klasmesditnr>0){
          $resultmesdit = mysqli_query($link,$sqlquerymesdit);
          $max = $klasmesditnr * 12;
        if(mysqli_num_rows($resultmesdit) < $max){

            $registered = mysqli_num_rows($resultmesdit);
            $mbetje = $registered / 12;
            if($mbetje < 1 ){
                $idKlase = $klasmesditid[0];
            }else if($mbetje >= 1 && $mbetje < 2){
                $idKlase = $klasmesditid[1];
            }else if($mbetje >= 2 && $mbetje < 3){
                $idKlase = $klasmesditid[2];
            }else{
                $idKlase = $klasmesditid[3];
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
              <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka kurs ne orarin 13:00 - 17:00!</td></tr>
            <?php
        }

        $sqlquerymbasdite="SELECT * FROM organizimkursantesh1 WHERE statusi ='pabere' AND idkursi IN (SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '17:00 - 21:00')";
        if($klaspasditenr>0){
          $resultbasdite = mysqli_query($link,$sqlquerymbasdite);
          $max = $klaspasditenr * 12;
        if(mysqli_num_rows($resultbasdite) < $max){

            $registered = mysqli_num_rows($resultbasdite);
            $mbetje = $registered / 12;
            if($mbetje < 1 ){
                $idKlase = $klaspasditeid[0];
            }else if($mbetje >= 1 && $mbetje < 2){
                $idKlase = $klaspasditeid[1];
            }else if($mbetje >= 2 && $mbetje < 3){
                $idKlase = $klaspasditeid[2];
            }else{
                $idKlase = $klaspasditeid[3];
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
              <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka kurs ne orarin 17:00 - 21:00!</td></tr>
            <?php
        }
      }else{

        $sqlquerydiele="SELECT * FROM organizimkursantesh1 WHERE statusi ='pabere' AND idkursi IN (SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari ='09:00 - 15:00')";
        if($klasdieleenr>0){
            $resultdiele = mysqli_query($link,$sqlquerydiele);
            $max = $klasdieleenr * 12;
          if(mysqli_num_rows($resultdiele) < $max){

              $registered = mysqli_num_rows($resultdiele);
              echo $registered ."tes";
              $mbetje = $registered / 12;
              echo $mbetje . "testtt";
              if($mbetje < 1 ){
                  $idKlase = $klasdiele[0];
              }else if($mbetje >= 1 && $mbetje < 2){
                  $idKlase = $klasdiele[1];
              }else if($mbetje >= 2 && $mbetje < 3){
                $idKlase = $klasdiele[2];
              } else{
                  $idKlase = $klasdiele[3];
              }
              echo $idKlase . "Idklase";
              echo $klasdiele[0] ."Testststststst" .$klasdiele[1];
                  $selectidkursidiele = "SELECT idkursi FROM programijavor WHERE idklase = $idKlase AND data = '$dataZgjedhur' AND orari = '09:00 - 15:00'";
                  $resultkursidiele = mysqli_query($link,$selectidkursidiele);
                    $rowkursidiele= mysqli_fetch_array($resultkursidiele);
                    if($rowkursidiele > 0){
                    ?>
                        <td class="text-left" style="text-align: center;">09:00 - 15:00</td>
                        <td class="text-left" style="text-align: center;"><?php echo $dataZgjedhur ?></td>
                        <td class="text-left " style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowkursidiele['idkursi'] ?>"required>Zgjidh<?php echo $rowkursidiele['idkursi'] ?></input></td>
                    </tr>
                    <?php 
                }else{
                    ?>
                    <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka kurs ne orarin 09:00 - 15:00!</td></tr>
                    <?php
                }}
        else{
            ?>
              <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka vende te lira ne orarin 09:00 - 15:00!</td></tr>
            <?php
        }
    }else{
            ?>
              <td class="text-left" colspan="3" style="text-align: center">Per daten qe ju keni zgjedhur nuk ka kurs!</td></tr>
            <?php
        }
      }
 ?>   
</table>
</body>