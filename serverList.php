<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/everySite.css" type="text/css">
    <link rel="stylesheet" href="css/serverList.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/socket.io.js" type="text/javascript"></script>
    <script src="js/joinRoom.js" type="text/javascript"></script>
    <script src="js/create_room.js" type="text/javascript"></script>
    <script src="js/check_nick_and_servers.js" type="text/javascript"></script>
    <title>Chińczyk 2077 - Lista serwerów</title>
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
        
        <section class="serversList">
            <div class="servers">

                <div class="box">
                    <span></span>

                    <div class="content">

                        <table cellspacing="0" cellpadding="0" id="serversTakbe">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Nr. pokoju</th>
                                    <th style="width: 60%">Gracze</th>
                                    <th style="width: 20%">Ilość graczy</th>
                                </tr>
                            </thead>
                            <tbody id="serverRows" class="disable-selection">
                                <?php
                                    for($i = 1; $i <= 10; $i++){
                                        echo '<tr class="emptyCell">';
                                            echo '<td></td>';
                                            echo '<td></td>';
                                            echo '<td></td>';
                                        echo '</tr>';
                                    }
                                ?>
                                
                            </tbody>
                            
                        </table>

                    </div>
                    
                </div>

            </div>

            <?php
                if(isset($_SESSION['zalogowany'])){
                    echo "<a id='newServer'>Stwórz server</a>";
                }
            ?>
        </section>
    </body>
    <?php require_once "php_scripts/footer.php"; ?>
</html>