<?php
    header('Access-Control-Allow-Origin: *');
    session_start();
    $id = $_GET['id'];
    $nick = $_SESSION['nick'];
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Chińczyk 2077 - Game</title>
        <link rel="stylesheet" href="css/everySite.css" type="text/css">
        <link href="css/game.css" type="text/css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" data-auto-replace-svg="nest"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="js/socket.io.js"></script>
        <script src="js/check_nick_and_servers.js" type="text/javascript"></script>
        <script src="js/small_QoL.js"></script>
        <script src="js/snabbt.min.js"></script>
        <script src="js/cpyAddress.js"></script>
        <script type="text/javascript">
            $( document ).ready(function() {
                $("#cpyToClipp").val($("#cpyToClipp").val() + <?= $id ?>);
            });
        </script>
    </head>
    <body>
        <nav>
            <div class="accountOptions">
                <a href="zaloguj.php" style="color: white">login</a>
            </div>

            <?php 
                require_once "./php_scripts/navBar.php"; 
                logo(); 
                require "globalChat.php";
            ?>
        </nav>

        <section class="tabela">
            <div id="tabela_div">
                <table>
                    <thead>
                        <tr>
                            <th style="color: white">Kolor</th>
                            <th style="color: white">Ranga</th>
                            <th></th>
                            <th style="color: white">Gracz</th>
                            <th></th>
                            <th style="color: white">Meta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="tab_color"></td>
                            <td><span class="tab_rank"></span></td>
                            <td colspan="3"><span id=tab_player_1 class="nick"></span></td>
                            <td><span id="tab_meta1">0/4</span></td>
                        </tr>
                        <tr>
                            <td class="tab_color"></td>
                            <td><span class="tab_rank"></span></td>
                            <td colspan="3"><span id=tab_player_2 class="nick"></span></td>
                            <td><span id="tab_meta2">0/4</span></td>
                        </tr>
                        <tr>
                            <td class="tab_color"></td>
                            <td><span class="tab_rank"></span></td>
                            <td colspan="3"><span id=tab_player_3 class="nick"></span></td>
                            <td><span id="tab_meta3">0/4</span></td>
                        </tr>
                        <tr>
                            <td class="tab_color"></td>
                            <td><span class="tab_rank"></span></td>
                            <td colspan="3"><span id=tab_player_4 class="nick"></span></td>
                            <td><span id="tab_meta4">0/4</span></td>
                        </tr>
                        <tr>
                            <td style="border: none" colspan="6">
                                <div id="zapros_do_gry">
                                    <input readonly="readonly" style="width: 80%; color: black; outline: none" type="text" value="" id="cpyToClipp">
                                    <button id="copy_to_clippboard_b" onclick="myFunction()">Invite!</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <th style="border: 0; color: white">Pozycja</th>
                                <th style="border: 0; color: white" colspan="5">Gracz</th>
                            </tr>
                        </thead>
                        <tbody id="podium">
                        <tr>
                            <td id="podium_g" class="tab_color" style="font-size: 1.5em;">1</td>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td id="podium_s" class="tab_color" style="font-size: 1.5em;">2</td>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td id="podium_b" class="tab_color" style="font-size: 1.5em;">3</td>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td class="tab_color" style="font-size: 1.5em">4</td>
                            <td colspan="5"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>
        <section class="game">
            <div class="plansza">
                <table>
                    <tr>
                        <td class="backgroundYellow" colspan="4"><span id="yellowPlayer" class="buttonJoin"></span></td>
                        <td class="pole 19"></td>
                        <td class="pole 20"></td>
                        <td class="pole 21 start blue"></td>
                        <td class="backgroundBlue" colspan="4"><span id="bluePlayer" class="buttonJoin"></span></td>
                    </tr>
                    <tr>
                        <td class="backgroundYellow"></td>
                        <td class="home yellow"><span class="pionek yellow p1"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="home yellow"><span class="pionek yellow p2"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="backgroundYellow"></td>
                        <td class="pole 18"></td>
                        <td class="finish 1 blue"></td>
                        <td class="pole 22"></td>
                        <td class="backgroundBlue"></td>
                        <td class="home blue"><span class="pionek blue p1"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="home blue"><span class="pionek blue p2"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="backgroundBlue"></td>
                    </tr>
                    <tr>
                        <td class="backgroundYellow"></td>
                        <td class="home yellow"><span class="pionek yellow p3"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="home yellow"><span class="pionek yellow p4"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="backgroundYellow"></td>
                        <td class="pole 17"></td>
                        <td class="finish 2 blue"></td>
                        <td class="pole 23"></td>
                        <td class="backgroundBlue"></td>
                        <td class="home blue"><span class="pionek blue p3"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="home blue"><span class="pionek blue p4"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="backgroundBlue"></td>
                    </tr>
                    <tr>
                        <td class="backgroundYellow" colspan="4"><button id="joinYellow" class="colorButton yellow" disabled><i class="fas fa-plus-square"></i></button></td>
                        <td class="pole 16"></td>
                        <td class="finish 3 blue"></td>
                        <td class="pole 24"></td>
                        <td class="backgroundBlue" colspan="4"><button id="joinBlue" class="colorButton blue" disabled><i class="fas fa-plus-square"></i></button></td>
                    </tr>
                    <tr>
                        <td class="pole 11 start yellow"></td>
                        <td class="pole 12"></td>
                        <td class="pole 13"></td>
                        <td class="pole 14"></td>
                        <td class="pole 15"></td>
                        <td class="finish 4 blue">                           
                        <td class="pole 25"></td>
                        <td class="pole 26"></td>
                        <td class="pole 27"></td>
                        <td class="pole 28"></td>
                        <td class="pole 29"></td>
                    </tr>
                    <tr>
                        <td class="pole 10"></td>
                        <td class="finish 1 yellow"></td>
                        <td class="finish 2 yellow"></td>
                        <td class="finish 3 yellow"></td>
                        <td class="finish 4 yellow"></td>
                        <td class="boardCenter">
                            <button id="kostka" disabled><i class="fas fa-dice-d6"></i></button>
                        </td>
                        <td class="finish 4 green"></td>
                        <td class="finish 3 green"></td>
                        <td class="finish 2 green"></td>
                        <td class="finish 1 green"></td>
                        <td class="pole 30"></td>
                    </tr>
                    <tr>
                        <td class="pole 9"></td>
                        <td class="pole 8"></td>
                        <td class="pole 7"></td>
                        <td class="pole 6"></td>
                        <td class="pole 5"></td>
                        <td class="finish 4 red"></td>
                        <td class="pole 35"></td>
                        <td class="pole 34"></td>
                        <td class="pole 33"></td>
                        <td class="pole 32"></td>
                        <td class="pole 31 start green"></td>
                    </tr>
                    <tr>
                        <td class="backgroundRed" colspan="4"><button id="joinRed" class="colorButton red" disabled><i class="fas fa-plus-square"></i></button></td>
                        <td class="pole 4"></td>
                        <td class="finish 3 red"></td>
                        <td class="pole 36"></td>
                        <td class="backgroundGreen" colspan="4"><button id="joinGreen" class="colorButton green" disabled><i class="fas fa-plus-square"></i></button></td>
                    </tr>
                    <tr>
                        <td class="backgroundRed"></td>
                        <td class="home red"><span class="pionek red p2"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="home red"><span class="pionek red p1"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="backgroundRed"></td>
                        <td class="pole 3"></td>
                        <td class="finish 2 red"></td>
                        <td class="pole 37"></td>
                        <td class="backgroundGreen"></td>
                        <td class="home green"><span class="pionek green p1"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="home green"><span class="pionek green p2"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="backgroundGreen"></td>
                    </tr>
                    <tr>
                        <td class="backgroundRed"></td>
                        <td class="home red"><span class="pionek red p3"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="home red"><span class="pionek red p4"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="backgroundRed"></td>
                        <td class="pole 2"></td>
                        <td class="finish 1 red"></td>
                        <td class="pole 38"></td>
                        <td class="backgroundGreen"></td>
                        <td class="home green"><span class="pionek green p3"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="home green"><span class="pionek green p4"><i class="fas fa-chess-pawn"></i></span></td>
                        <td class="backgroundGreen"></td>
                    </tr>
                    <tr>
                        <td class="backgroundRed" colspan="4"><span id="redPlayer" class="buttonJoin"></span></td>
                        <td class="pole 1 start red "></td>
                        <td class="pole 40"></td>
                        <td class="pole 39"></td>
                        <td class="backgroundGreen" colspan="4"><span id="greenPlayer" class="buttonJoin" ></span> </td>
                    </tr>
                    
                </table>
            </div>
            
            <a id="startGame">Gramy!</a>
        </section>
        <section id="chat">
            <div id="chat_div">
                <div id="chat_text">
                </div>
                <hr style="margin-bottom: 5px">
                <div id="chat_input">
                    <input autocomplete="off" id="chat_in_game_input" type="text" maxlength="100"/>
                    <input id="chat_in_game_button" type="button" value="Wyślij"/>
                </div>           
            </div>
        </section>

        <p id="pass_nick" hidden><p>
        
    </body>
    <?php require_once "js/postMatchInfo.php"; ?>
    <?php require_once "js/gameBackend.php"; ?>
    <?php require_once "php_scripts/footer.php"; ?>
</html>