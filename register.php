<?php
    session_start();
    if(isset($_POST['login'])){

        $regError = false;

        $nick = $_POST['login'];
        $haslo1 = $_POST['password1'];
        $haslo2 = $_POST['password2'];

        if(strlen($nick)<3 || strlen($nick)>15){
            $regError = true;
            $_SESSION['error_nick'] = "Login musi posiadać od 3 do 15 znaków!";
        }
        if(ctype_alnum($nick)==false){
            $regError = true;
            $_SESSION['error_nick'] = "Login nie może zawierać znaków specjalnych!";
        }
        if(strlen($haslo1)<6 || strlen($haslo1)>30){
            $regError = true;
            $_SESSION['error_haslo'] = "Hasło musi posiadać od 6 do 30 znaków!";
        }
        if($haslo1 != $haslo2){
            $regError = true;
            $_SESSION['error_haslo'] = "Wpisane hasła nie są identyczne!";
        }

        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);


        require_once "connect.php";
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

        $wynik = $polaczenie->query("SELECT id FROM users WHERE nick='$nick'");
        $czyIstnieje = $wynik->num_rows;
        if($czyIstnieje > 0){
            $regError = true;
            $_SESSION['error_nick'] = "Wpisany login jest już zajęty!";
        }

        if($regError == false){
            $polaczenie->query("INSERT INTO users VALUES (NULL, '$nick', '$haslo_hash', '0', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
            $wynik2 = $polaczenie->query("SELECT id FROM users WHERE nick = '$nick'");
            $wiersz = $wynik2->fetch_assoc();
            $id = $wiersz['id'];

            $polaczenie->query("INSERT INTO user_info VALUES (NULL, '$id', '900', 'Brak opisu.')");
            $polaczenie->query("INSERT INTO user_stats_no_rank VALUES (NULL, '$id', '0,0,0,0', '0,0')");
            $polaczenie->query("INSERT INTO user_stats_rank VALUES (NULL, '$id', '0,0,0,0', '0,0')");
            $_SESSION['uRejestracja'] = true;
            header('Location: index.php'); 
        }
        $polaczenie->close();
        header('Location: zaloguj.php'); 
    }

?>