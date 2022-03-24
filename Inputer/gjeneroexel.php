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
                    window.location.href='../html/homepage.html';
                    </script>";
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
   
<script>
        function showklasCoursant() {
            var klasa = document.getElementById("klasa").value;
            var data = document.getElementById("data").value;
            document.getElementById("txtHint").innerHTML = klasa;
            //var data = klasa.toString();
            if (klasa == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", `generateexelfunction.php?data=${data}&klasa=${klasa}`, true);
                xmlhttp.send();
            }
        }
</script>
</head>
<body>
    <div id="top-page">
        <button class="btn btn-secondary" onclick="location.href = '../inputer/afishokurset.php';" id="myButton" >Shiko Kurset</button>
        <button class="btn btn-secondary" onclick="location.href = '../inputer/bejndryshime.php';" id="myButton" >Bej ndryshime</button>
        <button class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo decrypt($user) ?></button>
    </div>
    <div id="bottom-page">
    <label class="label" for="instruktori" id="selecto">Zgjidh Klasen</label>
        <div id="dorpdown">
            <div class="form-field col-lg-3 ">
                <select class="form-select" aria-label="Default select example" id="klasa" name="klasa" onchange=showklasCoursant()>
                <?php 
                    $sqlquery="SELECT * FROM klasa WHERE Qyteti = '$idDeges'";
                    $qytetet=mysqli_query($link, $sqlquery);
                    while ($row = mysqli_fetch_array($qytetet)) { 
                        $emriKlases = $row['Emri'];
                        ?>
                <option value="<?php echo $row['ID']; ?>"><?php echo decrypt($emriKlases) ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-field col-lg-6 ">
                <label for="start">Data e kursit:</label>
                <input type="date" id="data" name="data" onchange=showklasCoursant()>
            </div>
            <div>
                <button class="btn btn-success" id="button-a" onclick="generateKlasExel()">Create Excel</button> 
            </div>
        </div>
        <div>
        <div id="txtHint"></div>
        </div>
    </div>
</body>
</html>
