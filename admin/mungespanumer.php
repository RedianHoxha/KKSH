<?php
//echo "Hello"

require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');
?>

<body>
    <table id="tabela-kursanteve" class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Emri</th>
            <th>Mbiemri</th>
            <th>Atesia</th>
            <th>Statusi</th>
            <th>Data</th>
            <th>Orari</th>
            <th>Instruktori</th>
        </tr>
        <tr>
            <?php $sqlquery = "SELECT * FROM kursantet WHERE  Statusi ='perfunduar' and Amza = '' AND NrSerisDeshmis = ''";
           echo $sqlquery;
           $kursantet = mysqli_query($link, $sqlquery);
           while ($row = mysqli_fetch_array($kursantet)) {

           ?>
            <td class="text-left">
                <?php echo decrypt($row['PersonalId']); ?>
            </td>
            <td class="text-left">
                <?php echo decrypt($row['Emri']); ?>
            </td>
            <td class="text-left">
                <?php echo decrypt($row['Mbiemri']); ?>
            </td>
            <td class="text-left">
                <?php echo decrypt($row['Atesia']); ?>
            </td>
            <td class="text-left">
                <?php echo $row['Statusi']; ?>
            </td>
            <td class="text-left">
                <?php echo $row['Datakursit']; ?>
            </td>
            <td class="text-left">
                <?php echo $row['Orari']; ?>
            </td>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>