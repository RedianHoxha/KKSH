<?php
require_once ('../methods/extra_function.php');
include ('../authenticate/dbconnection.php');
if (!$link)
{
    die('Could not connect: ' . mysqli_error($con));
}

$dataZgjedhur = $_GET['data'];
$city = $_GET['id'];
$today = date('Y-m-d');
$isEarlierThanToday;
$isSunday;
$isWrongDate;

$timestamp = strtotime($dataZgjedhur);
$weekday = date("l", $timestamp);
$normalized_weekday = strtolower($weekday);
if ($normalized_weekday == "sunday" || $normalized_weekday == "saturday")
{
    $isSunday = true;
}
else
{
    $isSunday = false;
}

if ($normalized_weekday == "tuesday" || $normalized_weekday == "thursday")
{
    $isWrongDate = true;
}
else
{
    $isWrongDate = false;
}

if($dataZgjedhur < $today){
    $isEarlierThanToday = false;
}else{
    $isEarlierThanToday = true;
}

$sqlqyeti = "SELECT * FROM qyteti WHERE EmriDeges = '$city';";
$resultqyteti = mysqli_query($link, $sqlqyeti);
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

mysqli_select_db($link, "ajax_demo");

if ($isSunday)
{
    $sqlklasadiele = "SELECT * FROM programijavor WHERE orari='09:00 - 15:00' AND  data='$dataZgjedhur' AND idklase IN (SELECT ID FROM klasa WHERE Qyteti = $cityId)";
    $resultklasadiele = mysqli_query($link, $sqlklasadiele);
    while ($rowklasadiele = mysqli_fetch_array($resultklasadiele))
    {
        $klasdiele[$klasdieleenr] = $rowklasadiele['idklase'];
        $klasdieleenr += 1;
    }
}
else
{
    $sqlklasaparadite = "SELECT * FROM programijavor WHERE orari='9:00 - 13:00' AND  data='$dataZgjedhur' AND idklase IN (SELECT ID FROM klasa WHERE Qyteti = $cityId)";
    $resultklasaparadite = mysqli_query($link, $sqlklasaparadite);
    while ($rowklasaparadite = mysqli_fetch_array($resultklasaparadite))
    {
        $klasparaditeid[$klasparaditenrnr] = $rowklasaparadite['idklase'];
        $klasparaditenrnr += 1;
    }

    $sqlklasamesdit = "SELECT * FROM programijavor WHERE orari='13:00 - 17:00' AND  data='$dataZgjedhur' AND idklase IN (SELECT ID FROM klasa WHERE Qyteti = $cityId)";
    $resultklasamesdit = mysqli_query($link, $sqlklasamesdit);
    while ($rowklasamesdit = mysqli_fetch_array($resultklasamesdit))
    {
        $klasmesditid[$klasmesditnr] = $rowklasamesdit['idklase'];
        $klasmesditnr += 1;
    }

    $sqlklasapasdite = "SELECT * FROM programijavor WHERE orari='17:00 - 21:00' AND  data='$dataZgjedhur' AND idklase IN (SELECT ID FROM klasa WHERE Qyteti = $cityId)";
    $resultklasapasdite = mysqli_query($link, $sqlklasapasdite);
    while ($rowklasapasdite = mysqli_fetch_array($resultklasapasdite))
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
if($isEarlierThanToday){
   if (!$isSunday)
    {
        if (!$isWrongDate)
        {
            $sqlquery = "SELECT * FROM organizimkursantesh1 WHERE statusi ='pabere' AND idkursi IN (SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '9:00 - 13:00')";
            if ($klasparaditenrnr > 0)
            {

                $result = mysqli_query($link, $sqlquery);
                $max = $klasparaditenrnr * 12;
                $registered = mysqli_num_rows($result);
                if ($registered < $max)
                {
                    if ($registered < 13)
                    {
                        $idKlase = $klasparaditeid[0];
                    }
                    else if ($registered >= 13 && $registered < 25)
                    {
                        $idKlase = $klasparaditeid[1];

                        $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '9:00 - 13:00' AND idklase = '$klasparaditeid[0]');";
                        $resultKursante = mysqli_query($link, $kursanteneKurs);
                        $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                        $kursantetGjetur = $rowKasiKursantesh['Sasia'];
                        if ($kursantetGjetur < 13)
                        {
                            $idKlase = $klasparaditeid[0];
                        }

                    }
                    else if ($registered >= 25 && $registered < 37)
                    {
                        $idKlase = $klasparaditeid[2];
                        $kursanteneKurspare = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '9:00 - 13:00' AND idklase = '$klasparaditeid[0]');";
                        $resultKursantepare = mysqli_query($link, $kursanteneKurspare);
                        $rowKasiKursanteshpare = mysqli_fetch_array($resultKursantepare);
                        $kursantetGjeturpare = $rowKasiKursanteshpare['Sasia'];
                        if ($kursantetGjeturpare < 13)
                        {
                            $idKlase = $klasparaditeid[0];
                        }
                        else
                        {

                            $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '9:00 - 13:00' AND idklase = '$klasparaditeid[1]');";
                            $resultKursante = mysqli_query($link, $kursanteneKurs);
                            $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                            $kursantetGjetur = $rowKasiKursantesh['Sasia'];
                            if ($kursantetGjetur < 13)
                            {
                                $idKlase = $klasparaditeid[1];
                            }
                        }

                    }
                    else if ($registered >= 37 && $registered < 49)
                    {
                        $idKlase = $klasparaditeid[3];
                        $kursanteneKurspare = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '9:00 - 13:00' AND idklase = '$klasparaditeid[0]');";
                        $resultKursantepare = mysqli_query($link, $kursanteneKurspare);
                        $rowKasiKursanteshpare = mysqli_fetch_array($resultKursantepare);
                        $kursantetGjeturpare = $rowKasiKursanteshpare['Sasia'];
                        if ($kursantetGjeturpare < 13)
                        {
                            $idKlase = $klasparaditeid[0];
                        }
                        else
                        {

                            $kursanteneKursdyte = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '9:00 - 13:00' AND idklase = '$klasparaditeid[1]');";
                            $resultKursantedyte = mysqli_query($link, $kursanteneKursdyte);
                            $rowKasiKursanteshdyte = mysqli_fetch_array($resultKursantedyte);
                            $kursantetGjeturdyte = $rowKasiKursanteshdyte['Sasia'];
                            if ($kursantetGjeturdyte < 13)
                            {
                                $idKlase = $klasparaditeid[1];
                            }
                            else
                            {
                                $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '9:00 - 13:00' AND idklase = '$klasparaditeid[2]');";
                                $resultKursante = mysqli_query($link, $kursanteneKurs);
                                $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                                $kursantetGjetur = $rowKasiKursantesh['Sasia'];
                                if ($kursantetGjetur < 13)
                                {
                                    $idKlase = $klasparaditeid[2];
                                }
                            }
                        }
                    }

                    $selectidkursi = "SELECT idkursi FROM programijavor WHERE idklase = $idKlase AND data = '$dataZgjedhur' AND orari = '9:00 - 13:00'";
                    $resultkursi = mysqli_query($link, $selectidkursi);
                    $rowkursi = mysqli_fetch_array($resultkursi);
                    if ($rowkursi > 0)
                    {
    ?>
                        <td class="text-left" style="text-align: center;">9:00 - 13:00</td>
                        <td class="text-left" style="text-align: center;"><?php echo date('d/m/Y',strtotime($dataZgjedhur)) ?></td>
                        <td class="text-left" style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowkursi['idkursi'] ?>"required>Zgjidh</input></td>
                    </tr>
                    <?php
                    }
                    else
                    {
    ?>
                        <td class="text-left" colspan="3" style="text-align: center">Për datën që ju keni zgjedhur nuk ka kurs në orarin 9:00 - 13:00!</td></tr>
                        <?php
                    }
                }
                else
                {

                    $futureDate = date('Y-m-d', strtotime('+3 days', strtotime($dataZgjedhur)));
                    $testdate = date('Y-m-d', strtotime('+1 days', strtotime($dataZgjedhur)));
                    $selectpredictCourses = "SELECT idkursi FROM `programijavor` WHERE orari = '9:00 - 13:00' AND data BETWEEN '$testdate' AND '$futureDate' ORDER BY data";
                    $resultpredictionCourses = mysqli_query($link, $selectpredictCourses);
                    $row = mysqli_num_rows($resultpredictionCourses);
                    if ($row > 0)
                    {
                        $gjetur = 0;
                        while ($row = mysqli_fetch_array($resultpredictionCourses))
                        {
                            $idkursitmoment = $row['idkursi'];
                            $selectexistkursantperkurs = "SELECT COUNT(*) AS Totali FROM organizimkursantesh1 WHERE statusi='pabere' AND idkursi = $idkursitmoment";
                            $resultexistkursantperkurs = mysqli_query($link, $selectexistkursantperkurs);
                            $rowexistkursantperkurs = mysqli_fetch_array($resultexistkursantperkurs);
                            $totali = $rowexistkursantperkurs['Totali'];
                            if ($totali < 12)
                            {

                                $gjetur = 1;
                                $getdateklase = "SELECT * FROM programijavor WHERE idkursi = $idkursitmoment";
                                $resultdatakursit = mysqli_query($link, $getdateklase);
                                $rowKkursigjetur = mysqli_fetch_array($resultdatakursit);

                                $datakursitgjetur = $rowKkursigjetur['data'];
                                $orari = $rowKkursigjetur['orari'];

    ?>
                            <td class="text-left" style="text-align: center;"><?php echo $orari ?></td>
                            <td class="text-left" style="text-align: center;">Në datën qe ju keni zgjedhur nuk ka vende të lira pasi klasat janë mbushur.  Data më e afert për klasa të lira është : <?php echo date('d/m/Y',strtotime($datakursitgjetur)) ?></td>
                            <td class="text-left" style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowKkursigjetur['idkursi'] ?>"required>Zgjidh</input></td>
                            </tr>
                            <?php
                                break;
                            }
                        }
                        if ($gjetur != 1)
                        {
    ?>
                            <td class="text-left" colspan="3" style="text-align: center">Në datën qe ju keni zgjedhur dhe në 3 ditët në vazhdim nuk ka vende të lira!</td></tr>
                            <?php
                        }
                    }
                    else
                    {
    ?>
                        <td class="text-left" colspan="3" style="text-align: center">Në datën që ju keni zgjedhur dhe në 3 ditët në vazhdim nuk është planifikuar kurs në orarin 09:00 - 13:00!</td></tr>
                        <?php
                    }
                }
            }
            else
            {
                $futureDate = date('Y-m-d', strtotime('+3 days', strtotime($dataZgjedhur)));
                $testdate = date('Y-m-d', strtotime('+1 days', strtotime($dataZgjedhur)));
                $selectpredictCourses = "SELECT idkursi FROM `programijavor` WHERE orari = '9:00 - 13:00' AND data BETWEEN '$testdate' AND '$futureDate' ORDER BY data";
                $resultpredictionCourses = mysqli_query($link, $selectpredictCourses);
                $row = mysqli_num_rows($resultpredictionCourses);
                if ($row > 0)
                {
                    $gjetur = 0;
                    while ($row = mysqli_fetch_array($resultpredictionCourses))
                    {
                        $idkursitmoment = $row['idkursi'];
                        $selectexistkursantperkurs = "SELECT COUNT(*) AS Totali FROM organizimkursantesh1 WHERE statusi='pabere' AND idkursi = $idkursitmoment";
                        $resultexistkursantperkurs = mysqli_query($link, $selectexistkursantperkurs);
                        $rowexistkursantperkurs = mysqli_fetch_array($resultexistkursantperkurs);
                        $totali = $rowexistkursantperkurs['Totali'];
                        if ($totali < 12)
                        {

                            $gjetur = 1;
                            $getdateklase = "SELECT * FROM programijavor WHERE idkursi = $idkursitmoment";
                            $resultdatakursit = mysqli_query($link, $getdateklase);
                            $rowKkursigjetur = mysqli_fetch_array($resultdatakursit);

                            $datakursitgjetur = $rowKkursigjetur['data'];
                            $orari = $rowKkursigjetur['orari'];

    ?>
                            <td class="text-left" style="text-align: center;"><?php echo $orari ?></td>
                            <td class="text-left" style="text-align: center;">Në datën qe ju keni zgjedhur nuk ka vende të lira pasi klasat janë mbushur.  Data më e afert për klasa të lira është : <?php echo date('d/m/Y',strtotime($datakursitgjetur)) ?></td>
                            <td class="text-left" style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowKkursigjetur['idkursi'] ?>"required>Zgjidh</input></td>
                        </tr>
                        <?php
                            break;
                        }
                    }
                    if ($gjetur != 1)
                    {
    ?>
                            <td class="text-left" colspan="3" style="text-align: center">Në datën qe ju keni zgjedhur dhe në 3 ditët në vazhdim nuk ka vende të lira!</td></tr>
                        <?php
                    }
                }
                else
                {
    ?>
                    <td class="text-left" colspan="3" style="text-align: center">Në datën që ju keni zgjedhur dhe në 3 ditët në vazhdim nuk është planifikuar kurs në orarin 09:00 - 13:00!</td></tr>
                    <?php
                }

            }

            $sqlquerymesdit = "SELECT * FROM organizimkursantesh1 WHERE statusi ='pabere' AND idkursi IN (SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '13:00 - 17:00')";
            if ($klasmesditnr > 0)
            {
                $resultmesdit = mysqli_query($link, $sqlquerymesdit);
                $max = $klasmesditnr * 12;
                if (mysqli_num_rows($resultmesdit) < $max)
                {
                    $registered = mysqli_num_rows($resultmesdit);
                    if ($registered < 13)
                    {
                        $idKlase = $klasmesditid[0];
                    }
                    else if ($registered >= 13 && $registered < 25)
                    {
                        $idKlase = $klasmesditid[1];

                        $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '13:00 - 17:00' AND idklase = '$klasmesditid[0]');";
                        $resultKursante = mysqli_query($link, $kursanteneKurs);
                        $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                        $kursantetGjetur = $rowKasiKursantesh['Sasia'];
                        if ($kursantetGjetur < 13)
                        {
                            $idKlase = $klasmesditid[0];
                        }

                    }
                    else if ($registered >= 25 && $registered < 37)
                    {
                        $idKlase = $klasmesditid[2];
                        $kursanteneKurspare = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '13:00 - 17:00' AND idklase = '$klasmesditid[0]');";
                        $resultKursantepare = mysqli_query($link, $kursanteneKurspare);
                        $rowKasiKursanteshpare = mysqli_fetch_array($resultKursantepare);
                        $kursantetGjeturpare = $rowKasiKursanteshpare['Sasia'];
                        if ($kursantetGjeturpare < 13)
                        {
                            $idKlase = $klasmesditid[0];
                        }
                        else
                        {

                            $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '13:00 - 17:00' AND idklase = '$klasmesditid[1]');";
                            $resultKursante = mysqli_query($link, $kursanteneKurs);
                            $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                            $kursantetGjetur = $rowKasiKursantesh['Sasia'];
                            if ($kursantetGjetur < 13)
                            {
                                $idKlase = $klasmesditid[1];
                            }
                        }

                    }
                    else if ($registered >= 37 && $registered < 49)
                    {
                        $idKlase = $klasmesditid[3];
                        $kursanteneKurspare = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '13:00 - 17:00' AND idklase = '$klasmesditid[0]');";
                        $resultKursantepare = mysqli_query($link, $kursanteneKurspare);
                        $rowKasiKursanteshpare = mysqli_fetch_array($resultKursantepare);
                        $kursantetGjeturpare = $rowKasiKursanteshpare['Sasia'];
                        if ($kursantetGjeturpare < 13)
                        {
                            $idKlase = $klasmesditid[0];
                        }
                        else
                        {

                            $kursanteneKursdyte = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '13:00 - 17:00' AND idklase = '$klasmesditid[1]');";
                            $resultKursantedyte = mysqli_query($link, $kursanteneKursdyte);
                            $rowKasiKursanteshdyte = mysqli_fetch_array($resultKursantedyte);
                            $kursantetGjeturdyte = $rowKasiKursanteshdyte['Sasia'];
                            if ($kursantetGjeturdyte < 13)
                            {
                                $idKlase = $klasmesditid[1];
                            }
                            else
                            {
                                $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '13:00 - 17:00' AND idklase = '$klasmesditid[2]');";
                                $resultKursante = mysqli_query($link, $kursanteneKurs);
                                $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                                $kursantetGjetur = $rowKasiKursantesh['Sasia'];
                                if ($kursantetGjetur < 13)
                                {
                                    $idKlase = $klasmesditid[2];
                                }
                            }
                        }
                    }
                    $selectidkursidrek = "SELECT idkursi FROM programijavor WHERE idklase = $idKlase AND data = '$dataZgjedhur' AND orari = '13:00 - 17:00'";
                    $resultkursidrek = mysqli_query($link, $selectidkursidrek);
                    $rowkursidrek = mysqli_fetch_array($resultkursidrek);
                    if ($rowkursidrek > 0)
                    {
    ?>
                        <td class="text-left" style="text-align: center;">13:00 - 17:00</td>
                        <td class="text-left" style="text-align: center;"><?php echo date('d/m/Y',strtotime($dataZgjedhur)) ?></td>
                        <td class="text-left " style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowkursidrek['idkursi'] ?>"required>Zgjidh</input></td>
                    </tr>
                    <?php
                    }
                    else
                    {
    ?>
                    <td class="text-left" colspan="3" style="text-align: center">Për datën që ju keni zgjedhur nuk ka kurs në orarin 13:00 - 17:00!</td></tr>
                    <?php
                    }
                }
                else
                {
                    $futureDate = date('Y-m-d', strtotime('+3 days', strtotime($dataZgjedhur)));
                    $testdate = date('Y-m-d', strtotime('+1 days', strtotime($dataZgjedhur)));
                    $selectpredictCourses = "SELECT idkursi FROM `programijavor` WHERE orari = '13:00 - 17:00' AND data BETWEEN '$testdate' AND '$futureDate' ORDER BY data";
                    $resultpredictionCourses = mysqli_query($link, $selectpredictCourses);
                    $row = mysqli_num_rows($resultpredictionCourses);
                    if ($row > 0)
                    {
                        $gjetur = 0;
                        while ($row = mysqli_fetch_array($resultpredictionCourses))
                        {
                            $idkursitmoment = $row['idkursi'];
                            $selectexistkursantperkurs = "SELECT COUNT(*) AS Totali FROM organizimkursantesh1 WHERE statusi='pabere' AND idkursi = $idkursitmoment";
                            $resultexistkursantperkurs = mysqli_query($link, $selectexistkursantperkurs);
                            $rowexistkursantperkurs = mysqli_fetch_array($resultexistkursantperkurs);
                            $totali = $rowexistkursantperkurs['Totali'];
                            if ($totali < 12)
                            {

                                $gjetur = 1;
                                $getdateklase = "SELECT * FROM programijavor WHERE idkursi = $idkursitmoment";
                                $resultdatakursit = mysqli_query($link, $getdateklase);
                                $rowKkursigjetur = mysqli_fetch_array($resultdatakursit);

                                $datakursitgjetur = $rowKkursigjetur['data'];
                                $orari = $rowKkursigjetur['orari'];

    ?>
                                <td class="text-left" style="text-align: center;"><?php echo $orari ?></td>
                                <td class="text-left" style="text-align: center;">Në datën qe ju keni zgjedhur nuk ka vende të lira pasi klasat janë mbushur.  Data më e afert për klasa të lira është : <?php echo date('d/m/Y',strtotime($datakursitgjetur)) ?></td>
                                <td class="text-left" style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowKkursigjetur['idkursi'] ?>"required>Zgjidh</input></td>
                            </tr>
                            <?php
                                break;
                            }
                        }
                        if ($gjetur != 1)
                        {
    ?>
                                <td class="text-left" colspan="3" style="text-align: center">Në datën qe ju keni zgjedhur dhe në 3 ditët në vazhdim nuk ka vende të lira!</td></tr>
                            <?php
                        }
                    }
                    else
                    {
    ?>
                                <td class="text-left" colspan="3" style="text-align: center">Në datën që ju keni zgjedhur dhe në 3 ditët në vazhdim nuk është planifikuar kurs në orarin 13:00 - 17:00!</td></tr>
                                <?php
                    }
                }
            }
            else
            {
                $futureDate = date('Y-m-d', strtotime('+3 days', strtotime($dataZgjedhur)));
                $testdate = date('Y-m-d', strtotime('+1 days', strtotime($dataZgjedhur)));
                $selectpredictCourses = "SELECT idkursi FROM `programijavor` WHERE orari = '13:00 - 17:00' AND data BETWEEN '$testdate' AND '$futureDate' ORDER BY data";
                $resultpredictionCourses = mysqli_query($link, $selectpredictCourses);
                $row = mysqli_num_rows($resultpredictionCourses);
                if ($row > 0)
                {
                    $gjetur = 0;
                    while ($row = mysqli_fetch_array($resultpredictionCourses))
                    {
                        $idkursitmoment = $row['idkursi'];
                        $selectexistkursantperkurs = "SELECT COUNT(*) AS Totali FROM organizimkursantesh1 WHERE statusi='pabere' AND idkursi = $idkursitmoment";
                        $resultexistkursantperkurs = mysqli_query($link, $selectexistkursantperkurs);
                        $rowexistkursantperkurs = mysqli_fetch_array($resultexistkursantperkurs);
                        $totali = $rowexistkursantperkurs['Totali'];
                        if ($totali < 12)
                        {

                            $gjetur = 1;
                            $getdateklase = "SELECT * FROM programijavor WHERE idkursi = $idkursitmoment";
                            $resultdatakursit = mysqli_query($link, $getdateklase);
                            $rowKkursigjetur = mysqli_fetch_array($resultdatakursit);

                            $datakursitgjetur = $rowKkursigjetur['data'];
                            $orari = $rowKkursigjetur['orari'];

    ?>
                        <td class="text-left" style="text-align: center;"><?php echo $orari ?></td>
                        <td class="text-left" style="text-align: center;">Në datën qe ju keni zgjedhur nuk ka vende të lira pasi klasat janë mbushur.  Data më e afert për klasa të lira është : <?php echo date('d/m/Y',strtotime($datakursitgjetur)) ?></td>
                        <td class="text-left" style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowKkursigjetur['idkursi'] ?>"required>Zgjidh</input></td>
                    </tr>
                    <?php
                            break;
                        }
                    }
                    if ($gjetur != 1)
                    {
    ?>
                        <td class="text-left" colspan="3" style="text-align: center">Në datën qe ju keni zgjedhur dhe në 3 ditët në vazhdim nuk ka vende të lira!</td></tr>
                    <?php
                    }
                }
                else
                {
    ?>
                <td class="text-left" colspan="3" style="text-align: center">Në datën që ju keni zgjedhur dhe në 3 ditët në vazhdim nuk është planifikuar kurs në orarin 13:00 - 17:00!</td></tr>
                <?php
                }
            }

            $sqlquerymbasdite = "SELECT * FROM organizimkursantesh1 WHERE statusi ='pabere' AND idkursi IN (SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '17:00 - 21:00')";
            if ($klaspasditenr > 0)
            {
                $resultbasdite = mysqli_query($link, $sqlquerymbasdite);
                $max = $klaspasditenr * 12;
                $registered = mysqli_num_rows($resultbasdite);
                if ($registered < $max)
                {
                    if ($registered < 13)
                    {
                        $idKlase = $klaspasditeid[0];
                    }
                    else if ($registered >= 13 && $registered < 25)
                    {
                        $idKlase = $klaspasditeid[1];

                        $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '17:00 - 21:00' AND idklase = '$klaspasditeid[0]');";
                        $resultKursante = mysqli_query($link, $kursanteneKurs);
                        $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                        $kursantetGjetur = $rowKasiKursantesh['Sasia'];
                        if ($kursantetGjetur < 13)
                        {
                            $idKlase = $klaspasditeid[0];
                        }

                    }
                    else if ($registered >= 25 && $registered < 37)
                    {
                        $idKlase = $klaspasditeid[2];
                        $kursanteneKurspare = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '17:00 - 21:00' AND idklase = '$klaspasditeid[0]');";
                        $resultKursantepare = mysqli_query($link, $kursanteneKurspare);
                        $rowKasiKursanteshpare = mysqli_fetch_array($resultKursantepare);
                        $kursantetGjeturpare = $rowKasiKursanteshpare['Sasia'];
                        if ($kursantetGjeturpare < 13)
                        {
                            $idKlase = $klaspasditeid[0];
                        }
                        else
                        {

                            $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '17:00 - 21:00' AND idklase = '$klaspasditeid[1]');";
                            $resultKursante = mysqli_query($link, $kursanteneKurs);
                            $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                            $kursantetGjetur = $rowKasiKursantesh['Sasia'];
                            if ($kursantetGjetur < 13)
                            {
                                $idKlase = $klaspasditeid[1];
                            }
                        }

                    }
                    else if ($registered >= 37 && $registered < 49)
                    {
                        $idKlase = $klaspasditeid[3];
                        $kursanteneKurspare = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '17:00 - 21:00' AND idklase = '$klaspasditeid[0]');";
                        $resultKursantepare = mysqli_query($link, $kursanteneKurspare);
                        $rowKasiKursanteshpare = mysqli_fetch_array($resultKursantepare);
                        $kursantetGjeturpare = $rowKasiKursanteshpare['Sasia'];
                        if ($kursantetGjeturpare < 13)
                        {
                            $idKlase = $klaspasditeid[0];
                        }
                        else
                        {

                            $kursanteneKursdyte = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '17:00 - 21:00' AND idklase = '$klaspasditeid[1]');";
                            $resultKursantedyte = mysqli_query($link, $kursanteneKursdyte);
                            $rowKasiKursanteshdyte = mysqli_fetch_array($resultKursantedyte);
                            $kursantetGjeturdyte = $rowKasiKursanteshdyte['Sasia'];
                            if ($kursantetGjeturdyte < 13)
                            {
                                $idKlase = $klaspasditeid[1];
                            }
                            else
                            {
                                $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '17:00 - 21:00' AND idklase = '$klaspasditeid[2]');";
                                $resultKursante = mysqli_query($link, $kursanteneKurs);
                                $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                                $kursantetGjetur = $rowKasiKursantesh['Sasia'];
                                if ($kursantetGjetur < 13)
                                {
                                    $idKlase = $klaspasditeid[2];
                                }
                            }
                        }
                    }
                    $selectidkursimbasdit = "SELECT idkursi FROM programijavor WHERE idklase = $idKlase AND data = '$dataZgjedhur' AND orari = '17:00 - 21:00'";
                    $resultkursimbasdi = mysqli_query($link, $selectidkursimbasdit);
                    $rowkursimbasdit = mysqli_fetch_array($resultkursimbasdi);
                    if ($rowkursimbasdit > 0)
                    {
    ?>
                    <td class="text-left" style="text-align: center;">17:00 - 21:00</td>
                    <td class="text-left" style="text-align: center;"><?php echo date('d/m/Y',strtotime($dataZgjedhur)) ?></td>
                    <td class="text-left " style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowkursimbasdit['idkursi'] ?>"required>Zgjidh</input></td>
                </tr>
                <?php
                    }
                    else
                    {
    ?>
                        <td class="text-left" colspan="3" style="text-align: center">Për datën që ju keni zgjedhur nuk ka kurs në orarin 13:00 - 17:00!</td></tr>
                        <?php
                    }
                }
                else
                {
                    $futureDate = date('Y-m-d', strtotime('+3 days', strtotime($dataZgjedhur)));
                    $testdate = date('Y-m-d', strtotime('+1 days', strtotime($dataZgjedhur)));
                    $selectpredictCourses = "SELECT idkursi FROM `programijavor` WHERE orari = '17:00 - 21:00' AND data BETWEEN '$testdate' AND '$futureDate' ORDER BY data";
                    $resultpredictionCourses = mysqli_query($link, $selectpredictCourses);
                    $row = mysqli_num_rows($resultpredictionCourses);
                    if ($row > 0)
                    {
                        $gjetur = 0;
                        while ($row = mysqli_fetch_array($resultpredictionCourses))
                        {
                            $idkursitmoment = $row['idkursi'];
                            $selectexistkursantperkurs = "SELECT COUNT(*) AS Totali FROM organizimkursantesh1 WHERE statusi='pabere' AND idkursi = $idkursitmoment";
                            $resultexistkursantperkurs = mysqli_query($link, $selectexistkursantperkurs);
                            $rowexistkursantperkurs = mysqli_fetch_array($resultexistkursantperkurs);
                            $totali = $rowexistkursantperkurs['Totali'];
                            if ($totali < 12)
                            {

                                $gjetur = 1;
                                $getdateklase = "SELECT * FROM programijavor WHERE idkursi = $idkursitmoment";
                                $resultdatakursit = mysqli_query($link, $getdateklase);
                                $rowKkursigjetur = mysqli_fetch_array($resultdatakursit);

                                $datakursitgjetur = $rowKkursigjetur['data'];
                                $orari = $rowKkursigjetur['orari'];

    ?>
                        <td class="text-left" style="text-align: center;"><?php echo $orari ?></td>
                        <td class="text-left" style="text-align: center;">Në datën qe ju keni zgjedhur nuk ka vende të lira pasi klasat janë mbushur.  Data më e afert për klasa të lira është : <?php echo date('d/m/Y',strtotime($datakursitgjetur)) ?></td>
                        <td class="text-left" style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowKkursigjetur['idkursi'] ?>"required>Zgjidh</input></td>
                        </tr>
                        <?php
                                break;
                            }
                        }
                        if ($gjetur != 1)
                        {
    ?>
                        <td class="text-left" colspan="3" style="text-align: center">Në datën qe ju keni zgjedhur dhe në 3 ditët në vazhdim nuk ka vende të lira!</td></tr>
                        <?php
                        }
                    }
                    else
                    {
    ?>
                    <td class="text-left" colspan="3" style="text-align: center">Në datën që ju keni zgjedhur dhe në 3 ditët në vazhdim nuk është planifikuar kurs në orarin 17:00 - 21:00!</td></tr>
                    <?php
                    }
                }
            }
            else
            {
                $futureDate = date('Y-m-d', strtotime('+3 days', strtotime($dataZgjedhur)));
                $testdate = date('Y-m-d', strtotime('+1 days', strtotime($dataZgjedhur)));
                $selectpredictCourses = "SELECT idkursi FROM `programijavor` WHERE orari = '17:00 - 21:00' AND data BETWEEN '$testdate' AND '$futureDate' ORDER BY data";
                $resultpredictionCourses = mysqli_query($link, $selectpredictCourses);
                $row = mysqli_num_rows($resultpredictionCourses);
                if ($row > 0)
                {
                    $gjetur = 0;
                    while ($row = mysqli_fetch_array($resultpredictionCourses))
                    {
                        $idkursitmoment = $row['idkursi'];
                        $selectexistkursantperkurs = "SELECT COUNT(*) AS Totali FROM organizimkursantesh1 WHERE statusi='pabere' AND idkursi = $idkursitmoment";
                        $resultexistkursantperkurs = mysqli_query($link, $selectexistkursantperkurs);
                        $rowexistkursantperkurs = mysqli_fetch_array($resultexistkursantperkurs);
                        $totali = $rowexistkursantperkurs['Totali'];
                        if ($totali < 12)
                        {

                            $gjetur = 1;
                            $getdateklase = "SELECT * FROM programijavor WHERE idkursi = $idkursitmoment";
                            $resultdatakursit = mysqli_query($link, $getdateklase);
                            $rowKkursigjetur = mysqli_fetch_array($resultdatakursit);

                            $datakursitgjetur = $rowKkursigjetur['data'];
                            $orari = $rowKkursigjetur['orari'];

    ?>
                        <td class="text-left" style="text-align: center;"><?php echo $orari ?></td>
                        <td class="text-left" style="text-align: center;">Në datën qe ju keni zgjedhur nuk ka vende të lira pasi klasat janë mbushur.  Data më e afert për klasa të lira është : <?php echo date('d/m/Y',strtotime($datakursitgjetur)) ?></td>
                        <td class="text-left" style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowKkursigjetur['idkursi'] ?>"required>Zgjidh</input></td>
                        </tr>
                        <?php
                            break;
                        }
                    }
                    if ($gjetur != 1)
                    {
    ?>
                        <td class="text-left" colspan="3" style="text-align: center">Në datën qe ju keni zgjedhur dhe në 3 ditët në vazhdim nuk ka vende të lira!</td></tr>
                        <?php
                    }
                }
                else
                {
    ?>
                    <td class="text-left" colspan="3" style="text-align: center">Në datën që ju keni zgjedhur dhe në 3 ditët në vazhdim nuk është planifikuar kurs në orarin 17:00 - 21:00!</td></tr>
                    <?php
                }
            }

        }
        else
        {
    ?>
            <td class="text-left" colspan="3" style="text-align: center">Për datën që ju keni zgjedhur nuk ka kurs! Kursi organizohet në këto ditë të javës: 'E Hënë', 'E Mërkurë', 'E Premte', 'E Shtunë', 'E Djelë'</td></tr>
            <?php
            $futureDate = date('Y-m-d', strtotime('+3 days', strtotime($dataZgjedhur)));
            $testdate = date('Y-m-d', strtotime('+1 days', strtotime($dataZgjedhur)));
            $selectpredictCourses = "SELECT idkursi FROM `programijavor` WHERE data BETWEEN '$testdate' AND '$futureDate' ORDER BY data";
            $resultpredictionCourses = mysqli_query($link, $selectpredictCourses);
            $row = mysqli_num_rows($resultpredictionCourses);
            if ($row > 0)
            {
                $gjetur = 0;
                while ($row = mysqli_fetch_array($resultpredictionCourses))
                {
                    $idkursitmoment = $row['idkursi'];
                    $selectexistkursantperkurs = "SELECT COUNT(*) AS Totali FROM organizimkursantesh1 WHERE statusi='pabere' AND idkursi = $idkursitmoment";
                    $resultexistkursantperkurs = mysqli_query($link, $selectexistkursantperkurs);
                    $rowexistkursantperkurs = mysqli_fetch_array($resultexistkursantperkurs);
                    $totali = $rowexistkursantperkurs['Totali'];
                    if ($totali < 12)
                    {

                        $gjetur = 1;
                        $getdateklase = "SELECT * FROM programijavor WHERE idkursi = $idkursitmoment";
                        $resultdatakursit = mysqli_query($link, $getdateklase);
                        $rowKkursigjetur = mysqli_fetch_array($resultdatakursit);

                        $datakursitgjetur = $rowKkursigjetur['data'];
                        $orari = $rowKkursigjetur['orari'];

    ?>
                        <td class="text-left" style="text-align: center;"><?php echo $orari ?></td>
                        <td class="text-left" style="text-align: center;">Data më e afert për klasa të lira është :  <?php echo date('d/m/Y',strtotime($datakursitgjetur)) ?></td>
                        <td class="text-left" style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowKkursigjetur['idkursi'] ?>"required>Zgjidh</input></td>
                    </tr>
                    <?php
                        break;
                    }
                }
                if ($gjetur != 1)
                {
    ?>
                        <td class="text-left" colspan="3" style="text-align: center">Në datën qe ju keni zgjedhur dhe në 3 ditët në vazhdim nuk ka vende të lira!</td></tr>
                    <?php
                }
            }
            else
            {
    ?>
                <td class="text-left" colspan="3" style="text-align: center">Në datën që ju keni zgjedhur dhe në 3 ditët në vazhdim nuk është planifikuar kurs!</td></tr>
                <?php
            }
        }
    }
    else
    {

        $sqlquerydiele = "SELECT * FROM organizimkursantesh1 WHERE statusi ='pabere' AND idkursi IN (SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari ='09:00 - 15:00')";
        if ($klasdieleenr > 0)
        {
            $resultdiele = mysqli_query($link, $sqlquerydiele);
            $max = $klasdieleenr * 12;
            if (mysqli_num_rows($resultdiele) < $max)
            {

                $registered = mysqli_num_rows($resultdiele);
                if ($registered < 13)
                {
                    $idKlase = $klasdiele[0];
                }
                else if ($registered >= 13 && $registered < 25)
                {

                    $idKlase = $klasdiele[1];
                    $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '09:00 - 15:00' AND idklase = '$klasdiele[0]');";
                    $resultKursante = mysqli_query($link, $kursanteneKurs);
                    $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                    $kursantetGjetur = $rowKasiKursantesh['Sasia'];

                    if ($kursantetGjetur < 13)
                    {
                        $idKlase = $klasdiele[0];
                    }

                }
                else if ($registered >= 25 && $registered < 37)
                {
                    $idKlase = $klasdiele[2];
                    $kursanteneKurspare = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '09:00 - 15:00' AND idklase = '$klasdiele[0]');";
                    $resultKursantepare = mysqli_query($link, $kursanteneKurspare);
                    $rowKasiKursanteshpare = mysqli_fetch_array($resultKursantepare);
                    $kursantetGjeturpare = $rowKasiKursanteshpare['Sasia'];
                    if ($kursantetGjeturpare < 13)
                    {
                        $idKlase = $klasdiele[0];
                    }
                    else
                    {

                        $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '09:00 - 15:00' AND idklase = '$klasdiele[1]');";
                        $resultKursante = mysqli_query($link, $kursanteneKurs);
                        $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                        $kursantetGjetur = $rowKasiKursantesh['Sasia'];
                        if ($kursantetGjetur < 13)
                        {
                            $idKlase = $klasdiele[1];
                        }
                    }

                }
                else if ($registered >= 37 && $registered < 49)
                {
                    $idKlase = $klasdiele[3];
                    $kursanteneKurspare = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '09:00 - 15:00' AND idklase = '$klasdiele[0]');";
                    $resultKursantepare = mysqli_query($link, $kursanteneKurspare);
                    $rowKasiKursanteshpare = mysqli_fetch_array($resultKursantepare);
                    $kursantetGjeturpare = $rowKasiKursanteshpare['Sasia'];
                    if ($kursantetGjeturpare < 13)
                    {
                        $idKlase = $klasdiele[0];
                    }
                    else
                    {
                        $kursanteneKursdyte = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '09:00 - 15:00' AND idklase = '$klasdiele[1]');";
                        $resultKursantedyte = mysqli_query($link, $kursanteneKursdyte);
                        $rowKasiKursanteshdyte = mysqli_fetch_array($resultKursantedyte);
                        $kursantetGjeturdyte = $rowKasiKursanteshdyte['Sasia'];
                        if ($kursantetGjeturdyte < 13)
                        {
                            $idKlase = $klasdiele[1];
                        }
                        else
                        {
                            $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi IN( SELECT idkursi FROM programijavor WHERE data = '$dataZgjedhur' AND orari = '09:00 - 15:00' AND idklase = '$klasdiele[2]');";
                            $resultKursante = mysqli_query($link, $kursanteneKurs);
                            $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
                            $kursantetGjetur = $rowKasiKursantesh['Sasia'];
                            if ($kursantetGjetur < 13)
                            {
                                $idKlase = $klasdiele[2];
                            }
                        }
                    }
                }

                $selectidkursidiele = "SELECT idkursi FROM programijavor WHERE idklase = $idKlase AND data = '$dataZgjedhur' AND orari = '09:00 - 15:00'";
                $resultkursidiele = mysqli_query($link, $selectidkursidiele);
                $rowkursidiele = mysqli_fetch_array($resultkursidiele);
                if ($rowkursidiele > 0)
                {
    ?>
                        <td class="text-left" style="text-align: center;">09:00 - 15:00</td>
                        <td class="text-left" style="text-align: center;"><?php echo date('d/m/Y',strtotime($dataZgjedhur)) ?></td>
                        <td class="text-left " style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowkursidiele['idkursi'] ?>"required>Zgjidh</input></td>
                    </tr>
                    <?php
                }
                else
                {
    ?>
                    <td class="text-left" colspan="3" style="text-align: center">Për datën që ju keni zgjedhur nuk ka kurs në orarin 09:00 - 15:00!</td></tr>
                    <?php
                }
            }
            else
            {
                $futureDate = date('Y-m-d', strtotime('+7 days', strtotime($dataZgjedhur)));
                $testdate = date('Y-m-d', strtotime('+1 days', strtotime($dataZgjedhur)));
                $selectpredictCourses = "SELECT idkursi FROM `programijavor` WHERE data BETWEEN '$testdate' AND '$futureDate' ORDER BY data";
                $resultpredictionCourses = mysqli_query($link, $selectpredictCourses);
                $row = mysqli_num_rows($resultpredictionCourses);
                if ($row > 0)
                {
                    $gjetur = 0;
                    while ($row = mysqli_fetch_array($resultpredictionCourses))
                    {
                        $idkursitmoment = $row['idkursi'];
                        $selectexistkursantperkurs = "SELECT COUNT(*) AS Totali FROM organizimkursantesh1 WHERE statusi='pabere' AND idkursi = $idkursitmoment";
                        $resultexistkursantperkurs = mysqli_query($link, $selectexistkursantperkurs);
                        $rowexistkursantperkurs = mysqli_fetch_array($resultexistkursantperkurs);
                        $totali = $rowexistkursantperkurs['Totali'];
                        if ($totali < 12)
                        {

                            $gjetur = 1;
                            $getdateklase = "SELECT * FROM programijavor WHERE idkursi = $idkursitmoment";
                            $resultdatakursit = mysqli_query($link, $getdateklase);
                            $rowKkursigjetur = mysqli_fetch_array($resultdatakursit);

                            $datakursitgjetur = $rowKkursigjetur['data'];
                            $orari = $rowKkursigjetur['orari'];

    ?>
                        <td class="text-left" style="text-align: center;"><?php echo $orari ?></td>
                        <td class="text-left" style="text-align: center;">Në datën qe ju keni zgjedhur nuk ka vende të lira pasi klasat janë mbushur.  Data më e afert për klasa të lira është : <?php echo date('d/m/Y',strtotime($datakursitgjetur)) ?></td>
                        <td class="text-left" style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowKkursigjetur['idkursi'] ?>"required>Zgjidh</input></td>
                        </tr>
                        <?php
                            break;
                        }
                    }
                    if ($gjetur != 1)
                    {
    ?>
                        <td class="text-left" colspan="3" style="text-align: center">Në datën qe ju keni zgjedhur dhe në 3 ditët në vazhdim nuk ka vende të lira!</td></tr>
                        <?php
                    }
                }
                else
                {
    ?>
                    <td class="text-left" colspan="3" style="text-align: center">Në datën që ju keni zgjedhur dhe në 3 ditët në vazhdim nuk është planifikuar kurs në orarin 09:00 - 15:00!</td></tr>
                    <?php
                }

            }
        }
        else
        {
            $futureDate = date('Y-m-d', strtotime('+7 days', strtotime($dataZgjedhur)));
            $testdate = date('Y-m-d', strtotime('+1 days', strtotime($dataZgjedhur)));
            $selectpredictCourses = "SELECT idkursi FROM `programijavor` WHERE data BETWEEN '$testdate' AND '$futureDate' ORDER BY data";
            $resultpredictionCourses = mysqli_query($link, $selectpredictCourses);
            $row = mysqli_num_rows($resultpredictionCourses);
            if ($row > 0)
            {
                $gjetur = 0;
                while ($row = mysqli_fetch_array($resultpredictionCourses))
                {

                    $idkursitmoment = $row['idkursi'];
                    $selectexistkursantperkurs = "SELECT COUNT(*) AS Totali FROM organizimkursantesh1 WHERE statusi='pabere' AND idkursi = $idkursitmoment";
                    $resultexistkursantperkurs = mysqli_query($link, $selectexistkursantperkurs);
                    $rowexistkursantperkurs = mysqli_fetch_array($resultexistkursantperkurs);
                    $totali = $rowexistkursantperkurs['Totali'];
                    if ($totali < 12)
                    {
                        $gjetur = 1;
                        $getdateklase = "SELECT * FROM programijavor WHERE idkursi = $idkursitmoment";
                        $resultdatakursit = mysqli_query($link, $getdateklase);
                        $rowKkursigjetur = mysqli_fetch_array($resultdatakursit);

                        $datakursitgjetur = $rowKkursigjetur['data'];
                        $orari = $rowKkursigjetur['orari'];

    ?>
                            <td class="text-left" style="text-align: center;"><?php echo $orari ?></td>
                            <td class="text-left" style="text-align: center;">Në datën qe ju keni zgjedhur nuk ka vende të lira pasi klasat janë mbushur.  Data më e afert për klasa të lira është : <?php echo date('d/m/Y',strtotime($datakursitgjetur)) ?></td>
                            <td class="text-left" style="text-align: center;"><input type="radio"  id="select" name="select" value="<?php echo $rowKkursigjetur['idkursi'] ?>"required>Zgjidh</input></td>
                        </tr>
                        <?php
                        break;
                    }
                }

                if ($gjetur != 1)
                {
    ?>
                            <td class="text-left" colspan="3" style="text-align: center">Në datën qe ju keni zgjedhur dhe në 3 ditët në vazhdim nuk ka vende të lira!</td></tr>
                        <?php
                }
            }
            else
            {
    ?>
                        <td class="text-left" colspan="3" style="text-align: center">Në datën që ju keni zgjedhur dhe në 3 ditët në vazhdim nuk është planifikuar kurs në orarin 09:00 - 15:00!</td></tr>
                        <?php
            }
        }
    }
}else{
    ?>
        <td class="text-left" colspan="3" style="text-align: center">Data që ju keni zgjedhur nuk është e saktë. Kurset organizohen nga sot e ne vazhdim. Ju Faleminderit!</td></tr>
    <?php
}
?>   
</table>
</body>
