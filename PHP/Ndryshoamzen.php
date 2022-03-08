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
                else
                {
                    $idkursanti = $_GET['id'];

                    $kursanti = "select * from kursantet where PersonalId = ?;";
                    $stmt = mysqli_stmt_init($link);
                    if(!mysqli_stmt_prepare($stmt,$kursanti))
                    {
                        echo  'Prove e deshtuar';
                    }
                    else
                    {
                        mysqli_stmt_bind_param($stmt, "s" ,$idkursanti);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row =mysqli_fetch_assoc($result);
                    }
                }
			}
		}
    }
?>

<!DOCTYPE html>
    <head>
        <title>Kryqi i Kuq Shqipetar</title>
        <link href='../css/inputerstyle.css' rel='stylesheet' />
    </head>
    <body>
    <div id="top-page">
        <button onclick="location.href = '../confirm/confirmpage.php';" id="myButton" >Ktheu</button>
        <button onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo decrypt($user) ?></button>
    </div>
        <div id="Form">
            <form action="ruajamzenere.php" method="POST">
                <div id="hello">
                    <p id="hello-p">Welcome :)</p>
                </div>
                <div id="emri">
                    <p id="emri">Emri</p>
                    <input class="input100" id="emri-txt" type="text" 
                    name="emri-txt" value="<?php echo  decrypt($row['Emri']); ?>" required ><br>

                    <p id="atesia">Atesia</p>
                    <input class="input100" id="atesia-txt" type="text" 
                    name="atesia-txt" value="<?php echo  decrypt($row['Atesia']); ?>" required >

                    <p id="mbiemri">Mbiemri</p>
                    <input class="input100" id="mbiemri-txt" type="text" 
                    name="mbiemri-txt" value="<?php echo  decrypt($row['Mbiemri']); ?>"required  ><br>
                </div>
                <div id="id">
                    <p id="id">ID Personale</p>
                    <input class="input100" id="id-txt" type="text" 
                    name="id-txt" value="<?php echo  decrypt($row['PersonalId']); ?>" readonly>
                </div><br>
                <div id="datvendlindje">
                    <p id="datelindja">Datelindja</p>
                    <input class="input100" id="datelindja-txt" type="date" name="datelindja-txt" required value="<?php echo  $row['Datelindja']; ?>">

                    <p id="vendbanim">Venbanim</p>
                    <input class="input100" id="vendbanim-txt" type="text" 
                    name="vendbanim-txt" value="<?php echo  decrypt($row['Vendbanimi']); ?>" required>
                </div>
                <div id="tel">
                    <p id="telefoni">Telefoni</p>
                    <input class="input100" id="tel-txt" type="text" 
                    name="tel-txt" value="<?php echo  $row['Telefoni']; ?>" required>
                </div><br>
                <div id="amza">
                    <p id="amza">Amza (09-989-01)</p>
                    <input class="input100" id="amza-txt" type="text" 
                    name="amza-txt" placeholder="Amza" autocomplete="off" required>
                </div>
                <div id="deshmi">
                    <p id="deshmi">Nr i Seris se Deshmise (070001)</p>
                    <input class="input100" id="deshmi-txt" type="text" 
                    name="deshmi-txt" placeholder="Nr Seris se Deshmis" autocomplete="off" required>
                </div><br>
                <div>
                <button type="submit" id="rregjistro-button">Rregjistro</button>
            </div> 
            </form>
        </div>
    </body> 
</html>