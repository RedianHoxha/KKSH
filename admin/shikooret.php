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
            $_SESSION['expire'] = $_SESSION['expire'] + (4 * 60);
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
                $pageRole = "Admindege";
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
    <link rel="stylesheet" type="text/css" href="../css/admindegestilizime.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


    <script>
      function showInformationInstruktor(idInstruktorit) 
      {
          document.getElementById("txtHint").innerHTML = idInstruktorit;
          var muaji  = document.getElementById("muaji").value;
          var data = idInstruktorit.toString();
          if (idInstruktorit == "") 
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
              xmlhttp.open("GET",`afishooretperinstruktor.php?data=${muaji}&id=${idInstruktorit}`,true);
              xmlhttp.send();
          }
      }

      function showInformationMuaj(muaji) 
      {
          document.getElementById("txtHint").innerHTML = muaji;
          var instruktori  = document.getElementById("instruktori").value;
          var data = muaji.toString();
          if (muaji == "") 
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
              xmlhttp.open("GET",`afishooretperinstruktor.php?data=${muaji}&id=${instruktori}`,true);
              xmlhttp.send();
          }
      }
    </script>
</head>
<body>
    <div id="add_button">
        <button class="btn btn-success" onclick="location.href = 'admindege.php';" id="addbutton" >Shiko Planifikimet</button>
        <button class="btn btn-info" onclick="location.href = 'shtoplanifikim.php';" id="addbutton" >Shto Planifikim</button>
        <button class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo decrypt($user) ?></button><br>
    </div>
    <div id="bottom-page">
    <label class="label" for="instruktori" id="selecto">Zgjidh Instruktorin dhe muajin perkates</label>
        <div id="dorpdown">
        
            <div class="form-field col-lg-6 ">
                <select class="form-select" aria-label="Default select example" id="instruktori" name="instruktori" onchange=showInformationInstruktor(this.value)>
                <?php 
                    $roliInstruktorit = encryptValues('Instruktor');
                    $sqlquery="SELECT * FROM staf WHERE Degakupunon = '$dega' AND Roli='$roliInstruktorit'";
                    $qytetet=mysqli_query($link, $sqlquery);
                    while ($row = mysqli_fetch_array($qytetet)) { 
                    $emriInstruktorit =  decrypt($row['Emri'])." ".decrypt($row['Mbiemri']);?>
                <option value="<?php echo $row['ID']; ?>"><?php echo $emriInstruktorit; ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-field col-lg-6 ">
                <!-- <label class="label" for="muaji" id="muaji">Muaji</label> -->
                <select class="form-select" aria-label="Default select example" id="muaji" name="muaji" onchange=showInformationMuaj(this.value)>
                    <option value="1">Janar</option>
                    <option value="2">Shkurt</option>
                    <option value="3">Mars</option>
                    <option value="4">Prill</option>
                    <option value="5">Maj</option>
                    <option value="6">Qeshor</option>
                    <option value="7">Korrik</option>
                    <option value="8">Gusht</option>
                    <option value="9">SHtator</option>
                    <option value="10">Tetor</option>
                    <option value="11">Nentor</option>
                    <option value="12">Dhjetor</option>
                </select>
            </div>
        </div>
        <div>
            <div class="form-field col-lg-12 ">
                <div id="txtHint"></div>
            </div>
        </div>
    </div>
</body>
</html>