<?php 
    session_start();
    require_once('../php/extra_function.php');
    include('../Authenticate/dbconnection.php');
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
            //$link = mysqli_connect("localhost", "root", "", "kksh");
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
   
    <script lang="javascript" src="../gjenerofile/xlsx.full.min.js"></script>
    <script lang="javascript" src="../gjenerofile/FileSaver.js"></script>

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
                xmlhttp.open("GET", `generateexelfunction.php?data=${data}&klasa=${klasa}&orari=${orari}`, true);
                xmlhttp.send();
            }
        }

       function generateKlasExel(){
            var klasa =document.getElementById("klasa").value;
            var dataKursit =document.getElementById("data").value;
            var orari = document.getElementById("orari").value;
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = dd + '/' + mm + '/' + yyyy;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var result = exportToExel(this.responseText);
                saveAs(new Blob([s2ab(result)],{type:"application/octet-stream"}), klasa+'-'+dataKursit+'-'+orari + '.xlsx');
            }
            };
            xmlhttp.open("GET",`../gjenerofile/studentklasa.php?klasa=${klasa}&data=${dataKursit}&orari=${orari}`,true);
            xmlhttp.send();
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
                <option value="<?php echo decrypt($emriKlases) ?>"><?php echo decrypt($emriKlases) ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-field col-lg-6 ">
                <label for="start">Data e kursit:</label></br>
                <input type="date" id="data" name="data" onchange=showklasCoursant()></br>
            
                <label for="orari">Orari</label>
                <select class="form-select" aria-label="Default select example" onchange=showklasCoursant() id="orari" name="orari" style="width:30%;" required>
                  <option value="9:00 - 13:00">9:00 - 13:00</option>
                  <option value="13:00 - 17:00">13:00 - 17:00</option>
                  <option value="17:00 - 21:00">17:00 - 21:00</option>
                </select>
            </div>
            <div>
                <button class="btn btn-success" id="button-a" onclick="generateKlasExel()">Create Excel</button> 
                <script>
                    function exportToExel(dataSource)
                    {
                        var qyteti = document.getElementById("klasa").value;
                        var headers = ["NR.","Datë Rregjistrimi","Anëtarsim","Emër","Mbiemër","Atësia","Datëlindja","Gjinia","Adresa","NID"];
                        console.log(dataSource);
                        var parseData  = JSON.parse(dataSource);
                        parseData.unshift(headers);

                        var wb = XLSX.utils.book_new();
                        wb.Props = {
                                Title: "SheetJS Tutorial",
                                Subject: "Test",
                                Author: "Red Stapler",
                                CreatedDate: new Date(2017,12,19)
                        };

                        wb.SheetNames.push(qyteti);
                        var ws = XLSX.utils.aoa_to_sheet(parseData);
                        wb.Sheets[qyteti] = ws;

                        return XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
                    }

                    function s2ab(s)
                    {
                        var buf = new ArrayBuffer(s.length);
                        var view = new Uint8Array(buf);
                        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                        return buf;
                        
                    }
                </script>
            </div>
        </div>
        <div>
        <div id="txtHint"></div>
        </div>
    </div>
</body>
</html>
