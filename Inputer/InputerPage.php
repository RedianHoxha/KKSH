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
			if($link === false)
			{
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }else
			{
				$query = "SELECT * FROM  staf WHERE ID = '$iduseri';";
                $kursantet=mysqli_query($link, $query);
                $row = mysqli_fetch_array($kursantet);
                $degastafit = $row['Degakupunon'];

                $querydega = "SELECT * FROM  qyteti WHERE EmriDeges = '$degastafit';";
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
                    window.location.href='../panelstaf/index.php';
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
            function showclass(str,idDege) 
            {
                //var param = "data="+str+"idDege="idDege;
                document.getElementById("txtHint").innerHTML = str;
                var data = str.toString();
                if (str == "") 
                {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                } else 
                {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() 
                    {
                        if (this.readyState == 4 && this.status == 200) 
                        {
                            document.getElementById("txtHint").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET",`afishoklasat.php?data=${str}&id=${idDege}`,true);
                    xmlhttp.send();
                }
            }
        </script>
</head>
<body>
    <div id="top-page">
        <button class="btn btn-secondary" onclick="location.href = '../inputer/afishokurset.php';" id="myButton" >Shiko Kurset</button>
        <button class="btn btn-secondary" onclick="location.href = '../inputer/bejndryshime.php';" id="myButton" >Bej ndryshime</button>
        <button class="btn btn-secondary" onclick="location.href = '../inputer/gjeneroexel.php';" id="myButton" >Gjenero Excel</button>
        <button class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo decrypt($user) ?></button>
    </div>
    <div id="Form">
            <form action="../methods/rregjistro.php" method="POST">
                <div id="hello">
                    <p id="hello-p">Welcome</p>
                </div>
                <div id="emri">
                    <p id="emri">Emri</p>
                    <input class="input100" id="emri-txt" type="text" 
                    name="emri-txt" placeholder="Emri" autocomplete="off" required><br>

                    <p id="atesia">Atesia</p>
                    <input class="input100" id="atesia-txt" type="text" 
                    name="atesia-txt" placeholder="Atesia" autocomplete="off" required>

                    <p id="mbiemri">Mbiemri</p>
                    <input class="input100" id="mbiemri-txt" type="text" 
                    name="mbiemri-txt" placeholder="Mbiemri" autocomplete="off" required><br>
                </div>
                <div id="id">
                    <p id="id">ID Personale</p>
                    <input class="input100" id="id-txt" type="text" 
                    name="id-txt" placeholder="ID" autocomplete="off" required>

                    <label for="validationTooltip20" class="form-label">Gjinia</label>
                    <select id="gjinia" name="gjinia"  required>
                        <option selected disabled value=""  style="size:20px">-- Gjinia --</option>
                        <option value="M">Mashkull</option>
                        <option value="F">Femer</option>
                    </select>
                </div><br>
                <div id="datvendlindje">
                    <p id="datelindja">Datelindja</p>
                    <input class="input100" id="datelindja-txt" type="date" name="datelindja-txt" required>
                    <p id="vendbanim">Venbanim</p>
                    <input class="input100" id="vendbanim-txt" type="text" 
                    name="vendbanim-txt" placeholder="Adresa ku banon" autocomplete="off" required>
                </div>
                <div id="tel">
                    <p id="telefoni">Telefoni</p>
                    <input class="input100" id="tel-txt" type="number" 
                    name="tel-txt" placeholder="Telefoni" autocomplete="off" required>
                </div><br>
                <div id="datakursit">
                    <p id="datakursit">Data dhe Orari i Kursit<span style="color:red">   Kontrollo orarin para se te besh rregjistrimin</span></p>
                    <input class="input100" id="datakursit" type="date" name="datakursit" onchange="showclass(this.value, <?php echo $idDeges?>)"><br>
                    <div id="txtHint"></div>
                </div>
                <div>
                    <button class="btn btn-success" type="submit" id="rregjistro-button">Rregjistro</button>
                </div>    
        </form>
    </div>
</body>
</html>
