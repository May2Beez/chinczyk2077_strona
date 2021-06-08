<?php  
    session_start();
    if(!isset($_SESSION['zalogowany'])){
        header('Location: index.php');
        exit();
    }
    unset($_SESSION['blad']);
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Chińczyk 2077 - Konto</title>
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
            require_once "./php_scripts/navBar.php"; 
            logo();
            require "globalChat.php";
        ?>
    </nav>
        <div class="reg-log-form" style="text-align: center">
            <?php
                echo "<p style='font-size: 32px; margin-top: 200px; color: orange'>" . "Witaj " . $_SESSION['nick'] . "!" . "</p><br>";
                echo "<a href='zmienNick.php' style='font-size: 28px'>Zmień nick</a></br></br>";
                echo "<a href='zmienHaslo.php' style='font-size: 28px'>Zmień hasło</a></br></br>";
                echo "<a href='zmienOpis.php' style='font-size: 28px'>Zmień opis profilu</a></br></br>";
                echo "<a href='zmienAwatar.php' style='font-size: 28px'>Zmień awatar</a></br></br>";
                echo "<a href='logout.php' style='font-size: 28px; color: red'>Wyloguj się</a>";
            ?>
        </div>
    </body>
    <?php require_once "php_scripts/footer.php"; ?>
</html>
