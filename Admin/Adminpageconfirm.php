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
				$query = "SELECT * FROM staf WHERE ID = '$iduseri';";
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
                    window.location.href='../panelstaf/index.php';
                    </script>";
				}
			}
		}
    }
?>

<!DOCTYPE html>
<head>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <script lang="javascript" src="../gjenerofile/xlsx.full.min.js"></script>
        <script lang="javascript" src="../gjenerofile/FileSaver.js"></script>
        <script>
            function generate() {
                var qyteti =document.getElementById("dega").value;
                var start =document.getElementById("start").value;
                var end =document.getElementById("end").value;
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
                xmlhttp.open("GET",`../gjenerofile/tedhenat.php?dega=${qyteti}&start=${start}&end=${end}`,true);
                xmlhttp.send();
            }
        </script>


<title>Kryqi i Kuq Shqiptar</title>
<link rel="stylesheet" type="text/css" href="../css/admintestimecss.css" />
</head>
<body>
    <div id="top">
        <div id="logout">
            <label for="start">Start:</label>
            <input type="date" id="start" name="start">
            <label for="end">End:</label>
            <input type="date" id="end" name="end">
            <label for="dega">Dega:</label>
            <select id="dega" name="dega" >
                    <?php $sqlquery="SELECT * FROM qyteti";
                        $qytetet=mysqli_query($link, $sqlquery);
                        while ($row = mysqli_fetch_array($qytetet)) { ?>

                    <option value="<?php echo decrypt($row['EmriDeges']); ?>"><?php echo decrypt($row['EmriDeges']);?></option>
                    <?php } ?>
            </select>
            <button class="btn btn-success" id="button-a" onclick="generate()">Gjenero Excel</button>   
            <button class="btn btn-success" id="button-a" onclick="location.href = 'adminarkiva.php';">Arkiva</button>         
            <button class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton" >Dil <?php echo decrypt($user) ?></button>          
            <script>
                function exportToExel(dataSource)
                {
                    var qyteti = document.getElementById("dega").value;
                    console.log(qyteti);
                    var headers = ["Emri","Atesia","Mbiemri","ID","Datelindja","Nr. Rregjistrit Amza","Nr. Serisë Dëshmisë."];
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

            <!-- <button onclick="location.href = '../php';" id="myButton" >Gjenero file javore </button> -->
        </div>
    </div>

    <div id="bottom">
        <div id="Staf">
            <div>
              <button  class="btn btn-success" onclick="location.href = 'shtostaf.php';" id="addbutton" >Shto Staf</button>
            </div>
            <div id="tabela">
                
                <table id="stafi" class="table table-bordered">  
                    <tr>
                        <th>Personale ID</th>
                        <th>Emri</th>
                        <th>Mbiemer</th>
                        <th>Rol</th>
                        <th>Dega</th>
                        <th>Username</th>
                        <th>Telefoni</th>
                        <th>Edito</th>
                    </tr>
                    <tr>
                    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script>

                    $(document).ready(function() {
                    $('#stafi').after('<div id="nav"></div>');
                    var rowsShown = 5;
                    var rowsTotal = $('#stafi tbody tr').length;
                    var numPages = rowsTotal / rowsShown;
                    for (i = 0; i < numPages; i++) {
                        var pageNum = i + 1;
                        // var r= $('<input type="button" value="new button"/>');
                        $('#nav').append('<a href="#" class="btn" rel="' + i + '">' + pageNum + '</a> ');
                        //$('#nav').append(r);
                    }
                    $('#stafi tbody tr').hide();
                    $('#stafi tbody tr').slice(0, rowsShown).show();
                    $('#nav a:first').addClass('active');
                    $('#nav a').bind('click', function() {

                        $('#nav a').removeClass('active');
                        $(this).addClass('active');
                        var currPage = $(this).attr('rel');
                        var startItem = currPage * rowsShown;
                        var endItem = startItem + rowsShown;
                        $('#stafi tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).
                        css('display', 'table-row').animate({
                        opacity: 1
                        }, 300);
                    });
                });
                </script>
                        <?php $sqlquery="SELECT * FROM staf";
                        $kursantet=mysqli_query($link, $sqlquery);
                        while ($row = mysqli_fetch_array($kursantet)) { ?> 
                        <td><?php echo decrypt($row['ID']); ?></td>
                        <td><?php echo decrypt($row['Emri']); ?></td>
                        <td><?php echo decrypt($row['Mbiemri']); ?></td>
                        <td><?php echo decrypt($row['Roli']); ?></td>
                        <td><?php echo decrypt($row['Degakupunon']); ?></td>
                        <td><?php echo decrypt($row['Username']); ?></td>
                        <td><?php echo $row['Telefoni']; ?></td>
                        <td class="text-left"><button  class="btn btn-info" onclick="location.href = '../methods/modifikostaf.php?id=<?php echo $row['UniqueId'];?>'" >Modifiko</button><button  class="btn btn-danger" onclick="location.href = '../methods/fshiuser.php?id=<?php echo $row['UniqueId'];?>'" >Fshi</button></td>
                    </tr> 
                    <?php } ?>
                </table>
            </div><br>
        </div>
        <div id="Klase">
            <div id="tabela">
                <div>
                 <button class="btn btn-success" onclick="location.href = 'shtoklase.php';" id="addButton" >Shto Klase</button>
                </div>
                <!-- <script>

                    $(document).ready(function() {
                    $('#klasa').after('<div id="nav"></div>');
                    var rowsShown = 12;
                    var rowsTotal = $('#klasa tbody tr').length;
                    var numPages = rowsTotal / rowsShown;
                    for (i = 0; i < numPages; i++) {
                        var pageNum = i + 1;
                        $('#nav').append('<a href="#" rel="' + i + '">' + pageNum + '</a> ');
                    }
                    $('#klasa tbody tr').hide();
                    $('#klasa tbody tr').slice(0, rowsShown).show();
                    $('#nav a:first').addClass('active');
                    $('#nav a').bind('click', function() {

                        $('#nav a').removeClass('active');
                        $(this).addClass('active');
                        var currPage = $(this).attr('rel');
                        var startItem = currPage * rowsShown;
                        var endItem = startItem + rowsShown;
                        $('#klasa tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).
                        css('display', 'table-row').animate({
                        opacity: 1
                        }, 300);
                    });
                });
                </script> -->

                <table id="klasa" class="table table-bordered">  
                    <tr>
                        <th>Idetifikimi</th>
                        <th>Qyteti</th>
                        <th>Kapaciteti</th> 
                        <th>Edito</th> 
                    </tr>
                    <tr>
                    <?php $sqlquery="SELECT * FROM klasa";
                            $klasat=mysqli_query($link, $sqlquery);
                            while ($row = mysqli_fetch_array($klasat)) { 
                                $idQyteti = $row['Qyteti'];
                                $sqlQyetiKlases = "SELECT * FROM qyteti WHERE IDQyteti = '$idQyteti';";
                                $dega = mysqli_query($link, $sqlQyetiKlases);
                                $degaRow = mysqli_fetch_array($dega);
                                ?> 
                        <td><?php echo decrypt($row['Emri']);?></td>
                        <td><?php echo decrypt($degaRow['EmriDeges']); ?></td>
                        <td><?php echo $row['Kapaciteti']; ?></td>
                        <td><button class="btn btn-danger" onclick="location.href = '../dao/fshiklase.php?id=<?php echo $row['ID'];?>'" >Fshi</button></td>
                        </tr> 
                    <?php } ?>
                </table>
            </div><br>
        </div>
        <div id="Dege">
               <div>
                    <button class="btn btn-success" onclick="location.href = 'shtodege.php';" id="addButton" >Shto Dege</button> 
               </div>
            <div id="tabela">
                    <table id="dega" class="table table-bordered">  
                        <tr>
                            <th>Emri</th>
                            <th>Edito</th>
                        </tr>
                        <tr>
                        <?php $sqlquery="SELECT * FROM qyteti";
                            $kursantet=mysqli_query($link, $sqlquery);
                            while ($row = mysqli_fetch_array($kursantet)) { ?> 
                        <td><?php echo decrypt($row['EmriDeges']); ?></td>
                        <td><button class="btn btn-danger" onclick="location.href = '../dao/fshidege.php?id=<?php echo $row['IDqyteti'];?>'" >Fshi</button></td>
                        </tr> 
                        <?php } ?>
                    </table>
                </div><br>
            </div>

    </div>
</body>
</html>