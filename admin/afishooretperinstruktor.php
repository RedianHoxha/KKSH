<?php
 require_once('../methods/extra_function.php');
 include('../authenticate/dbconnection.php');
 if($link === false){
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
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>
<body>
    <div id="info">
        <p>Ky instruktor ka trajnuar <?php echo $shumaTotale ?> Kursante</p>
    </div>
    <div id="tabela">
    <script>

        $(document).ready(function() {
        $('#tabela-kursanteve').after('<div id="nav"></div>');
        var rowsShown = 9;
        var rowsTotal = $('#tabela-kursanteve tbody tr').length;
        var numPages = rowsTotal / rowsShown;
        for (i = 0; i < numPages; i++) {
            var pageNum = i + 1;
            $('#nav').append('<a href="#" class="btn" rel="' + i + '">' + pageNum + '</a> ');
        }
        $('#tabela-kursanteve tbody tr').hide();
        $('#tabela-kursanteve tbody tr').slice(0, rowsShown).show();
        $('#nav a:first').addClass('active');
        $('#nav a').bind('click', function() {

            $('#nav a').removeClass('active');
            $(this).addClass('active');
            var currPage = $(this).attr('rel');
            var startItem = currPage * rowsShown;
            var endItem = startItem + rowsShown;
            $('#tabela-kursanteve tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).
            css('display', 'table-row').animate({
            opacity: 1
            }, 300);
        });
        });
        </script>
        <table id="tabela-kursanteve" class="table table-bordered">
            <tr>
                <th>Emri Kursantit</th>
                <th>Amza</th>
                <th>Nr. Seris Se Deshmis</th>
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
                            <td class="text-left"><?php echo date('d/m/Y',strtotime($row['Datakursit']))?></td>
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
                    window.location.href='../panelstaf/index.php';
                    </script>";
                }
            ?>   
        </table>
    </div>
</body>