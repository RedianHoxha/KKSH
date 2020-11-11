<?php 
            
            session_start();
            $user=$_SESSION['user'];
            $link = mysqli_connect("localhost", "root", "", "kksh");
            //echo $user;
    
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
}?>


<!DOCTYPE html>
<head>
    <title>Kryqi i Kuq Shqipetar</title>
   <link href='../CSS/Shtostafstyle.css' rel='stylesheet' /> 
</head>
<body>
    <div id="top-page">
        <button onclick="location.href = '../PHP/Adminpage.php';" id="myButton" > Home</button>
        <button onclick="location.href = '../PHP/Logout.php';" id="myButton" > Dil <?php echo $user ?></button>
    </div>
    <div id="Form">
            <form action="../PHP/Rregjistrostaf.php" method="POST">
                        <div id="hello">
                                 <img src="../Images/KKSH_logo.PNG" alt="Simply Easy Learning" id="KKSH_logo">
                        </div>
                        <div id="tedhenapersonale">
                            <p id="emri">Emri</p>
                            <input class="input100" id="emri-txt" type="text" 
                            name="emri-txt" placeholder="..." autocomplete="off"><br>

                            <p id="mbiemri">Mbiemri</p>
                            <input class="input100" id="mbiemri-txt" type="text" 
                            name="mbiemri-txt" placeholder="..." autocomplete="off"><br>
                            
                            
                                <p id="id">ID Personale</p>
                                <input class="input100" id="id-txt" type="text" 
                                name="id-txt" placeholder="..." autocomplete="off">
                        </div><br><br>


                        <div id="tedhenalogimi">    
                            <p id="username">Username</p>
                            <input class="input100" id="username-txt" type="text" 
                            name="username-txt" placeholder="..." autocomplete="off">

                            <p id="password">Password</p>
                            <input class="input100" id="password-txt" type="password" 
                            name="password-txt" placeholder="..." autocomplete="off"><br><br>

                            <label for="roli">Roli i Personelit:</label>
                            <select id="roli" name="roli" style="width:15%;">
                              <option value="Inputer">Inputer</option>
                              <option value="Confirmues">Konfirmues</option>
                            </select>
                        </div><br><br>
                        <div id="tedhenakontakti">
                                <p id="telefoni">Telefoni</p>
                                <input class="input100" id="tel-txt" type="text" 
                                name="tel-txt" placeholder="..." autocomplete="off">
        
                            
                                <label for="dega">Dega e Kursantit:</label>
                                <select id="dega" name="dega" style="width:15%;">
                                <option value="Tirane">Tirane</option>
                                <option value="Durres">Durres</option>
                                <option value="Shkoder">Shkoder</option>
                                <option value="Trropoje">Trropoje</option>
                                <option value="Malesi e madhe">Malesi e madhe</option>
                                <option value="Vlore">Vlore</option>
                                <option value="Fier">Fier</option>
                                <option value="Lushnje">Lushnje</option>
                                <option value="Elbasan">Elbasan</option>
                                <option value="Librazhd">Librazhd</option>
                                <option value="Pogradec">Pogradec</option>
                                <option value="Korce">Korce</option>
                                </select>
                            
                        </div>
                        <div>
                            <button type="submit" id="rregjistro-button">Rregjistro</button>
                        </div>    
        </form>
    </div>
</body>
</html>
