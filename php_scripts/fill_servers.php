<?php

    require_once "../connect.php";

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

    if ($polaczenie->connect_error) {
        die(); 
    } else {
        $wynik = $polaczenie->query("SELECT players, idServer FROM servers WHERE started <> '1'");
        $rows = $wynik->num_rows; 
        $text = "";
        if ($rows > 0) {
            
            while ($row = $wynik->fetch_assoc()) {
                $nicki = "";
                $wiersz = $row['players'];
                $playersArray = explode(',', $wiersz);

                for($i = 0; $i < sizeof($playersArray); $i++){
                    $tempID = $playersArray[$i];
                
                    if( $wynik2 = $polaczenie->query("SELECT nick FROM users WHERE id = $tempID")){
                        $row2 = $wynik2->fetch_assoc();

                        $nicki .= $row2['nick'];
                        if($i < sizeof($playersArray) - 1){
                            $nicki .=  ", ";
                        }
                    }
                }

                $text .= '<tr class="cell">';
                $text .= '  <td name=' . $row['idServer'] . '>#'. $row['idServer'] . '</td>';
                $text .= '  <td>' . $nicki . '</td>';
                $text .= '  <td name=' . sizeof($playersArray) . '>' . sizeof($playersArray) . '/4</td>';
                $text .= '</tr>';
            }
            for($i = 1; $i <= 10 - $rows; $i++){
                $text .= '<tr class="emptyCell">';
                $text .= '  <td></td>';
                $text .= '  <td></td>';
                $text .= '  <td></td>';
                $text .= '</tr>';
            }
        }

        $polaczenie->close();
        echo $text;
    }

?>