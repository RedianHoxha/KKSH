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
        window.location.href='../html/homepage.html';
        </script>";
    }
    if($link === false)
    {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    $fjalakyc = test_input(mysqli_real_escape_string( $link,$_POST['search']));
?>
<!DOCTYPE html>
    <head>
        <title>Kryqi i Kuq Shqipetar</title>
        <link rel="stylesheet" type="text/css"  href="../css/confirmstilizo.css">
    </head>
    <body>
    <div id="logout">
        <button onclick="location.href = '../authenticate/logout.php';" id="myButton" >Dil <?php echo $user ?></button>
    </div>
        <div id="search">
            <form action="searchamza.php" method="POST"> 
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
               <?php  $sqlquery="Select * from kursant where Emri LIKE '%{$fjalakyc}%' or Mbiemri LIKE '%{$fjalakyc}%' or Atesia LIKE '%{$fjalakyc}%' or Vendbanimi LIKE '%{$fjalakyc}%' 
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
                <td class="text-left"><button onclick="location.href = '../php/ndryshoamzen.php?id=<?php echo $row['ID'];?>'" >Ploteso Amzen</button><button onclick="location.href = '../php/fshirregjistrimin.php?id=<?php echo $row['ID'];?>'" >Fshi</button></td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>