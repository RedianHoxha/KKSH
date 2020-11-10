<?php 
            
            session_start();
            $user=$_SESSION['user'];
            $link = mysqli_connect("localhost", "root", "", "kksh");
            //echo $user;
    
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
}?>
<!DOCTYPE html>
    <head>
        <title>Kryqi i Kuq Shqipetar</title>
        <link rel="stylesheet" type="text/css"  href="../CSS/Confirm-stilizo.css">
    </head>
    <body>
        <table id="tabela-kursanteve" >
            <tr>
                <th>ID</th>
                <th>Emri</th>
                <th>Mbiemri</th>
                <th>Atesia</th>
                <th>Vendbanimi</th>
                <th>Datelindja</th>
                <th>Amza</th>
                <th>Data</th>
                <th>Edito</th>
            </tr>


            <tr>
               
               <?php $sqlquery="Select * from kursant";
                 $kursantet=mysqli_query($link, $sqlquery);
                 while ($row = mysqli_fetch_array($kursantet)) { ?>

                <td class="text-left"><?php echo $row['ID']; ?></td>
                <td class="text-left"><?php echo $row['Emri']; ?></td>
                <td class="text-left"><?php echo $row['Mbiemri']; ?></td>
                <td class="text-left"><?php echo $row['Atesia']; ?></td>
                <td class="text-left"><?php echo $row['Venbanimi']; ?></td>
                <td class="text-left"><?php echo $row['Datelindja']; ?></td>
                <td class="text-left"><?php echo $row['Amza']; ?></td>
                <td class="text-left"><?php echo $row['Datakursit']; ?></td>
                <td class="text-left"><button onclick="location.href = 'Ruajamzen.php?id=<?php echo $row['ID'];?> & amza = <?php echo $row['Amza']; ?>'" >Ruaj</button></td>
            </tr>
            <?php } ?>
        </table>

    </body>
    
</html>