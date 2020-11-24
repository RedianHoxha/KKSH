<?php 
            
            session_start();
            $user=$_SESSION['user'];
            //require('session.php');
            $iduseri = $_SESSION['UserID'];
            $link = mysqli_connect("localhost", "root", "", "kksh");
            //echo $iduseri;
    
            $query = "select * from staf where ID = '$iduseri';";
            $kursantet=mysqli_query($link, $query);
            $row = mysqli_fetch_array($kursantet);
            //echo $row['Roli'];
            if($row['Roli'] <> "Inputer")
            {
                header('location: ../HTML/Homepage.html');
            }

            $fjalakyc= mysqli_real_escape_string( $link,$_POST['search']);

        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
           

}?>
<!DOCTYPE html>
    <head>
        <title>Kryqi i Kuq Shqipetar</title>
        <link rel="stylesheet" type="text/css"  href="../CSS/Confirm-stilizo.css">
    </head>
    <body>
        <div id="logout">
            <button onclick="location.href = '../PHP/Logout.php';" id="myButton" >Dil <?php echo $user ?></button>
            <button onclick="location.href = '../PHP/Bejndryshime.php';" id="myButton" >Ktheu</button>
        </div>
        <div id="search">
            <form action="Search.php" method="POST"> 
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
                <th>Orari</th>
                <th>Edito</th>
            </tr>


            <tr>
               
               <?php 
               
               if($fjalakyc <> "")
               {
               
                         $sqlquery="Select * from kursant where Emri = '$fjalakyc' or Mbiemri = '$fjalakyc' or Atesia = '$fjalakyc' or Vendbanimi = '$fjalakyc' 
                or ID = '$fjalakyc'";
               }
               else
               {
                $sqlquery="Select * from kursant";
               }

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
                <td class="text-left"><?php echo $row['Orari']; ?></td>

                <td class="text-left"><button onclick="location.href = 'Ndryshodatenrregjistrimit.php?id=<?php echo $row['ID'];?>'" >Ndrysho</button></td>
            </tr>
            <?php } ?>
        </table>
    </body>
    
</html>