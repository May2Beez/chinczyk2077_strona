$(document).ready(() => {
    var lastResult = "";


    

    setInterval(function() {
        $.ajax({
            url: '/php_scripts/fill_servers.php',
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
    }, 1000);
});
