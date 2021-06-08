<script type="text/javascript">

$(document).ready(function() {

    $("#newServer").click(function() {

        <?php

            createServer();

        ?>

    });

});

<?php

    function createServer() {

        session_start();

        require_once "./connect.php";

        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

        if ($polaczenie->connect_error) {
            die ("Błąd połączenia: " . $polaczenie->connect_error);
        }
        else {

            $wynik = $polaczenie->query("SELECT id FROM users WHERE nick = '" . $_SESSION['nick'] . "'");

            $ileRows = $wynik->num_rows;

            if($ileRows > 0){
                $row = $wynik->fetch_assoc();
            }

            $wynik = $polaczenie->query("INSERT INTO servers (players) VALUE (" . $row['id'] . ")");

        }

        $polaczenie->close();
    }

?>


</script>