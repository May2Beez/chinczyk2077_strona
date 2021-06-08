$(document).ready(function() {

    $("#newServer").click(function() {
        
        $.ajax({
            url: "./php_scripts/create_room.php",
            type: "POST",
            cache: false,
            success: function(result){
                link = "/game.php?id=" + result;
                window.location.href = link;
            },
            error: function(xhr, status, error) {
                console.log("error: "+status + ': ' + error);
            }
        });

    });

});