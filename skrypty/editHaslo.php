<?php
    session_start();
    require_once "../connect.php";
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_error) {
        die ("Błąd połączenia: " . $connection->connect_error);
    }

    $nick = $_SESSION['nick'];
    $stare1 = $_GET['stare'];
    $nowe1 = $_GET['nowe1'];
    $nowe2 = $_GET['nowe2'];
    echo $stare1;
    echo $nowe1;
    echo $nowe2;
    echo $nick;

    echo $czas = date("Y-m-d H:i:s");

    $wynik = $connection->query("SELECT * FROM users WHERE nick='$nick'");
    $wiersz = $wynik->fetch_assoc();
    if(!password_verify($stare1, $wiersz['password'])){
        $_SESSION['error'] = "Podane stare hasło jest niepoprawne!";
        header('Location: ../blad.php');
        exit();     
    }else if($nowe1 != $nowe2){
        $_SESSION['error'] = "Nowe hasła nie są identyczne!";
        header('Location: ../blad.php');
        exit();  
    }else if($nowe1 == '' | $nowe2 == ''){
        $_SESSION['error'] = "Nie podałeś nowego hasła!";
        header('Location: ../blad.php');
        exit();  
    }else if(strlen($nowe1)<6){
        $_SESSION['error'] = "Nowe hasło jest za krótkie. Hasło musi zawierać co najmniej 6 znaków!";
        header('Location: ../blad.php');
        exit();  
    }
    $haslo_hash = password_hash($nowe1, PASSWORD_DEFAULT);
    $connection->query("UPDATE users SET password='{$haslo_hash}', zmianaPass='{$czas}' WHERE nick='$nick'");
    $connection->close();
    
    header('Location: ../logout.php');
?>