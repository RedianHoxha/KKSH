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
   <link href='../css/shtostafstyle.css' rel='stylesheet' /> 
</head>
<body>
    <div id="top-page">
        <button onclick="location.href = 'adminpageconfirm.php';" id="myButton" > Home</button>
        <button onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo decrypt($user) ?></button>
    </div>
    <div id="Form">
            <form action="../dao/rregjistrodege.php" method="POST">
                <div id="hello">
                            <img src="../images/kkshlogo.PNG" alt="Simply Easy Learning" id="KKSH_logo">
                </div>
                <div id="tedhenapersonale">
                    <p id="emri">Emri Deges</p>
                    <input class="input100" id="emrideges-txt" type="text" 
                    name="emrideges-txt" placeholder="..." autocomplete="off" required><br>
                    </div><br><br> 
                    <div>
                    <div id="adresa">
                    <p id="adresa">Adresa ne Google Maps</p>
                    <input class="input100" id="adresa-txt" type="text" 
                    name="adresa-txt" placeholder="..." autocomplete="off" required><br>
                    </div><br><br> 
                    <div>
                    <button type="submit" id="rregjistro-button">Rregjistro</button>
                </div>    
        </form>
    </div>
</body>
</html>
