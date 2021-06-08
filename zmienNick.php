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
        <title>FCTracker</title>
        <link href="css/everySite.css" type="text/css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/check_nick_and_servers.js" type="text/javascript"></script>
        <script>
            function loadlink(){
                $('#zegarek').load('php_scripts/zegarNick.php',function () {
                    $(this).unwrap();
                });
            }

            loadlink();
            setInterval(function(){
                loadlink()
            }, 1000);

        </script>
    </head>
    <body>
    
        <div class="accountOptions">
            <a href="zaloguj.php" style="color: white">login</a>
        </div>

        <?php 
            require_once "php_scripts/navBar.php"; 
            logo();
            require "globalChat.php";

            $_SESSION['trybZegara'] = "nick";
            require_once "connect.php";
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            $nick = $_SESSION['nick'];
            $wynik = $connection->query("SELECT * FROM users WHERE nick='$nick'");     
            $wiersz = $wynik->fetch_assoc();   
            
            $lastZmianiaNicku = $wiersz['zmianaNick'];
            $today = date("Y-m-d H:i:s");
            $ostatio = strtotime($lastZmianiaNicku);
            $teraz = strtotime($today);
            $wynik = $teraz - $ostatio; 
            
            $connection->close();
            if($wynik < 86400){
                $zostalo = 86400 - $wynik;
                //echo '<div style="text-align: center">';
                //echo '</div>';
                echo "<p style='font-size: 32px; margin-top: 5%; text-align: center'>" . "Następna możliwa zmiana za: </p>";
                echo "<div id='zegarek' style='color:blue; font-size: 32px; margin-top: 1%; text-align: center'>" . gmdate("H:i:s", $zostalo) . "</div>";
                exit();
            }
        ?>
        <form action="php_scripts/checkChangeNick.php" class="reg-log-form">
            <p style="font-size: 0.8em">Uwaga! Nick można zmienić tylko raz na 24 godziny!</p><br>
            <b>Nowy nick:</b></br>
            <input maxlength="15" name="nick" type="text"></input></br></br>
            <b>Hasło:</b></br>
            <input name="haslo" type="password"></input></br></br>
            <input type="submit" value="Zmień">
        </form>
    </body>
    <?php require_once "php_scripts/footer.php" ?>
</html>
