<?php 
    error_reporting(0);
    session_start();
    $id = $_SESSION['id'];
    $nick = $_SESSION['nick'];

    $jest = false;
    if(isset($_SESSION['zalogowany'])){
        $jest = true;
    }
?>

<script type="text/javascript">
    console.log('<?= $_SESSION['zalogowany']; ?>');
    if("<?= $nick; ?>" != "" && "<?= $jest; ?>"){
        $(document).ready(function() {
            $(".chat-logs").append("<p style='color: gray'>Łączenie z serwerem...</p>");
            const socket = io("");
            socket.on('connect', function() {   
                data = {"user_id": <?= $id; ?>, "nick": '<?= $nick; ?>'};
                socket.emit('get user data', data);   
                console.log("1");
            });

            socket.on('connection established', function() {
                console.log("Connection established!");
                $(".chat-logs").append("<p style='color: green'>Połączono!</p>");
                $(".chat-logs").append("<p style='color: white'>Witaj na czacie globalnym!</p><br>");
                $( "#chat-circle" ).prop("hidden", false); 
                console.log("2");
            });

            $("#chat-submit").click(function() {
                if($("#chat-input").val() != ""){
                    msg = $("#chat-input").val();
                    sendMessage(msg);
                    $("#chat-input").val("");
                    console.log("Wysłano do serwera!"); 
                }      
            });

            function sendMessage(data) {
                socket.emit('send message', {"msg": data});
            }

            socket.on('receive message', function(data) {
                console.log("Odbieram wiadomość!")
                console.log("Wiadomość: " + data['msg']);
                tmpMsg = data['msg'];
                console.log(data['ranga']);
                str = "<div class='message_layout'><a class='" + data['ranga'] + "' href='profil.php?id=" + data['id'] + "' target='_blank'>" + data['nick'] + "</a>" + ": " + tmpMsg + "</div><br>";
                $(".chat-logs").append(str);

                $(".chat-logs").scrollTop($(".chat-logs").prop('scrollHeight'));
            });

        });
    }
</script>
