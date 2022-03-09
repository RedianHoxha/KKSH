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
            $_SESSION['expire'] = $_SESSION['expire'] + (3 * 60);
            $link = mysqli_connect("localhost", "root", "", "kksh");
			if($link === false)
			{
                    die("ERROR: Could not connect. " . mysqli_connect_error());
            }else
			{
				$query = "select * from staf where ID = '$iduseri';";
                $staf=mysqli_query($link, $query);
                $row = mysqli_fetch_array($staf);
                $dega = $row['Degakupunon'];
                $roli = decrypt($row['Roli']);
                $pageRole = "Admindege";
                $result = strcmp($roli, $pageRole);
				if($result == 0)
				{

                    $queryqyteti = "select * from qyteti where EmriDeges = '$dega';";
                    $klasa=mysqli_query($link, $queryqyteti);
                    $row = mysqli_fetch_array($klasa);
                    $idqyteti = $row['IDQyteti'];
				}
				else
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
    <link rel="stylesheet" type="text/css" href="../css/admindegestilizime.css" />
</head>
<body>
    <div id="add_button">
        <button onclick="location.href = 'shtoplanifikim.php';" id="addbutton" >Shto Planifikim</button>
        <button onclick="location.href = 'shikooret.php';" id="addbutton" >Shiko Oret</button>
        <button onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo decrypt($user) ?></button><br>
    </div>
    <img src="../images/kkshlogo.PNG" alt="Simply Easy Learning" id="KKSH_logo">

    <p id="welcome">Welcome</p><br>

    <div id="organisation_table">
        <div id="tabela">
            <table id="organizim_javor">  
                <tr>
                    <th>Klasa</th>
                    <th>Instruktori</th>
                    <th>Orari</th>
                    <th>Data</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <?php 
                    $firstday = date('Y-m-d', strtotime("monday -1 week"));
                    $lastday = date('Y-m-d', strtotime("sunday 0 week"));
                    $sqlquery="SELECT * FROM `programijavor` WHERE data BETWEEN '$firstday' AND '$lastday' AND idklase in (SELECT id FROM klasa WHERE  qyteti = '$idqyteti')  ORDER BY data ASC;";
                    echo "<script>console.log('Debug Objects: " . $sqlquery .  "' );</script>";
                    $kursantet=mysqli_query($link, $sqlquery);
                    while ($row = mysqli_fetch_array($kursantet)) { 

                        $idKlase = $row['idklase'];
                        $sqlKlasa = "SELECT * FROM klasa where ID = '$idKlase';";
                        $klasa = mysqli_query($link, $sqlKlasa);
                        $rowKlasa = mysqli_fetch_array($klasa);
                        
                        $idInstruktori = $row['idinstruktori'];
                        $sqlInstruktori = "SELECT * FROM staf where ID =  '$idInstruktori';";
                        $instruktori = mysqli_query($link, $sqlInstruktori);
                        $rowInstruktori = mysqli_fetch_array($instruktori);
                        ?> 

                    <td><?php echo decrypt($rowKlasa['Emri']); ?></td>
                    <td><?php echo decrypt($rowInstruktori['Emri']);?>  <?php echo decrypt($rowInstruktori['Mbiemri']); ?></td>
                    <td><?php echo $row['orari']; ?></td>
                    <td><?php echo $row['data']; ?></td>
                    <td class="text-left"><button onclick="location.href = '../php/ndryshoplanifikim.php?id=<?php echo $row['idkursi'];?>'" >Modifiko</button></td>
                </tr> 
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>