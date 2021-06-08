<?php

    session_start();
    require_once "../connect.php";

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

    if ($polaczenie->connect_error) {
        die ("Błąd połączenia: " . $polaczenie->connect_error);
    }

        $pLogin = $_SESSION['nick'];
        $login = $_GET['nick'];
        $haslo = $_GET['haslo']; 

        echo $login;
        echo $haslo;

        if(strlen($login)<3 || strlen($login)>15){
            $_SESSION['error']="<p style='color:red; font-size: 32px; text-align: center;'>Login musi posiadać od 3 do 15 znaków!!";
            header('Location: ../blad.php');
            exit();
        }

        $wynik = $polaczenie->query("SELECT id FROM users WHERE nick='$login'");
        $czyIstnieje = $wynik->num_rows;
        if($czyIstnieje > 0){
            $_SESSION['error']="<p style='color:red; font-size: 32px; text-align: center;'>Taki nick jest już zajęty!";
            header('Location: ../blad.php');
            exit();
        }

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");

        if($wynik = $polaczenie->query(sprintf("SELECT * FROM users WHERE nick='%s'",
        mysqli_real_escape_string($polaczenie,$pLogin)))){
            $ile_userow = $wynik->num_rows;
            if($ile_userow>0){
                $wiersz = $wynik->fetch_assoc();

                if(password_verify($haslo, $wiersz['password'])){
                    $_SESSION['nowyNick'] = $login;
                    header('Location: editNick.php'); 
                }else{
                    $_SESSION['error']="<p style='color:red; font-size: 32px; text-align: center;'>Niepoprawne hasło!";
                    header('Location: ../blad.php');
                }
            }else{
                $_SESSION['error']="<p style='color:red; font-size: 32px; text-align: center;'>Niepoprawne hasło!";
                header('Location: ../blad.php');
            }
        }

        $polaczenie->close();
?>