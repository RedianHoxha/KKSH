<?php
session_start();
require_once('../php/extra_function.php');
$user=$_SESSION['user'];
$iduseri = $_SESSION['UserID'];
$iduserienc = decrypt($_SESSION['UserID']);
$link = mysqli_connect("localhost", "root", "", "kksh");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

$query = "select * from staf where ID = '$iduseri';";
$kursantet=mysqli_query($link, $query);
$row = mysqli_fetch_array($kursantet);
if(decrypt($row['Roli']) <> "Admin")
{
    echo "<script>
    alert('You don't have access to see this page! Session Failed!');
    window.location.href='../html/homepage.html';
    </script>";
}
?>

<!DOCTYPE html>
<head>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script lang="javascript" src="../gjenerofile/xlsx.full.min.js"></script>
        <script lang="javascript" src="../gjenerofile/FileSaver.js"></script>
        <script>
            function showclass() {
                var qyteti =document.getElementById("dega").value;
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                today = dd + '/' + mm + '/' + yyyy;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var result = exportToExel(this.responseText);
                    saveAs(new Blob([s2ab(result)],{type:"application/octet-stream"}), qyteti+'-'+today + '.xlsx');
                }
                };
                xmlhttp.open("GET","../gjenerofile/tedhenat.php?dega="+ qyteti,true);
                xmlhttp.send();
            }
        </script>


<title>Kryqi i Kuq Shqiptar</title>
<link rel="stylesheet" type="text/css" href="../css/admintestimecss.css" />
</head>
<body>
    <div id="top">
        <div id="logout">
            <button onclick="location.href = '../authenticate/logout.php';" id="myButton" >Dil <?php echo decrypt($user) ?></button>                               <label for="dega">Dega:</label>
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
                    var headers = ["Emri","Atesia","Mbiemri","ID","Datelindja","Nr. Rregjistrit Amza","Nr. Serisë Dëshmisë."];
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

                function s2ab(s)
                {
                    var buf = new ArrayBuffer(s.length);
                    var view = new Uint8Array(buf);
                    for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                    return buf;
                    
                }
            </script>

            <button onclick="location.href = '../php';" id="myButton" >Gjenero file javore </button>
        </div>
    </div>

    <div id="bottom">
        <div id="Staf">
            <div>
              <button onclick="location.href = 'shtostaf.php';" id="addbutton" >Shto Staf</button>
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

                        <td><?php echo decrypt($row['Emri']); ?></td>
                        <td><?php echo decrypt($row['Mbiemri']); ?></td>
                        <td><?php echo decrypt($row['Roli']); ?></td>
                        <td><?php echo decrypt($row['Degakupunon']); ?></td>
                        <td><?php echo decrypt($row['Username']); ?></td>
                        <td><?php echo $row['Telefoni']; ?></td>
                    </tr> 
                    <?php } ?>
                </table>
            </div><br>
        </div>
        <div id="Dege">
               <div>
                    <button onclick="location.href = 'shtodege.php';" id="addButton" >Shto Dege</button> 
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
                        <td><?php echo decrypt($row['EmriDeges']); ?></td>
                        </tr> 
                        <?php } ?>
                    </table>
                </div><br>
            </div>
        <div id="Klase">
            <div id="tabela">
                <div>
                 <button onclick="location.href = 'shtoklase.php';" id="addButton" >Shto Klase</button>
                </div>
                <table id="klasa">  
                    <tr>
                        <th>Idetifikimi</th>
                        <th>Qyteti</th>
                        <th>Kapaciteti</th> 
                    </tr>
                    <tr>
                    <?php $sqlquery="Select * from klasa";
                            $klasat=mysqli_query($link, $sqlquery);
                            while ($row = mysqli_fetch_array($klasat)) { 
                                $idQyteti = $row['Qyteti'];
                                $sqlQyetiKlases = "Select * from qyteti where IDQyteti = '$idQyteti';";
                                $dega = mysqli_query($link, $sqlQyetiKlases);
                                $degaRow = mysqli_fetch_array($dega);
                                ?> 
                        <td><?php echo decrypt($row['Emri']);?></td>
                        <td><?php echo decrypt($degaRow['EmriDeges']); ?></td>
                        <td><?php echo $row['Kapaciteti']; ?></td>
                    </tr> 
                    <?php } ?>
                </table>
            </div><br>
        </div>
    </div>
</body>
</html>