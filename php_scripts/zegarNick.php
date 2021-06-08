<?php
    session_start();
    require_once "../connect.php";
    $connection = new mysqli($host, $db_user, $db_password, $db_name);
    $nick = $_SESSION['nick'];
    $wynik = $connection->query("SELECT * FROM users WHERE nick='$nick'");     
    $wiersz = $wynik->fetch_assoc();   
    
   
    $lastZmiania = $wiersz['zmianaNick'];
    $ostatio = strtotime($lastZmiania);
    $wynik = time() - $ostatio;

    $connection->close();
    if($wynik < 86400){
        $zostalo = 86400 - $wynik;
        
        echo "<div id='zegar' style='color:blue; font-size: 32px; margin-top: 1%; text-align: center'>" . gmdate("H:i:s", $zostalo) . "</div>";
    } else if ($wynik >= 0){

        echo 'Proszę odświeżyć stronę.';
    }
?>