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
		}else{
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
				$kursantet=mysqli_query($link, $query);
				$row = mysqli_fetch_array($kursantet);
                $dega = $row['Degakupunon'];

                $sqldega = "SELECT * FROM qyteti WHERE EmriDeges = '$dega'";
                $degaresult = mysqli_query($link, $sqldega);
                $rowdega = mysqli_fetch_array($degaresult);
                $degaid = $rowdega['IDQyteti'];


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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            function showklasCoursant() {
                var klasa = document.getElementById("klasa").value;
                var data = document.getElementById("data").value;
                var orari = document.getElementById("orari").value;
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
                    xmlhttp.open("GET", `afishokursantetperklase.php?data=${data}&klasa=${klasa}&orari=${orari}`, true);
                    xmlhttp.send();
                }
            }

    function saveTable() {
        var table = document.getElementById("tabela-kursanteve");
        var rows = table.getElementsByTagName("tr");
        var tableLength = table.rows.length;
        var i;
        if(tableLength == 1) {
            alert("Nuk ka Asnje rresht per tu rregjistruar");
            return;
        } else {
            for(i=1;i<tableLength; i++){
                var idkursanti = table.rows[i].cells[0].innerHTML;
                var amza = table.rows[i].cells[7].innerHTML;
                var nrseris = table.rows[i].cells[8].innerHTML;
                
                var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("txtHint").innerHTML = this.responseText;
                        }
                    };
                xmlhttp.open("GET", `ruajamzen.php?id=${idkursanti}&amza=${amza}&seri=${nrseris}`, true);
                xmlhttp.send();
            }
        }
    }

        </script>
    </head>
    <body>
    <div id="top-page">
            <div id="logout">
                <button class="btn btn-secondary" onclick="location.href = 'arkiva.php';" id="myButton" >Arkiva</button>
                <button class="btn btn-secondary" onclick="location.href = 'shtokursantpakurs.php';" id="myButton" >Rregjistro Kursant</button>
                <button class="btn btn-secondary" onclick="location.href = 'confirmpageold.php';" id="myButton" >Search</button>
                <button class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton" >Dil <?php echo decrypt($user) ?></button>
            </div>
    </div>
    <div id="selection-criteria">
        <div class="form-field col-lg-3 ">
            <label for="klasa">Zgjidh Klasen:</label></br>
            <select class="form-select" aria-label="Klasa" id="klasa" name="klasa" onchange=showklasCoursant()>
            <?php 
                $sqlquery="SELECT * FROM klasa WHERE Qyteti = '$degaid'";
                $qytetet=mysqli_query($link, $sqlquery);
                while ($row = mysqli_fetch_array($qytetet)) { 
                    $emriKlases = $row['Emri'];
                    ?>
                <option value="<?php echo decrypt($emriKlases) ?>"><?php echo decrypt($emriKlases) ?></option>
            <?php } ?>
            </select>
        </div>
        <div class="form-field col-lg-6 ">
            <label for="data">Data e kursit:</label></br>
            <input type="date" id="data" name="data" onchange=showklasCoursant()></br>
        
            <label for="orari">Orari</label>
            <select class="form-select" aria-label="Default select example" onchange=showklasCoursant() id="orari" name="orari" style="width:30%;" required>
                <option value="9:00 - 13:00">9:00 - 13:00</option>
                <option value="13:00 - 17:00">13:00 - 17:00</option>
                <option value="17:00 - 21:00">17:00 - 21:00</option>
                <option value="09:00 - 15:00">09:00 - 15:00</option>
            </select>
        </div>
    </div>
    <div>
        <div id="txtHint"></div>
    </div>
    </body>
</html>