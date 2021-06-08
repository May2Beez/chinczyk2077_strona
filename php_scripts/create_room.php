<?php

    session_start();

    require "../connect.php";

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

    if ($polaczenie->connect_error) {
        die ("Błąd połączenia: " . $polaczenie->connect_error);
    }
    else {

        if (isset($_SESSION['zalogowany'])) {

            $wynik = $polaczenie->query("SELECT id FROM users WHERE nick = '" . $_SESSION['nick'] . "'");

            $ileRows = $wynik->num_rows;

            if($ileRows > 0){
                $row = $wynik->fetch_assoc();
                $wynik = $polaczenie->query("INSERT INTO servers (players) VALUE (" . $row['id'] . ")");

                $id = $polaczenie->insert_id;

                echo $id;
            }
        } else {
            header("Location: serverList.php");
        }
    }
    $polaczenie->close();

?>