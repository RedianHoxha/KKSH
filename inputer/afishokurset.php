<?php 
    session_start();
    require_once('../php/extra_function.php');
    include('../Authenticate/dbconnection.php');
    if (!isset($_SESSION['user'])) {
        echo "Please Login again";
        echo "<a href='../html/index.php'>Click Here to Login</a>";
    }else{
        $now = time();
		if ($now > $_SESSION['expire']) {
			session_destroy();
            echo "<script>
            alert('Session Ended');
            window.location.href='../html/index.php';
            </script>";
		}else
		{
			$user=$_SESSION['user'];
            $iduseri = $_SESSION['UserID'];
            $_SESSION['expire'] = $_SESSION['expire'] + (5 * 60);
            //$link = mysqli_connect("localhost", "root", "", "kksh");
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
                    window.location.href='../html/index.php';
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>       
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            // $(document).ready(function(){
            //     $("button").click(function(){
            //         var rowCount = $('#tabela-kursanteve tbody tr').length;
            //         alert(rowCount); // Outputs: 4
            //     });
            // });

            $(document).ready(function() {
            $('#tabela-kursanteve').after('<div id="nav"></div>');
            var rowsShown = 12;
            var rowsTotal = $('#tabela-kursanteve tbody tr').length;
            var numPages = rowsTotal / rowsShown;
            for (i = 0; i < numPages; i++) {
                var pageNum = i + 1;
                $('#nav').append('<a href="#" rel="' + i + '">' + pageNum + '</a> ');
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
    </head>
    <body>
        <div id="logout">
            <button class="btn btn-secondary" onclick="location.href = 'inputerpage.php';" id="myButton" >Ktheu</button>
            <button class="btn btn-secondary" onclick="location.href = '../inputer/bejndryshime.php';" id="myButton" >Bej ndryshime</button>
            <button class="btn btn-secondary" onclick="location.href = '../inputer/gjeneroexel.php';" id="myButton" >Gjenero Excel</button>
            <button class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton" >Dil <?php echo decrypt($user) ?></button>
        </div>
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
                        <td class="text-left"><button class="btn btn-success"onclick="location.href = 'shtokursant.php?id=<?php echo $idKursi;?>'">Zgjidh</button></td>
                    </tr>
                    <?php }}} ?>
                
        </tr>
        </table>
    </body>
    
</html>