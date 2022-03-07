<?php  
    session_start();
    $user=$_SESSION['user'];
    $iduseri = $_SESSION['UserID'];
    $link = mysqli_connect("localhost", "root", "", "kksh");
    $query = "select * from staf where ID = '$iduseri';";
    $kursantet=mysqli_query($link, $query);
    $row = mysqli_fetch_array($kursantet);
    if($row['Roli'] <> "Inputer")
    {
        echo "<script>
        alert('You don't have access to see this page! Session Failed!');
        window.location.href='../html/homepage.html';
        </script>";
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    $fjalakyc= test_input(mysqli_real_escape_string( $link,$_POST['search']));

    if($link === false)
    {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>
<!DOCTYPE html>
    <head>
        <title>Kryqi i Kuq Shqiptar</title>
        <link rel="stylesheet" type="text/css"  href="../css/confirmstilizo.css">
    </head>
    <body>
        <div id="logout">
            <button onclick="location.href = '../authenticate/logout.php';" id="myButton" >Dil <?php echo $user ?></button>
            <button onclick="location.href = 'bejndryshime.php';" id="myButton" >Ktheu</button>
        </div>
        <div id="search">
            <form action="search.php" method="POST"> 
                <input type="text" name="search" id="search" placeholder = "Search" >
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
                <th>Orari</th>
                <th>Edito</th>
            </tr>
            <tr>
               <?php 
               
               if($fjalakyc <> "")
               {
                 $sqlquery="Select * from kursantet where Emri LIKE '%{$fjalakyc}%' or Mbiemri LIKE '%{$fjalakyc}%' or Atesia LIKE '%{$fjalakyc}%' or Vendbanimi LIKE '%{$fjalakyc}%' 
                or ID = '$fjalakyc'";
               }
               else
               {
                $sqlquery="Select * from kursantet";
               }

                 $kursantet=mysqli_query($link, $sqlquery);
                 while ($row = mysqli_fetch_array($kursantet)) { ?>

                <td class="text-left"><?php echo $row['PersonalId']; ?></td>
                <td class="text-left"><?php echo $row['Emri']; ?></td>
                <td class="text-left"><?php echo $row['Mbiemri']; ?></td>
                <td class="text-left"><?php echo $row['Atesia']; ?></td>
                <td class="text-left"><?php echo $row['Vendbanimi']; ?></td>
                <td class="text-left"><?php echo $row['Telefoni']; ?></td>
                <td class="text-left"><?php echo $row['Datelindja']; ?></td>
                <td class="text-left"><?php echo $row['Amza']; ?></td>
                <td class="text-left"><?php echo $row['Datakursit']; ?></td>
                <td class="text-left"><?php echo $row['Orari']; ?></td>

                <td class="text-left"><button onclick="location.href = 'ndryshodatenrregjistrimit.php?id=<?php echo $row['PersonalId'];?>'" >Ndrysho</button><button onclick="location.href = '../php/fshirregjistrimin.php?id=<?php echo $row['PersonalId'];?>'" >Fshi</button></td>
            </tr>
            <?php } ?>
        </table>
    </body>
    
</html>