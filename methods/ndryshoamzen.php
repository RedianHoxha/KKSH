<?php 
    session_start();
    require_once('../methods/extra_function.php');
    include('../authenticate/dbconnection.php');
    if (!isset($_SESSION['user'])) {
        echo "Please Login again";
        session_destroy();
            echo "<script>
            alert('Session Ended');
            window.location.href='../panelstaf/index.php';
            </script>";
        
    }else{
        $now = time();
		if ($now > $_SESSION['expire']) {
			session_destroy();
            echo "<script>
            alert('Session Ended');
            window.location.href='../panelstaf/index.php';
            </script>";
		}else
		{
			$user=$_SESSION['user'];
            $iduseri = $_SESSION['UserID'];
            $_SESSION['expire'] = $_SESSION['expire'] + (3 * 60);
            //$link = mysqli_connect("localhost", "root", "", "kksh");
			if($link === false)
			{
                    die("ERROR: Could not connect. " . mysqli_connect_error());
            }else
			{
				$query = "SELECT * FROM  staf WHERE ID = '$iduseri';";
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
                    window.location.href='../panelstaf/index.php';
                    </script>";
				}
                else
                {
                    $idkursanti = $_GET['id'];

                    $kursanti = "SELECT * FROM  kursantet WHERE ID = ?;";
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    </head>
    <body>
    <div id="top-page">
        <button  class="btn btn-secondary" onclick="location.href = '../confirm/confirmpage.php';" id="myButton" >Ktheu</button>
        <button  class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo decrypt($user) ?></button>
    </div>
        <div id="Form">
            <form action="ruajamzenere.php?id=<?php echo $idkursanti; ?>" method="POST">
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
                <button class="btn btn-success" type="submit" id="rregjistro-button">Rregjistro</button>
            </div> 
            </form>
        </div>
    </body> 
</html>