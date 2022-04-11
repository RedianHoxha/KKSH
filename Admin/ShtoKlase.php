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
				$query = "SELECT * FROM staf WHERE ID = '$iduseri';";
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
        <form action="../dao/rregjistroklas.php" method="POST">
            <div id="hello">
              <img src="../images/kkshlogo.PNG" alt="Simply Easy Learning" id="KKSH_logo">
            </div>
            <div id="tedhenapersonale">
                <p id="emri">Emri Klases</p>
                <input class="input100" id="emriklases-txt" type="text" 
                name="emriklases-txt" placeholder="..." autocomplete="off" required ><br>

                <p id="kapaciteti">Kapaciteti</p>
                <input class="input100" id="kapaciteti-txt" type="number" 
                name="kapaciteti-txt"  autocomplete="off" required><br> 
            </div><br><br> 
            <div id="vendodhja">
                <label for="dega">Dega:</label>
                <select    id="dega" name="dega" style="width:15%;" required>

                    <?php $sqlquery="Select * from qyteti";
                    $qytetet=mysqli_query($link, $sqlquery);
                    while ($row = mysqli_fetch_array($qytetet)) { ?>

                <option value="<?php echo $row['EmriDeges']; ?>"><?php echo decrypt($row['EmriDeges']); ?></option>
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
