<!DOCTYPE html>

<head>
    <title>Kryqi i Kuq Shqipetar</title>
    <link rel="stylesheet" type="text/css" href="../css/homepagestilizime.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>       
    
</head>

<body>

    <img src="../images/kkshlogo.PNG" alt="Simply Easy Learning" id="KKSH_logo">
    <div id="form">
        <form action="../Authenticate/Login.php" method="POST">
            <div class="wrap-input100">
                <p id="username">Username</p>
                <input class="input100" id="username-txt" type="text" name="username" placeholder="Username"
                    autocomplete="off" required>
            </div><br>
            <div class="wrap-input100">
                <p id="password">Password</p>
                <input class="input100" id="password-txt" type="password" name="password" placeholder="Password"
                    autocomplete="off" required>
            </div><br>
            <div>
                <div class="g-recaptcha" data-sitekey="6LfwjbwdAAAAAIjvSq7c6CXVKuA3BRy5vs8TMAJX">

                </div>
            </div>
            <div>
                <button class="btn btn-success" type="submit" id="login-button">Login</button>
            </div>
        </form>
    </div>
</body>

</html>