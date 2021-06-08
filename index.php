<html>
    <head>
        <meta charset="utf-8">
        <title>Chińczyk 2077 - Main</title>
 
        <link rel="stylesheet" href="css/everySite.css" type="text/css">  
        <link href="css/main.css" type="text/css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/check_nick_and_servers.js" type="text/javascript"></script>
    </head>
    <body>
    
        <div class="accountOptions">
            <a href="zaloguj.php" style="color: white">login</a>
        </div>

        <?php 
            require_once "./php_scripts/navBar.php"; 
            logo();
            require "globalChat.php";
        ?>
        
        <section>
            <div class="buttons">
                <a id="browse" class="button" href="serverList.php">
                    <span></span>
                    <div class="content">
                        <h2>Servers</h2>
                        <p>Tutaj możesz przeszukiwać serwery i dołączyć do jakiegokolwiek.</p>
                    </div>
                </a>

                <a id="fastJoin" class="button" href="index.php">
                    <span></span>
                    <div class="content">
                        <h2>Quick Join</h2>
                        <p>W tym trybie dołączysz do losowego pokoju z wolnym slotem.</p>
                    </div>
                </a>

                <?php
                    if (isset($_SESSION['zalogowany'])) {
                        if ($_SESSION['zalogowany']) {
                            echo '<a id="shop" class="button" href="index.php">';
                        }
                    }
                    else {
                        echo '<a id="shop" class="button" href="zaloguj.php">';
                    }

                ?>
                    <span></span>
                    <div class="content">
                        <h2>Shop</h2>
                        <p>Zakup nowe skórki i kolorowe nicki!</p>
                    </div>
                </a>
            </div>
        </section>
    </body>
    <?php require_once "./php_scripts/footer.php"; ?>
</html>