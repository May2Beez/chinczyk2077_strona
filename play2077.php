<?php 

    session_start();
    function add_guest() {
        require_once $_SERVER['DOCUMENT_ROOT'] . "/connect.php";
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        $wynik = $polaczenie->query("SELECT id FROM users ORDER BY id DESC");

        $ileRows = $wynik->num_rows;
        if($ileRows > 0){
            $row = $wynik->fetch_assoc();
            $newGuest = 'Guest_' . ($row['id'] + 1);
            
        }else {
            $newGuest = 'Guest_1';
        }
        
        $polaczenie->query("INSERT INTO users (nick, password) VALUES ('$newGuest', NULL)");
        $polaczenie->close();
        $_SESSION['nick'] = $newGuest;
        $_SESSION['guest'] = true;
    }

    if (!isset($_SESSION['zalogowany'])) {
        add_guest();
        $new_location = "Location: game.php?id=" . $_GET['id'];
        header($new_location);
    } else {
        $new_location = "Location: game.php?id=" . $_GET['id'];
        header($new_location);
    }

?>