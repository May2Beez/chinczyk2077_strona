<?php
    session_start();
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
        <div class="accountOptions">
            <a href="zaloguj.php" style="color: white">login</a>';
        </div>

        <?php 
            require_once "php_scripts/navBar.php"; 
            logo();
        ?>
        <article>
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
            <a class="link" style="color:blue" href="konto.php">Powrót</a>
        </article>
    </body>
</html>