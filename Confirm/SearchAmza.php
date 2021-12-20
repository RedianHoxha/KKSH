<?php 
    session_start();
    $user=$_SESSION['user'];
    $iduseri = $_SESSION['UserID'];
    $link = mysqli_connect("localhost", "root", "", "kksh");
    $query = "select * from staf where ID = '$iduseri';";
    $kursantet=mysqli_query($link, $query);
    $row = mysqli_fetch_array($kursantet);
    if($row['Roli'] <> "Konfirmues")
    {
        echo "<script>
        alert('You don't have access to see this page! Session Failed!');
        window.location.href='../HTML/Homepage.html';
        </script>";
    }
    if($link === false)
    {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $fjalakyc = mysqli_real_escape_string( $link,$_POST['search']);
?>
<!DOCTYPE html>
    <head>
        <title>Kryqi i Kuq Shqipetar</title>
        <link rel="stylesheet" type="text/css"  href="../CSS/Confirm-stilizo.css">
    </head>
    <body>
    <div id="logout">
        <button onclick="location.href = '../Authenticate/Logout.php';" id="myButton" >Dil <?php echo $user ?></button>
    </div>
        <div id="search">
            <form action="Searchamza.php" method="POST"> 
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
                <th>Data</th>
                <th>Edito</th>
            </tr>
            <tr>   
               <?php  $sqlquery="Select * from kursant where Emri = '$fjalakyc' or Mbiemri = '$fjalakyc' or Atesia = '$fjalakyc' or Vendbanimi = '$fjalakyc' 
               or ID = '$fjalakyc'";
                 $kursantet=mysqli_query($link, $sqlquery);
                 while ($row = mysqli_fetch_array($kursantet)) { ?>

                <td class="text-left"><?php echo $row['ID']; ?></td>
                <td class="text-left"><?php echo $row['Emri']; ?></td>
                <td class="text-left"><?php echo $row['Mbiemri']; ?></td>
                <td class="text-left"><?php echo $row['Atesia']; ?></td>
                <td class="text-left"><?php echo $row['Vendbanimi']; ?></td>
                <td class="text-left"><?php echo $row['Telefoni']; ?></td>
                <td class="text-left"><?php echo $row['Datelindja']; ?></td>
                <td class="text-left"><?php echo $row['Amza']; ?></td>
                <td class="text-left"><?php echo $row['Datakursit']; ?></td>
                <td class="text-left"><button onclick="location.href = '../PHP/NdryshoAmzen.php?id=<?php echo $row['ID'];?>'" >Ploteso Amzen</button></td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>