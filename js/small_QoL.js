function scroll_to_bottom() {
    $('#chat_text').scrollTop($('#chat_text')[0].scrollHeight);
}


$(document).ready(() => {
    

    var input = document.getElementById("chat_in_game_input");

    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("chat_in_game_button").click();
        }
    });
    
    scroll_to_bottom();
})