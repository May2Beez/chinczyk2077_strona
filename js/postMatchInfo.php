<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/results_modal.css" type="text/css" rel="stylesheet">
    </head>
    <body>

        <!-- <button id="myBtn">Open Modal</button> -->

        <div id="myModal" class="modal">
            <div class="modal-content">
                <header style="margin-bottom: 5px">Koniec gry!</header>
                <table id="result_table">
                    <thead>
                        <tr>
                            <th style="border: 0; color: white">Pozycja</th>
                            <th style="border: 0; color: white; width: 70%">Gracz</th>
                            <th style="border: 0; color: white">ELO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="podium_g" class="tab_color" style="font-size: 1.5em; background-color: gold;">1</td>
                            <td style="font-size: 1.5em"></td>
                            <td style="font-size: 1em;"><div class="total_elo">-</div><div class="plus_minus_elo"></div></td>
                        </tr>
                        <tr>
                            <td id="podium_s" class="tab_color" style="font-size: 1.5em; background-color: silver">2</td>
                            <td style="font-size: 1.5em"></td>
                            <td style="font-size: 1em;"><div class="total_elo">-</div><div class="plus_minus_elo"></div></td>
                        </tr>
                        <tr>
                            <td id="podium_b" class="tab_color" style="font-size: 1.5em; background-color: rgb(179, 111, 3)">3</td>
                            <td style="font-size: 1.5em"></td>
                            <td style="font-size: 1em;"><div class="total_elo">-</div><div class="plus_minus_elo"></div></td>
                        </tr>
                        <tr>
                            <td class="tab_color" style="font-size: 1.5em">4</td>
                            <td style="font-size: 1.5em"></td>
                            <td style="font-size: 1em;"><div class="total_elo">-</div><div class="plus_minus_elo"></div></td>
                        </tr>
                    </tbody>
                </table>
                <a style="margin-top: 100%" href="../index.php">Przejdź do menu!</a>
            </div>
        </div>

        <script type="text/javascript">

            var modal = document.getElementById("myModal");
            $("#myBtn").click(function(event) {
                
                $("#podium tr").each(function(index) {
                    $("#result_table tbody").children().eq(index).children().eq(1).html($(this).children().eq(1).html());
                })


                modal.style.display = "block";
            })

            
            
            function results(){

                $("#podium tr").each(function(index) {
                    $("#result_table tbody").children().eq(index).children().eq(1).html($(this).children().eq(1).html());
                })
                var modal = document.getElementById("myModal");
                modal.style.display = "block";
            }

        </script>

    </body>
</html>
