<?php
$link = mysqli_connect("localhost", "root", "", "kksh");
require_once('../php/extra_function.php');
if (!$link) {
  die('Could not connect: ' . mysqli_error($con));
}

$idInstruktori = $_GET['id'];
$muaji =  $_GET['data'];

mysqli_select_db($link,"ajax_demo");
$firstdaymonth = date('Y-' . $muaji . '-01');
$lastdaymonth = date("Y-m-t", strtotime($firstdaymonth));

$sqlquery="SELECT Emri, Mbiemri, Amza, NrSerisDeshmis, Orari, Datakursit FROM kursantet WHERE Statusi = 'perfunduar' AND Datakursit BETWEEN '$firstdaymonth' AND '$lastdaymonth' AND PersonalId IN (SELECT idkursanti FROM organizimkursantesh1 WHERE idkursi IN (SELECT idkursi FROM programijavor WHERE idinstruktori = '$idInstruktori'))";

if($result = mysqli_query($link,$sqlquery))
    {
        $shumaTotale = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<body>
    <div id="info">
        <p>Ky instruktor ka trajnuar <?php echo $shumaTotale ?> Kursante</p>
    </div>
    <div id="tabela">
        <table id="tabela-kursanteve" >
            <tr>
                <th>Emri Kursantit</th>
                <th>Amza</th>
                <th>Sr Deshmis</th>
                <th>Data</th>
                <th>Orari</th>
            </tr>
            <tr>
            <?php 

                    if(mysqli_num_rows($result) != 0)
                    {
                    while($row = mysqli_fetch_array($result))
                    {
                        $emriPersonit = decrypt($row['Emri']). " ". decrypt($row['Mbiemri']);
                        ?>
                            <td class="text-left"><?php echo $emriPersonit ?></td>
                            <td class="text-left"><?php echo decrypt($row['Amza']) ?></td>
                            <td class="text-left"><?php echo decrypt($row['NrSerisDeshmis']) ?></td>
                            <td class="text-left"><?php echo $row['Datakursit']?></td>
                            <td class="text-left"><?php echo $row['Orari']?></td>
                        </tr>
                        <?php 
                        }
                    }
                    else
                    {
                    ?>
                        <td class="text-left" colspan="7" style="text-align:center">Per Instruktorin e zgjedhur nuk ka ndonje te dhene ne sistem! Zgjidhni nje Instruktor tjeter.</td> </tr>
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
    </div>
</body>