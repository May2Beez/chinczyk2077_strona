
var lastResult = "";
var lastResultNick = "";

var serverList = false;

if (document.location.href.indexOf("serverList.php") != -1) {
    serverList = true;
}

$.ajax({
    url: './php_scripts/get_nick.php',
    type: "POST",
    success: function(result) {
        if (lastResultNick != result) {
            lastResultNick = result;
            $(".accountOptions").html(result);
        }
    },
    error: function(data) {
        console.log(data);
    }
})
if (serverList) {
    $.ajax({
        url: './php_scripts/fill_servers.php',
        type: "POST",
        success: function(result) {
            if (lastResult != result) {
                lastResult = result;
                $("#serverRows").html(result);
                add_click_event();
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

setInterval(function() {
    if (serverList) {
        $.ajax({
            url: './php_scripts/fill_servers.php',
            type: "POST",
            success: function(result) {
                if (lastResult != result) {
                    lastResult = result;
                    $("#serverRows").html(result);
                    add_click_event();
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    };
}, 10000);
