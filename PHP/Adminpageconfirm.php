<?php

session_start();
$user=$_SESSION['user'];
$iduseri = $_SESSION['UserID'];
$link = mysqli_connect("localhost", "root", "", "kksh");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

$query = "select * from staf where ID = '$iduseri';";
$kursantet=mysqli_query($link, $query);
$row = mysqli_fetch_array($kursantet);
if($row['Roli'] <> "Admin")
{
    header('location: ../HTML/Homepage.html');
}

// $sqlquery = "select * from kursant;";
// $resultinsert = mysqli_query($link, $sqlquery) or die(mysql_error());


?>

<!DOCTYPE html>
<head>
            <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
            <script lang="javascript" src="../Gjenerofile/xlsx.full.min.js"></script>
            <script lang="javascript" src="../Gjenerofile/FileSaver.js"></script>


            <script>
        function showclass() {
            

            var qyteti =document.getElementById("dega").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("txthint").innerHTML = this.responseText;
        
                var result = exportToExel(this.responseText);
                saveAs(new Blob([s2ab(result)],{type:"application/octet-stream"}), qyteti+ '.xlsx');
              
            }
            };
            xmlhttp.open("GET","../Gjenerofile/tedhenat.php",true);
            xmlhttp.send();
        //}
        }
        </script>


    <title>Kryqi i Kuq Shqipetar</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Admintestimecss.css" />
</head>
<body>
    <div id="top">
        <div id="logout">
            <button onclick="location.href = '../PHP/Logout.php';" id="myButton" >Dil <?php echo $user ?></button>                               <label for="dega">Dega:</label>
                                <select id="dega" name="dega" style="width:15%;">

                                        <?php $sqlquery="Select * from qyteti";
                                            $qytetet=mysqli_query($link, $sqlquery);
                                            while ($row = mysqli_fetch_array($qytetet)) { ?>

                                        <option value="<?php echo $row['EmriDeges']; ?>"><?php echo $row['EmriDeges']; ?></option>
                                        <?php } ?>
                                    </select>

            <button id="button-a" onclick="showclass()">Create Excel</button>

            <script>

            function exportToExel(dataSource)
            {
                 var headers = ["ID","EMri","Mbiemri","Atesia","Datelidnje","data","orari"];
                 var parseData  = JSON.parse(dataSource);
                 parseData.unshift(headers);
                 var qyteti =document.getElementById("dega").value;

                 console.log(parseData);

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

           // 

            
            function s2ab(s)
             {
            
                var buf = new ArrayBuffer(s.length);
                var view = new Uint8Array(buf);
                for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                return buf;
                
            }
                    // $("#button-a").click(function(){
                    // });
            
            </script>

            <button onclick="location.href = '../PHP';" id="myButton" >Gjenero file javore </button>
<div id="txthint"></div>
        </div>
    </div>
    <div id="bottom">
        <div id="Staf">
            <div>
              <button onclick="location.href = 'Shtostaf.php';" id="addbutton" >Shto Staf</button>
            </div>
            <div id="tabela">
                <table id="stafi">  
                    <tr>
                        <th>Emri</th>
                        <th>Mbiemer</th>
                        <th>Rol</th>
                        <th>Dega</th>
                        <th>Username</th>
                        <th>Telefoni</th>
                    </tr>
                    <tr>
                            <?php $sqlquery="Select * from staf";
                            $kursantet=mysqli_query($link, $sqlquery);
                            while ($row = mysqli_fetch_array($kursantet)) { ?> 

                        <td><?php echo $row['Emri']; ?></td>
                        <td><?php echo $row['Mbiemri']; ?></td>
                        <td><?php echo $row['Roli']; ?></td>
                        <td><?php echo $row['Degakupunon']; ?></td>
                        <td><?php echo $row['Username']; ?></td>
                        <td><?php echo $row['Telefoni']; ?></td>

                    </tr> 
                    <?php } ?>
                </table>
            </div><br>
        </div>
        <div id="Dege">
               <div>
                    <button onclick="location.href = 'Shtodege.php';" id="addButton" >Shto Dege</button> 
               </div>
            <div id="tabela">
                    <table id="dega">  
                        <tr>
                            <th>Emri</th>
                        </tr>
                        <tr>
                        <?php $sqlquery="Select * from qyteti";
                            $kursantet=mysqli_query($link, $sqlquery);
                            while ($row = mysqli_fetch_array($kursantet)) { ?> 

                        <td><?php echo $row['EmriDeges']; ?></td>
                        </tr> 
                        <?php } ?>
                    </table>
                </div><br>
            </div>
        <div id="Klase">
            <div id="tabela">
                <div>
                 <button onclick="location.href = 'Shtoklase.php';" id="addButton" >Shto Klase</button>
                </div>
                <table id="klasa">  
                    <tr>
                        <th>Idetifikimi</th>
                        <th>Qyteti</th>
                        <th>Kapaciteti</th> 
                    </tr>
                    <tr>
                    <?php $sqlquery="Select * from klasa";
                            $kursantet=mysqli_query($link, $sqlquery);
                            while ($row = mysqli_fetch_array($kursantet)) { ?> 

                        <td><?php echo $row['Emri']; ?></td>
                        <td><?php echo $row['Qyteti']; ?></td>
                        <td><?php echo $row['Kapaciteti']; ?></td>
                    </tr> 
                    <?php } ?>
                </table>
            </div><br>
        </div>
    </div>
</body>
</html>