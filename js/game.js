$(document).ready(function() {
    for (i = 0; i < 41; i++) {
        setTimeout(function() {
            $("." + i).css("background", "black");
        }, 1000 * i);
    }}
);