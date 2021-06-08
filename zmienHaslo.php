<?php
    session_start();
    if(!isset($_SESSION['zalogowany'])){
        header('Location: index.php');
        exit();
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>FCTracker</title>
        <link href="css/everySite.css" type="text/css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/check_nick_and_servers.js" type="text/javascript"></script>
    </head>
    <body>   
    <nav>
        <div class="accountOptions">
            <a href="zaloguj.php" style="color: white">login</a>
        </div>

        <?php 
            require_once "php_scripts/navBar.php"; 
            logo();
            require "globalChat.php";
        ?>
    </nav>      
        </br><form action="php_scripts/editHaslo.php" class="reg-log-form">
                <b>Stare hasło:</b></br>
                <input name="stare" type="password"></input></br></br>
                <b>Nowe hasło:</b></br>
                <input name="nowe1" type="password"></input></br></br>
                <b>Powtórz nowe hasło:</b></br>
                <input name="nowe2" type="password"></input></br></br>
                <input type="submit" value="Zmień">
            </form>
    </body>
    <?php require_once "php_scripts/footer.php" ?>
</html>
