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
                $pageRole = "Admindege";
                $result = strcmp($roli, $pageRole);

				if($result != 0)
				{
                    session_destroy();
                    echo "<script>
                    alert('Session Ended');
                    window.location.href='../html/homepage.html';
                    </script>";
				}
                else{

                    $queryqyteti = "select * from qyteti where EmriDeges = '$dega';";
                    $klasa=mysqli_query($link, $queryqyteti);
                    $row = mysqli_fetch_array($klasa);
                    $idqyteti = $row['IDQyteti'];

                }
			}
		}
}
?>

<!DOCTYPE html>
<head>
    <title>Kryqi i Kuq Shqiptar</title>
    <link rel="stylesheet" type="text/css" href="../css/admindegestilizime.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    
<button class="btn btn-info" onclick="location.href = '../admin/admindege.php';" id="myButton" > Ktheu</button>
<button class="btn btn-info" onclick="location.href = 'shikooret.php';" id="addbutton" >Shiko Oret</button>
<button class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo decrypt($user) ?></button><br>
    <img src="../images/kkshlogo.PNG" alt="Simply Easy Learning" id="KKSH_logo">
    <p id="welcome">Welcome</p><br>
    <div id="form">
        <form action="../dao/rregjistrotimetable.php" method="POST">
            <div id="instruktori">
                <label for="instruktori">Instruktori:</label>
                    <select class="form-select" aria-label="Default select example" id="instruktori-input" name="instruktori" style="width:15%;">
                    <?php 
                        $roli = encryptValues("Instruktor");
                        $sqlqueryinstruktori="Select * from staf where Degakupunon = '$dega' and Roli ='$roli'";
                        $instruktoret=mysqli_query($link, $sqlqueryinstruktori);
                        while ($row = mysqli_fetch_array($instruktoret)) { 
                    ?>
                    <option value="<?php echo $row['ID']; ?>"><?php echo decrypt($row['Emri'])?> <?php echo decrypt($row['Mbiemri'])?></option>
                    <?php } ?>
                    </select>
            </div>
            <br>
            <div id="klasa">
                <label for="klasa">Klasa:</label>
                    <select class="form-select" aria-label="Default select example" id="klasa-input" name="klasa" style="width:15%;">
                    <?php 
                        $sqlklasa="Select * from klasa where Qyteti = '$idqyteti'";
                        $klasa=mysqli_query($link, $sqlklasa);
                        while ($row = mysqli_fetch_array($klasa)) { 
                    ?>
                    <option value="<?php echo $row['ID']; ?>"><?php echo decrypt($row['Emri'])?></option>
                    <?php } ?>
                    </select>
            </div>
            <div id="datakursit">
                <p id="datakursit">Data dhe Orari i Kursit</p>
                <input class="input100" id="datakursit" type="date" name="datakursit" required><br>

                <label for="orari"></label>
                <select class="form-select" aria-label="Default select example" id="orari" name="orari" style="width:15%;" required>
                  <option value="9:00 - 13:00">9:00 - 13:00</option>
                  <option value="13:00 - 17:00">13:00 - 17:00</option>
                  <option value="17:00 - 21:00">17:00 - 21:00</option>

                </select>
            </div><br>  
            <div>
                <button class="btn btn-success" type="submit" id="save-button">Rregjistro</button>
            </div> 
       </form>
    </div>
</body>
</html>