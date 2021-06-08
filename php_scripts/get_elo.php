<?php

    function get_elo($nick){
        $class_name_rank = "";
        require_once "connect.php";
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        $wynik = $polaczenie->query("SELECT ui.elo FROM user_info ui, users u WHERE u.nick = '$nick' AND u.id = ui.id");               
        $wiersz = $wynik->fetch_assoc();

        $elo = $wiersz['elo'];

        if($elo < 1000){
            $class_name_rank = "unranked";
        }
        else if($elo > 999 && $elo < 1250){
            $class_name_rank = "bronze";
        }
        else if($elo > 1249 && $elo < 1500){
            $class_name_rank = "silver";
        }
        else if($elo > 1499 && $elo < 1750){
            $class_name_rank = "gold";
        }
        else if($elo > 1749 && $elo < 2000){
            $class_name_rank = "diamond";
        }
        else if($elo > 1999 && $elo < 20000){
            $class_name_rank = "grand_master";
        }
        else if($elo > 19999){
            $class_name_rank = "infinity_master";
        }

        $polaczenie->close();

        $class_name_rank .= ' i path';
        return $class_name_rank;

    }
    
?>