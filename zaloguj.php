<?php
    session_start();
    if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true)){
        header('Location: index.php');
        exit();
    }
    if(isset($_POST['login2'])){

    date_default_timezone_set("Europe/Warsaw");
    date_default_timezone_get();

    require_once "connect.php";
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

    if ($polaczenie->connect_error) {
        die ("Błąd połączenia: " . $polaczenie->connect_error);
    }

        $login = $_POST['login2'];
        $haslo = $_POST['haslo']; 

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");

        if($wynik = $polaczenie->query(sprintf("SELECT * FROM users WHERE nick='%s'",
        mysqli_real_escape_string($polaczenie,$login)))){
            $ile_userow = $wynik->num_rows;
            if($ile_userow>0){
                $wiersz = $wynik->fetch_assoc();

                if(password_verify($haslo, $wiersz['password'])){
                    $_SESSION['nick'] = $wiersz['nick'];
                    $_SESSION['czyAdmin'] = $wiersz['admin'];
                    $_SESSION['zalogowany'] = true;
                    $_SESSION['id'] = $wiersz['id'];
                    $_SESSION['guest'] = false;
                    $wynik->close();
                    header('Location: index.php'); 
                }
                else{
                    $_SESSION['blad']= "Niepoprawny nick lub hasło!";
                    header("Location: zaloguj.php");
                }
            }else{
                $_SESSION['blad']= "Niepoprawny nick lub hasło!";
            }
        }
        $polaczenie->close();
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Chińczyk 2077 - Logowanie</title>
        <link href="css/everySite.css" type="text/css" rel="stylesheet">
        <link href="css/logowanie.css" type="text/css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/check_nick_and_servers.js" type="text/javascript"></script>
        <script src="js/loginJS.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container" id="container">
            <div class="form-container sign-up-container">
                <form action="register.php" method="POST">
                    <h1 style="color: gray">Stwórz konto</h1>
                    <input required placeholder="Login" type="text" name="login"/>
                    <input required placeholder="Hasło" type="password" name="password1"/>
                    <input required placeholder="Powtórz hasło" type="password" name="password2"/>
                    <button style="cursor: pointer;">Zarejestruj się</button>
                </form>
            </div>
            <div class="form-container sign-in-container">
                <form action="zaloguj.php" method="post">
                    <h1 style="color: gray">Zaloguj się</h1>
                    <input required name="login2" type="text" placeholder="Login" />
                    <input required name="haslo" type="password" placeholder="Hasło" />
                    <button style="cursor: pointer;">Zaloguj się</button>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Witaj!</h1>
                        <p style="font-weight: 400">Jeżeli masz już konto, możesz się zalogować!</p>
                        <button style="cursor: pointer;" class="ghost" id="signIn">Logowanie</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Witaj!</h1>
                        <p style="font-weight: 400">Jeżeli nie masz konta, załóż je tutaj!</p>
                        <button style="cursor: pointer;" class="ghost" id="signUp">Rejestracja</button>
                    </div>
                </div>
            </div>
        </div>
        <div style="color: red">
            <?php
                if(isset($_SESSION['blad'])){
                    echo $_SESSION['blad'] . '</br>';
                    unset($_SESSION['blad']);
                }
                if(isset($_SESSION['error_nick'])){
                    echo $_SESSION['error_nick'] . '</br>';
                    unset($_SESSION['error_nick']);
                }
                if(isset($_SESSION['error_haslo'])){
                    echo $_SESSION['error_haslo'] . '</br>';
                    unset($_SESSION['error_haslo']);
                }          
            ?>
        </div>

    </body>
    <?php require_once "./php_scripts/footer.php"; ?>
</html>