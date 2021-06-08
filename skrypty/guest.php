<?php
    // require_once "connect.php";
    // if(!$_SESSION['guest']){
        
    //     $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    //     $wynik = $polaczenie->query("SELECT id FROM users ORDER BY id DESC");

    //     $ileRows = $wynik->num_rows;
    //     if($ileRows > 0){
    //         $row = $wynik->fetch_assoc();
    //         $newGuest = 'Guest_' . ($row['id'] + 1);
            
    //     }else {
    //         $newGuest = 'Guest_1';
    //     }

    //     $polaczenie->query("INSERT INTO users VALUES (NULL, '$newGuest', NULL, '0', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
    //     $polaczenie->close();
    //     $_SESSION['guest'] = true;
    //     $_SESSION['nick'] = $newGuest;
    //     echo '<a href="register.php">' . $_SESSION['nick'] . '</a>';
    //     echo '<a href="zaloguj.php">zaloguj</a>';
    // }
?>