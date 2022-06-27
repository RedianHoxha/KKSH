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
                $pageRole = "Admin";
                $result = strcmp($roli, $pageRole);

				if($result != 0)
				{
                    session_destroy();
                    echo "<script>
                    alert('Session Ended');
                    window.location.href='../panelstaf/index.php';
                    </script>";
				}
			}
		}
    }
?>

<!DOCTYPE html>
<head>
    <title>Kryqi i Kuq Shqiptar</title>
   <link href='../css/shtostafstyle.css' rel='stylesheet' /> 
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    <div id="top-page">
        <button class="btn btn-secondary" onclick="location.href = 'adminpageconfirm.php';" id="myButton" > Home</button>
        <button class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo decrypt($user) ?></button>
    </div>
    <div id="Form">
        <form action="../dao/rregjistrostaf.php" method="POST">
            <div id="hello">
                <img src="../images/kkshlogo.png" alt="Simply Easy Learning" id="KKSH_logo">
            </div>
            <div id="tedhenapersonale">
                <p id="emri">Emri</p>
                <input class="input100" id="emri-txt" type="text" 
                name="emri-txt" placeholder="..." autocomplete="off" required><br>

                <p id="mbiemri">Mbiemri</p>
                <input class="input100" id="mbiemri-txt" type="text" 
                name="mbiemri-txt" placeholder="..." autocomplete="off" required ><br>
                
                <p id="id">ID Personale</p>
                <input class="input100" id="id-txt" type="text" 
                name="id-txt" placeholder="..." autocomplete="off" required>
            </div><br><br>
            <div id="tedhenalogimi">    
                <p id="username">Username</p>
                <input class="input100" id="username-txt" type="text" 
                name="username-txt" placeholder="..." autocomplete="off" required>

                <p id="password">Password</p>
                <input class="input100" id="password-txt" type="password" 
                name="password-txt" placeholder="..." autocomplete="off" required><br><br>

                <label for="roli">Roli i Personelit:</label>
                <select class="form-select" aria-label="Default select example" id="roli" name="roli" required>
                    <option value="Inputer">Inputer</option>
                    <option value="Confirmues">Confirmues</option>
                    <option value="Admindege">Admin Dege</option>
                    <option value="Instruktor">Instruktor</option>
                    <option value="Admin">Admin</option>
                </select>
            </div><br><br>
            <div id="tedhenakontakti">
                <p id="telefoni">Telefoni</p>
                <input class="input100" id="tel-txt" type="text" 
                name="tel-txt" placeholder="..." autocomplete="off" required><br>

                <label for="dega">Qyteti:</label>
                <select class="form-select" aria-label="Default select example" id="dega" name="dega"  required>
                <?php $sqlquery="Select * from qyteti";
                    $qytetet=mysqli_query($link, $sqlquery);
                    while ($row = mysqli_fetch_array($qytetet)) { ?>
                <option value="<?php echo decrypt($row['EmriDeges']);?>"><?php echo decrypt($row['EmriDeges']);?></option>
                <?php } ?>
                </select>
            </div>
            <div>
                <button class="btn btn-success" type="submit" id="rregjistro-button">Rregjistro</button>
            </div>    
        </form>
    </div>
</body>
</html>
