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
        <title>Chińczyk 2077 - Zmiana opisu</title>
        <link href="css/everySite.css" type="text/css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/check_nick_and_servers.js" type="text/javascript"></script>
    </head>
    <body>
    
        <div class="accountOptions">
            <a href="zaloguj.php" style="color: white">login</a>
        </div>

        <?php 
            require_once "php_scripts/navBar.php"; 
            logo();       
            require "globalChat.php";   

            require_once "connect.php";
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            $id = $_SESSION['id'];
            $wynik = $polaczenie->query("SELECT opis FROM user_info WHERE id = $id");               
            $wiersz = $wynik->fetch_assoc();

            $stary_opis = $wiersz['opis'];

            $polaczenie->close();
        ?>
        <form action="php_scripts/zmienOpisScript.php" class="reg-log-form">
            <b>Opis:</b></br>
            <textarea id="opis_input" maxlength="500" rows="5" cols="50" required="" name="new_opis_input" style="margin-top: 0px; margin-bottom: 0px; height: 200px;"><?php echo $stary_opis ?></textarea><br><br>
            <input type="submit" value="Zmień">
        </form>
    </body>
    <?php require_once "php_scripts/footer.php" ?>
</html>
