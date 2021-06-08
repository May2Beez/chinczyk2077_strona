<?php
    session_start();
    require_once "../connect.php";
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_error) {
        die ("Błąd połączenia: " . $connection->connect_error);
    }
    $nowyNick = $_SESSION['nowyNick'];

    $czas = date("Y-m-d H:i:s");
    $sql = "UPDATE users SET nick='{$nowyNick}', zmianaNick='{$czas}' WHERE nick='{$_SESSION['nick']}'";
    $_SESSION['nick'] = $_SESSION['nowyNick'];
    unset($_SESSION['nowyNick']);
    
    $connection->query($sql);
    $connection->close();
    $_SESSION['nickZmieniony'] = true;
    header('Location: ../index.php');
?>