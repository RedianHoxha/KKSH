
<?php
//echo "Hello"

require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');

//$query = "DELETE FROM kursantet";
    // if(mysqli_query($link, $query)){
    //     echo "U fshine";
    // }else{
    //     echo "Su fshine";
    // }
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
           <?php $sqlquery="SELECT * FROM kursantet WHERE  PersonalId='ny4iUWOznN0wFQ=='";
             $kursantet=mysqli_query($link, $sqlquery);
             while ($row = mysqli_fetch_array($kursantet)) { 
                 
                $idkursnti = $row['PersonalId'];
                $kursi = "SELECT * FROM organizimkursantesh1 WHERE statusi='pabere' AND idkursanti='$idkursnti'";
                $kursiresult =mysqli_query($link, $kursi);
                $rowkursi = mysqli_fetch_array($kursiresult);

                $idkursi = $rowkursi['idkursi'];
                $instruktori = "SELECT * FROM programijavor WHERE idkursi='$idkursi'";
                $instruktoriresult =mysqli_query($link, $instruktori);
                $rowinstruktori = mysqli_fetch_array($instruktoriresult);

                $idinstruktori = $rowinstruktori['idinstruktori'];

                $instructorname = "SELECT * FROM staf where ID='$idinstruktori'";
                $instruktoriname =mysqli_query($link, $instructorname);
                $rowinstruktoriname = mysqli_fetch_array($instruktoriname);
                $name = decrypt($rowinstruktoriname['Emri']).' '.decrypt($rowinstruktoriname['Mbiemri']);

                ?>
            <td class="text-left"><?php echo decrypt($row['PersonalId']); ?></td>
            <td class="text-left"><?php echo decrypt($row['Emri']); ?></td>
            <td class="text-left"><?php echo decrypt($row['Mbiemri']); ?></td>
            <td class="text-left"><?php echo decrypt($row['Atesia']); ?></td>
            <td class="text-left"><?php echo $row['Statusi']; ?></td>
            <td class="text-left"><?php echo $row['Datakursit']; ?></td>
            <td class="text-left"><?php echo $row['Orari']; ?></td>
            <td class="text-left"><?php echo $name ?></td>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
