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
                $dega = $row['Degakupunon'];
                $roli = decrypt($row['Roli']);
                $pageRole = "Confirmues";
                $result = strcmp($roli, $pageRole);

				if($result != 0)
				{
                    session_destroy();
                    echo "<script>
                    alert('Session Ended');
                    window.location.href='../html/homepage.html';
                    </script>";
				}
				$fjalakyc= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['search'])));
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
    </head>
    <body>
    <div id="logout">
        <button class="btn btn-secondary" onclick="location.href = 'ConfirmPage.php';" id="myButton" >Ktheu</button>
        <button class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton" >Dil <?php echo decrypt($user) ?></button>
    </div>
        <div id="search">
            <form action="searchamza.php" method="POST"> 
                <input class="form-group mx-sm-3 mb-2" type="text" name="search" id="search" placeholder = "Search">
                <button class="btn btn-secondary" type="submit" id="search-button">Search</button>
            </form>
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
                <th>Amza</th>
                <th>Nr Serie</th>
                <th>Data</th>
                <th>Edito</th>
            </tr>
            <tr>   
               <?php  $sqlquery="Select * from kursantet where Emri LIKE '%{$fjalakyc}%' or Mbiemri LIKE '%{$fjalakyc}%' or Atesia LIKE '%{$fjalakyc}%' or Vendbanimi LIKE '%{$fjalakyc}%' 
               or ID = '$fjalakyc'";
                 $kursantet=mysqli_query($link, $sqlquery);
                 while ($row = mysqli_fetch_array($kursantet)) { ?>

                <td class="text-left"><?php echo decrypt($row['PersonalId']); ?></td>
                <td class="text-left"><?php echo decrypt($row['Emri']); ?></td>
                <td class="text-left"><?php echo decrypt($row['Mbiemri']); ?></td>
                <td class="text-left"><?php echo decrypt($row['Atesia']); ?></td>
                <td class="text-left"><?php echo decrypt($row['Vendbanimi']); ?></td>
                <td class="text-left"><?php echo $row['Telefoni']; ?></td>
                <td class="text-left"><?php echo $row['Datelindja']; ?></td>
                <td class="text-left"><?php echo decrypt($row['Amza']); ?></td>
                <td class="text-left"><?php echo decrypt($row['NrSerisDeshmis']); ?></td>
                <td class="text-left"><?php echo $row['Datakursit']; ?></td>
                <td class="text-left"><button class="btn btn-success" onclick="location.href = '../php/ndryshoamzen.php?id=<?php echo $row['PersonalId'];?>'" >Ploteso Amzen</button><button class="btn btn-danger" onclick="location.href = '../php/fshirregjistrimin.php?id=<?php echo $row['PersonalId'];?>'" >Fshi</button></td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>