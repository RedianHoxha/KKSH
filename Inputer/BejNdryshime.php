<?php 
    session_start();
    require_once('../php/extra_function.php');
    include('../authenticate/dbconnection.php');
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
				$query = "SELECT * FROM  staf WHERE ID = '$iduseri';";
                $staf=mysqli_query($link, $query);
                $row = mysqli_fetch_array($staf);
                $dega = $row['Degakupunon'];
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
        <title>Kryqi i Kuq Shqipetar</title>
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
        <div id="top-page">
            <div id="top-page-left">
                <button class="btn btn-success" onclick="location.href = 'inputerpage.php';" id="myButton" >Rregjistro kursantet te ri</button>
                <button class="btn btn-secondary" onclick="location.href = '../inputer/afishokurset.php';" id="myButton" >Shiko Kurset</button>
                <button class="btn btn-secondary" onclick="location.href = '../inputer/gjeneroexel.php';" id="myButton" >Gjenero Excel</button>
                <button class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo decrypt($user) ?></button></br>
            </div>
            <div id="top-page-right">
            <form action="Search.php" method="POST"> 
                <input class="form-group mx-sm-3 mb-2" type="text" name="search" id="search" placeholder = "Search">
                <button class="btn btn-secondary" type="submit" id="search-button">Search</button>
            </form>
            </div>
        </div>
        <table id="tabela-kursanteve" class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Emri</th>
                <th>Mbiemri</th>
                <th>Atesia</th>
                <th>Vendbanimi</th>
                <th>Telefoni</th>
                <th>Datelindja</th>
                <th>Data</th>
                <th>Orari</th>
                <th>Instruktori</th>
                <th>Edito</th>
            </tr>
            <tr>
               <?php $sqlquery="SELECT * FROM kursantet WHERE Statusi = 'pabere'";
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
                <td class="text-left"><?php echo decrypt($row['Vendbanimi']); ?></td>
                <td class="text-left"><?php echo $row['Telefoni']; ?></td>
                <td class="text-left"><?php echo $row['Datelindja']; ?></td>
                <td class="text-left"><?php echo $row['Datakursit']; ?></td>
                <td class="text-left"><?php echo $row['Orari']; ?></td>
                <td class="text-left"><?php echo $name ?></td>
                <td class="text-left"><button class="btn btn-success" onclick="location.href = '../php/ndryshorregjistrimin.php?id=<?php echo $row['ID'];?>'">Ndrysho</button><button class="btn btn-danger" onclick="location.href = '../php/fshirregjistrimin.php?id=<?php echo $row['ID'];?>'" >Fshi</button>
                </td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>