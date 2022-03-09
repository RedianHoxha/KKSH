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
                else{
                    
                    $idkursanti = $_GET['id'];

                    $kursanti = "select * from kursantet where ID = ?;";
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
                        $data = $row['Datakursit'];
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

        <script>
            function showclass(str, idDege) 
            {
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
                    xmlhttp.open("GET",`../inputer/afishoklasat.php?data=${str}&id=${idDege}`,true);
                    xmlhttp.send();
                }
            }
        </script>
    </head>
    <body>
        <div id="fullbody">
            <div id="top-page-left">
                    <button onclick="location.href = '../inputer/bejndryshime.php';" id="myButton" >Ktheu</button>
            </div>
            <div id="Form">
                <form action="../php/ruajndryshimet.php?id=<?php echo $idkursanti; ?>" method="POST">
                    <div id="hello">
                        <p id="hello-p">Welcome :)</p>
                    </div>
                    <div id="emri">
                        <p id="emri">Emri</p>
                        <input class="input100" id="emri-txt" type="text" 
                        name="emri-txt" value="<?php echo decrypt($row['Emri']); ?>" required ><br>

                        <p id="atesia">Atesia</p>
                        <input class="input100" id="atesia-txt" type="text" 
                        name="atesia-txt" value="<?php echo  decrypt($row['Atesia']); ?>" required>

                        <p id="mbiemri">Mbiemri</p>
                        <input class="input100" id="mbiemri-txt" type="text" 
                        name="mbiemri-txt" value="<?php echo  decrypt($row['Mbiemri']); ?>" required><br>
                    </div>
                    <div id="id">
                        <p id="id">ID Personale</p>
                        <input class="input100" id="id-txt" type="text" 
                        name="id-txt" value="<?php echo  decrypt($row['PersonalId']); ?>" required>
                    </div><br>
                    <div id="datvendlindje">
                        <p id="datelindja">Datelindja</p>
                        <input class="input100" id="datelindja-txt" type="date" name="datelindja-txt" value="<?php echo  $row['Datelindja']; ?>" required>

                        <p id="vendbanim">Venbanim</p>
                        <input class="input100" id="vendbanim-txt" type="text" 
                        name="vendbanim-txt" value="<?php echo  decrypt($row['Vendbanimi']); ?>" required>
                    </div>
                    <div id="tel">
                        <p id="telefoni">Telefoni</p>
                        <input class="input100" id="tel-txt" type="number" 
                        name="tel-txt" value="<?php echo  $row['Telefoni']; ?>" required >
                    </div><br>
                    <div id="datakursit">
                    <p id="datakursit">Data dhe Orari i Kursit<span style="color:red">   Kontrollo orarin para se te besh rregjistrimin</span></p>
                    <input class="input100" id="datakursit" type="date" value="<?php echo $data?>" name="datakursit" onchange="showclass(this.value, <?php echo $idDeges?>)"><br>
                    <div id="txtHint"></div>
                    </div>
                    <div>
                        <button type="submit" id="rregjistro-button">Rregjistro</button>
                    </div> 
                </form>
            </div>
        </div>
    </body> 
</html>