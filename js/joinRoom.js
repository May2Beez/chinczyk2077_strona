function add_click_event() {
    $(".cell").each(function() {
        $(this).children().each(function() {
            $(this).click(function() {
                if ($(this).parent().hasClass("clicked")) {
                    if ($(this).parent().children().eq(2).attr('name') < 4) {
                        temp = $(this).parent().children().eq(0).attr('name');
                        openRoom(temp);
                    }
                } else {
                    $(".cell").removeClass("clicked");
                    $(this).parent().addClass("clicked");
                }
            })
        });
    });
}

function openRoom(room) {
    link = "play2077.php?id=" + room;
    window.location.href = link;
}