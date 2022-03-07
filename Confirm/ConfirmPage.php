<?php 
    session_start();    
    require_once('../php/extra_function.php');
    $user=$_SESSION['user'];
    $iduseri = $_SESSION['UserID'];
    $link = mysqli_connect("localhost", "root", "", "kksh");
    $query = "select * from staf where ID = '$iduseri';";
    $kursantet=mysqli_query($link, $query);
    $row = mysqli_fetch_array($kursantet);
    if(decrypt($row['Roli']) <> "Confirmues")
    {
        echo "<script>
        alert('You don't have access to see this page! Session Failed!');
        window.location.href='../html/homepage.html';
        </script>";
    }
    if($link === false)
    {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>
<!DOCTYPE html>
    <head>
        <title>Kryqi i Kuq Shqipetar</title>
        <link rel="stylesheet" type="text/css"  href="../css/confirmstilizo.css">
    </head>
    <body>
    <div id="logout">
            <button onclick="location.href = '../authenticate/logout.php';" id="myButton" >Dil <?php echo decrypt($user) ?></button>
        </div>
        <div id="search">
            <form action="SearchAmza.php" method="POST"> 
                <input type="text" name="search" id="search" placeholder = "Search">
                <button type="submit" id="search-button">Search</button>
            </form>
        </div>
        <table id="tabela-kursanteve" >
            <tr>
                <th>ID</th>
                <th>Emri</th>
                <th>Mbiemri</th>
                <th>Atesia</th>
                <th>Vendbanimi</th>
                <th>Telefoni</th>
                <th>Datelindja</th>
                <th>Amza</th>
                <th>Nr Serie</th>
                <th>Data</th>
                <th>Edito</th>
            </tr>
            <tr>
               <?php $sqlquery="Select * from kursantet";
                 $kursantet=mysqli_query($link, $sqlquery);
                 while ($row = mysqli_fetch_array($kursantet)) { ?>

                <td class="text-left"><?php echo decrypt($row['PersonalId']); ?></td>
                <td class="text-left"><?php echo decrypt($row['Emri']); ?></td>
                <td class="text-left"><?php echo decrypt($row['Mbiemri']); ?></td>
                <td class="text-left"><?php echo decrypt($row['Atesia']); ?></td>
                <td class="text-left"><?php echo decrypt($row['Vendbanimi']); ?></td>
                <td class="text-left"><?php echo $row['Telefoni']; ?></td>
                <td class="text-left"><?php echo $row['Datelindja']; ?></td>
                <td class="text-left"><?php echo decrypt($row['Amza']); ?></td>
                <td class="text-left"><?php echo decrypt($row['NrSerisDeshmis']); ?></td>
                <td class="text-left"><?php echo $row['Datakursit']; ?></td>
                <td class="text-left"><button onclick="location.href = '../php/ndryshoamzen.php?id=<?php echo decrypt($row['ID']);?>'" >Ploteso Amzen</button></td>
            </tr>
            <?php } ?>
        </table>

    </body>
    
</html>