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
            <th>Emri Klases</th>
            <th>Instruktori</th>
            <th>Te rregjistruar</th>
            <th>Kapaciteti</th>
            <th>Data</th>
            <th>Orari</th>
            <th>Zgjidh</th>
        </tr>
        <tr>
        <?php 
        //$firstday = date('Y-m-d', strtotime("monday -1 week"));
        //$lastday = date('Y-m-d', strtotime("sunday 0 week"));
        $today = date('Y-m-d');
        $sqlquery="SELECT * FROM programijavor";
        //$sqlquery="SELECT * FROM programijavor WHERE data BETWEEN '$firstday' AND '$lastday' AND idklase in (SELECT id FROM klasa WHERE  qyteti = '$idDeges');";

        if($result = mysqli_query($link,$sqlquery))
        {
            if(mysqli_num_rows($result) != 0)
            {
                while($row = mysqli_fetch_array($result))
                {
                    $idKlase = $row['idklase'];
                    $idKursi = $row['idkursi'];
                    echo $idKursi;
                    $orariKursit = $row['orari'];
                    $dataKursit = $row['data'];
                    $idInstruktori = $row['idinstruktori'];

                   
                    $queryInstruktori = "SELECT * FROM staf WHERE ID = '$idInstruktori'";
                    $resultInstruktori = mysqli_query($link, $queryInstruktori);
                    $rowInstrukotori = mysqli_fetch_array($resultInstruktori);
                    $emriInstruktorit =  decrypt($rowInstrukotori['Emri'])." ".decrypt($rowInstrukotori['Mbiemri']);
            
                    $sqlKlasa = "SELECT * FROM  klasa WHERE ID= '$idKlase';";
                    $resultKlasa = mysqli_query($link,$sqlKlasa);
                    $rowKlasa = mysqli_fetch_array($resultKlasa);
                    
                    $emriKlases = $rowKlasa['Emri'];
                    $kapacitetiKlases = $rowKlasa['Kapaciteti'];
            
                    $kursanteneKurs = "SELECT COUNT(organizimkursantesh1.idkursi) AS Sasia FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi = '$idKursi';";
                    $resultKursante = mysqli_query($link,$kursanteneKurs);
                    $rowKasiKursantesh = mysqli_fetch_array($resultKursante);
            
                    $kursantet = $rowKasiKursantesh['Sasia'];
                    ?>
                        <td class="text-left"><?php echo decrypt($emriKlases) ?></td>
                        <td class="text-left"><?php echo $emriInstruktorit  ?></td>
                        <td class="text-left"><?php echo $kursantet ?></td>
                        <td class="text-left"><?php echo $kapacitetiKlases ?></td>
                        <td class="text-left"><?php echo $dataKursit ?></td>
                        <td class="text-left"><?php echo $orariKursit ?></td>
                    </tr>
                    <?php }}} ?>
                
        </tr>
        </table>







        <table id="tabela-kursanteve" class="table table-bordered">
        <tr>
            <th>idkursi</th>
            <th>idkrsanti</th>
            <th>idkrsanti</th>
            <th>Statusi</th>
        </tr>
        <tr>
        <?php 
        //$firstday = date('Y-m-d', strtotime("monday -1 week"));
        //$lastday = date('Y-m-d', strtotime("sunday 0 week"));
        $today = date('Y-m-d');
        //$sqlquery="SELECT * FROM programijavor";
        $sqlquery = "SELECT * FROM `organizimkursantesh1` WHERE statusi = 'ndryshuar'";
        //$sqlquery="SELECT * FROM programijavor WHERE data BETWEEN '$firstday' AND '$lastday' AND idklase in (SELECT id FROM klasa WHERE  qyteti = '$idDeges');";

        if($result = mysqli_query($link,$sqlquery))
        {
            if(mysqli_num_rows($result) != 0)
            {
                while($row = mysqli_fetch_array($result))
                {
                    $idKlase = $row['idklase'];
                    $idKursi = $row['idkursi'];
                    echo $idKursi;
                    $orariKursit = $row['orari'];
                    $dataKursit = $row['data'];
                    $idInstruktori = $row['idinstruktori'];

                   
                    $queryInstruktori = "SELECT * FROM staf WHERE ID = '$idInstruktori'";
                    $resultInstruktori = mysqli_query($link, $queryInstruktori);
                    $rowInstrukotori = mysqli_fetch_array($resultInstruktori);
                    $emriInstruktorit =  decrypt($rowInstrukotori['Emri'])." ".decrypt($rowInstrukotori['Mbiemri']);
            
                    $sqlKlasa = "SELECT * FROM  klasa WHERE ID= '$idKlase';";
                    $resultKlasa = mysqli_query($link,$sqlKlasa);
                    $rowKlasa = mysqli_fetch_array($resultKlasa);
                    
                    $emriKlases = $rowKlasa['Emri'];
                    $kapacitetiKlases = $rowKlasa['Kapaciteti'];
            
                    $kursanteneKurs = "SELECT * FROM  organizimkursantesh1 WHERE organizimkursantesh1.statusi = 'pabere' AND organizimkursantesh1.idkursi = '$idKursi';";
                    $resultKursante = mysqli_query($link,$kursanteneKurs);
                    while($rowKasiKursantesh = mysqli_fetch_array($resultKursante)){
                        ?>
                        <td class="text-left"><?php echo $rowKasiKursantesh['idkursi']  ?></td>
                        <td class="text-left"><?php echo decrypt($rowKasiKursantesh['idkursanti']) ?></td>
                        <td class="text-left"><?php echo $rowKasiKursantesh['idkursanti'] ?></td>
                        <td class="text-left"><?php echo $rowKasiKursantesh['statusi'] ?></td>
                    </tr><?php
                    }
            
                    //$kursantet = $rowKasiKursantesh['Sasia'];
                    ?>
                    
                        
                    <?php }}} ?>
                
        </tr>
        </table>
        </body>