<?php 
    session_start();
    require_once('../php/extra_function.php');
    if (!isset($_SESSION['user'])) {
        echo "Please Login again";
        echo "<a href='../html/homepage.html'>Click Here to Login</a>";
    }else{
        $now = time();
		if ($now > $_SESSION['expire']) {
			session_destroy();
            echo "<script>
            alert('Session Ended');
            window.location.href='../html/homepage.html';
            </script>";
		}else
		{
			$user=$_SESSION['user'];
            $iduseri = $_SESSION['UserID'];
            $_SESSION['expire'] = $_SESSION['expire'] + (5 * 60);
            $link = mysqli_connect("localhost", "root", "", "kksh");
			if($link === false)
			{
                    die("ERROR: Could not connect. " . mysqli_connect_error());
            }else
			{
				$query = "select * from staf where ID = '$iduseri';";
                $kursantet=mysqli_query($link, $query);
                $row = mysqli_fetch_array($kursantet);
                $degastafit = $row['Degakupunon'];

                $querydega = "select * from qyteti where EmriDeges = '$degastafit';";
                $dega=mysqli_query($link, $querydega);
                $rowdega = mysqli_fetch_array($dega);
                $idDeges = $rowdega['IDQyteti'];
                $roli = decrypt($row['Roli']);
                $pageRole = "Inputer";
                $result = strcmp($roli, $pageRole);

				if($result != 0)
				{
                    session_destroy();
                    echo "<script>
                    alert('Session Ended');
                    window.location.href='../html/homepage.html';
                    </script>";
				}
			}
		}
    }
?>


<!DOCTYPE html>
    <head>
        <title>Kryqi i Kuq Shqiptar</title>
        <link rel="stylesheet" type="text/css"  href="../css/confirmstilizo.css">
    </head>
    <body>
        <div id="logout">
            <button onclick="location.href = 'inputerpage.php';" id="myButton" >Ktheu</button>
            <button onclick="location.href = '../inputer/bejndryshime.php';" id="myButton" >Bej ndryshime</button>
            <button onclick="location.href = '../authenticate/logout.php';" id="myButton" >Dil <?php echo decrypt($user) ?></button>
        </div>
        <table id="tabela-kursanteve" >
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
        $firstday = date('Y-m-d', strtotime("monday -1 week"));
        $lastday = date('Y-m-d', strtotime("sunday 0 week"));
        $sqlquery="SELECT * FROM programijavor WHERE data BETWEEN '$firstday' AND '$lastday' AND idklase in (SELECT id FROM klasa WHERE  qyteti = '$idDeges');";

        if($result = mysqli_query($link,$sqlquery))
        {
            if(mysqli_num_rows($result) != 0)
            {
                while($row = mysqli_fetch_array($result))
                {
                    $idKlase = $row['idklase'];
                    $idKursi = $row['idkursi'];
                    $orariKursit = $row['orari'];
                    $dataKursit = $row['data'];
                    $idInstruktori = $row['idinstruktori'];

                   
                    $queryInstruktori = "SELECT * FROM staf WHERE ID = '$idInstruktori'";
                    $resultInstruktori = mysqli_query($link, $queryInstruktori);
                    $rowInstrukotori = mysqli_fetch_array($resultInstruktori);
                    $emriInstruktorit =  decrypt($rowInstrukotori['Emri'])." ".decrypt($rowInstrukotori['Mbiemri']);
            
                    $sqlKlasa = "select * from klasa where ID= '$idKlase';";
                    $resultKlasa = mysqli_query($link,$sqlKlasa);
                    $rowKlasa = mysqli_fetch_array($resultKlasa);
                    
                    $emriKlases = $rowKlasa['Emri'];
                    $kapacitetiKlases = $rowKlasa['Kapaciteti'];
            
                    $kursanteneKurs = "select Count(organizimkursantesh1.idkursi) as Sasia from organizimkursantesh1 where organizimkursantesh1.statusi = 'pabere' and organizimkursantesh1.idkursi = '$idKursi';";
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
                        <td class="text-left"><button onclick="location.href = 'shtokursant.php?id=<?php echo $idKursi;?>'">Zgjidh</button></td>
                    </tr>
                    <?php }}} ?>
                
        </tr>
        </table>
    </body>
    
</html>