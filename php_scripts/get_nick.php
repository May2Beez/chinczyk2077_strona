<?php

    $text = "";
    $text .= '<div class="accountOptions">';

    session_start();

    if (isset($_SESSION['zalogowany'])) {
        if ($_SESSION['zalogowany'] == true) {
            $text .= '<a href="profil.php" style="color: white">' . $_SESSION['nick'] . '</a>';
            $text .= '<a href="logout.php" style="color: white">wyloguj</a>';
        }
    }
    else if (isset($_SESSION['guest'])) {
        if ($_SESSION['guest'] == true) {

            require_once "../connect.php";
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            $wynik = $polaczenie->query("SELECT nick FROM users WHERE nick = '" . $_SESSION['nick'] . "'");

            $ileRows = $wynik->num_rows;
            if ($ileRows > 0){
                $text .= '<a href="zaloguj.php" style="color: white">' . $_SESSION['nick'] . '</a>';
                $text .= '<a href="zaloguj.php" style="color: white">login</a>';
            }else {
                $text .= '<a href="zaloguj.php" style="color: white">login</a>';
                unset($_SESSION['guest']);
                unset($_SESSION['nick']);
            }
            $polaczenie->close();
        }
    }
    else {
        $text .= '<a href="zaloguj.php" style="color: white">login</a>';
    }

    $text .= '</div>';

    echo $text;

?>