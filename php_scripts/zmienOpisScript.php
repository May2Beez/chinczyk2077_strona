<?php
    session_start();
    require_once "../connect.php";
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_error) {
        die ("Błąd połączenia: " . $connection->connect_error);
    }

    echo $new_opis = $_GET['new_opis_input'];
    $id = $_SESSION['id'];

    $connection->query("UPDATE user_info SET opis = '$new_opis' WHERE id_user = $id");
    $connection->close();
    
    header('Location: ../profil.php');
?>