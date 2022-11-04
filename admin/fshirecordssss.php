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
            </th>
        <tr>
            <?php
        //$firstday = date('Y-m-d', strtotime("monday -1 week"));
        //$lastday = date('Y-m-d', strtotime("sunday 0 week"));
        $today = date('Y-m-d');
        //$sqlquery="SELECT * FROM programijavor";
        $sqlquery = "SELECT * FROM programijavor WHERE idklase = 60 AND data = '2022-07-27' AND orari = '17:00 - 21:00'";
        //$sqlquery="SELECT * FROM programijavor WHERE data BETWEEN '$firstday' AND '$lastday' AND idklase in (SELECT id FROM klasa WHERE  qyteti = '$idDeges');";
        
        if ($result = mysqli_query($link, $sqlquery)) {
            if (mysqli_num_rows($result) != 0) {
                while ($row = mysqli_fetch_array($result)) {
        ?>
            <td class="text-left">
                <?php echo $row['idklase'] ?>
            </td>
            <td class="text-left">
                <?php echo decrypt($row['idinstruktori']) ?>
            </td>
            <td class="text-left">
                <?php echo $row['orari'] ?>
            </td>
            <td class="text-left">
                <?php echo $row['idkursi'] ?>
            </td>
        </tr>
        <?php
                }
            }
        }
                    ?>
    </table>
</body>