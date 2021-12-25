<?php 
            session_start();
            $user=$_SESSION['user'];
            $iduseri = $_SESSION['UserID'];
            $link = mysqli_connect("localhost", "root", "", "kksh");
    
            $query = "select * from staf where ID = '$iduseri';";
            $kursantet=mysqli_query($link, $query);
            $row = mysqli_fetch_array($kursantet);
            if($row['Roli'] <> "Admin")
            {
                echo "<script>
                alert('You don't have access to see this page! Session Failed!');
                window.location.href='../html/homepage.html';
                </script>";
            }
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
}?>


<!DOCTYPE html>
<head>
    <title>Kryqi i Kuq Shqiptar</title>
   <link href='../css/shtostafstyle.css' rel='stylesheet' /> 
</head>
<body>
    <div id="top-page">
        <button onclick="location.href = 'adminpageconfirm.php';" id="myButton" > Home</button>
        <button onclick="location.href = '../authenticate/logout.php';" id="myButton" > Dil <?php echo $user ?></button>
    </div>
    <div id="Form">
        <form action="../dao/rregjistroklas.php" method="POST">
            <div id="hello">
              <img src="../images/kkshlogo.PNG" alt="Simply Easy Learning" id="KKSH_logo">
            </div>
            <div id="tedhenapersonale">
                <p id="emri">Emri Klases</p>
                <input class="input100" id="emriklases-txt" type="text" 
                name="emriklases-txt" placeholder="..." autocomplete="off"><br>

                <p id="kapaciteti">Kapaciteti</p>
                <input class="input100" id="kapaciteti-txt" type="number" 
                name="kapaciteti-txt"  autocomplete="off"><br> 
            </div><br><br> 
            <div id="vendodhja">
                <label for="dega">Dega:</label>
                <select id="dega" name="dega" style="width:15%;">

                    <?php $sqlquery="Select * from qyteti";
                    $qytetet=mysqli_query($link, $sqlquery);
                    while ($row = mysqli_fetch_array($qytetet)) { ?>

                <option value="<?php echo $row['EmriDeges']; ?>"><?php echo $row['EmriDeges']; ?></option>
                <?php } ?>
                </select> 
            </div>
            <div>
                <button type="submit" id="rregjistro-button">Rregjistro</button>
            </div>    
        </form>
    </div>
</body>
</html>
