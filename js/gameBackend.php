<?php 
    $id = $_GET['id'];
    $nick = $_SESSION['nick'];
    //require_once $_SERVER['DOCUMENT_ROOT'] . "/php_scripts/get_elo.php";
?>

<script type="text/javascript">

    var sorted_gracze = ['', 'red', 'yellow', 'blue', 'green'];
    var gracze = [''];
    var kostka = ["", "one", "two", "three", "four", "five", "six"];
    var proba = 0;
    var kolor = null;
    var licznik = [-1, -1, -1, -1, -1];
    var mozliwe_ruchy = 0;
    var pionki_na_mecie = 0;
    var places = [];
    var first_six = false;
    var proba_wyjscia = false;
    var game_started = false;
    var aktualny_gracz = null;

    $(document).ready(function() {
        size_of_pioneks();

        // POŁĄCZENIE I SPRAWDZENIE KOLORÓW //

        const socket = io("");

        socket.on('connect', function() {

            data = {"roomId": <?= $id; ?>, "nick": '<?= $nick; ?>'};
            socket.emit('join room', data);
            send_pionki_na_mecie();

            $(".pionek").each(function() {

                $(this).css('visibility', 'hidden');

            })

        });

        socket.on('get session', function() {
            socket.emit('sent back session');
        });


        $("#joinYellow").click(function() {
            joinAs("yellow");
        });

        $("#joinRed").click(function() {
            joinAs("red");
        });

        $("#joinBlue").click(function() {
            joinAs("blue");
        });

        $("#joinGreen").click(function() {
            joinAs("green");
        });

        $("#chat_in_game_button").click(function() {
            if ($("#chat_in_game_input").val() != "") {
                sendMessage($("#chat_in_game_input").val());
                $("#chat_in_game_input").val("");
            }
        })

        $("#startGame").click(function() {
            
            var numberOfPlayers = 0;

            $(".buttonJoin").each(function() {
                if ($(this).html() != "") {
                    numberOfPlayers++;
                }
            });

            if (numberOfPlayers > 0) {

                var firstPlayer = Math.floor(Math.random() * numberOfPlayers) + 1;
                socket.emit('send info', {"msg": "<p class='greenMsg'></b>Game started!</b></p>"});
                socket.emit('start game', {"firstPlayer": firstPlayer});

                gracze.sort(function(a, b) {
                    return sorted_gracze.indexOf(a) - sorted_gracze.indexOf(b);
                });

                socket.emit('send info', {"msg": "<p>Zaczyna kolor " + gracze[firstPlayer]});
            }
        })

        socket.on('game started', function(data) {

            gracze.sort(function(a, b) {
                return sorted_gracze.indexOf(a) - sorted_gracze.indexOf(b);
            });

            send_pionki_na_mecie();

            $(".colorButton").each(function() {
                $(this).prop('disabled', true);
            })
            

            $("#startGame").css('pointer-events', 'none');

            $("#startGame").css('visibility', 'hidden');

            if (kolor != null) {
                if (kolor == gracze[data['firstPlayer']]) {
                    $("#kostka").prop('disabled', false);
                    $("#kostka").click(function() {
                        open_kostka();
                    });
                }
            }

            $(".home." + gracze[data['firstPlayer']]).addClass('active_player');
            

            for (i = 1; i < gracze.length; i++) {

                $(".pionek." + gracze[i]).css('visibility', 'visible');

            }

            game_started = true;

        })


        socket.on('color choose', function(data) {
            $(".colorButton").each(function() {
                if ($("#" + $(this).attr('class').split(" ")[1] + "Player").html() == (data['nick'])) {
                    $("#" + $(this).attr('class').split(" ")[1] + "Player").html("");
                    color = $(this).attr('class').split(" ")[1];
                    if (gracze.indexOf(color) != -1) {
                        index = gracze.indexOf(color);
                        gracze.splice(index, 1);
                    }
                }
            })
            if ($("#" + data['color'] + "Player").html() == "")
                $("#" + data['color'] + "Player").html(data['nick']);
        })

        function joinAs(color){
            data = {"roomId": <?php echo $id; ?>, "nick": '<?php echo $nick; ?>', "color": color};
            socket.emit('join as color', data);
            socket.emit('sent back session');
            kolor = color;
        }

        socket.on('set colors', function(data) {

            $(".colorButton").each(function() {
                color = $(this).attr('class').split(" ")[1];
                colorTmp = color.substr(0,1).toUpperCase()+color.substr(1);
                if ($("#" + color + "Player").html() == "")
                    $(this).prop('disabled', false);
            });

            var inTable = false;
            $(".nick").each(function() {
                if ($(this).html().indexOf(data['nick']) >= 0) {
                    if (data['color'] != null) {
                        $(this).parent().parent().children().eq(0).attr('id', "tab_" + data['color']);
                        colorTmp = data['color'].substr(0,1).toUpperCase()+data['color'].substr(1);
                        $("#join" + colorTmp).prop('disabled', true);
                    }
                    inTable = true;
                    return false;
                }
            });

            if (!inTable) {
                $(".nick").each(function() {
                    if ($(this).html() != data['nick']) {
                        if ($(this).html() == "") {
                            if (data['color']) {
                                $(this).parent().parent().children().eq(0).attr('id', "tab_" + data['color']);
                                $("#join" + data['color']).prop('disabled', true);
                            }
                            $(this).html(data['nick']);
                            return false;
                        }
                    }
                })
            }

            $(".nick").each(function() {
                if ($(this).html().indexOf(data['nick']) >= 0) {
                    if (data['color'] != null) {
                        colorTmp = data['color'].substr(0,1).toUpperCase()+data['color'].substr(1);
                        $("#join" + colorTmp).prop('disabled', true);
                        $("#" + data['color'] + "Player").html(data['nick']);
                        if (gracze.indexOf(data['color']) == -1) {
                            gracze.push(data['color']);
                        }
                    }
                    return false;
                }
            });

            socket.emit('get klase');
        })

        socket.on('send back klase', function(data) {
            $(".nick").each(function() {
                if ($(this).html() == data['nick']) {
                    
                    $(this).parent().parent().children().eq(1).children().eq(0).html('<i class="fas fa-chess-pawn"></i>'); 
                    var klasa = data['klasa'] + ' i path';
                    $(this).parent().parent().children().eq(1).children().eq(0).addClass(klasa);

                    return false;
                }
            })
        })

        

        socket.on('delete color', function(data) {
            $("#" + data['color'] + "Player").html("");
        })

        socket.on('client left', function(data) {
            if (data['color'] != null) {
                $(".colorButton." + data['color']).prop("disabled", false);
                $("#tabela_div tbody tr #tab_" + data['color']).attr('id', '');
            }

            $("#tabela_div tbody tr").each(function() {
                if ($(this).children().eq(2).children().eq(0).html() == data['nick']) {
                    $(this).children().eq(2).children().eq(0).html("");
                    $(this).children().eq(1).html('<span class="tab_rank"></span>');

                    return false;
                }
            })

            if (game_started) {

                index_stary = gracze.indexOf(data['color']);
            
                index_nowy = index_stary+1;

                if (index_nowy > gracze.length-1) {
                    index_nowy = 1;
                }

                if (kolor == gracze[index_nowy]) {

                    ponowny_rzut();

                }

                $(".colorButton." + data['color']).prop('disabled', true);
                $(".pionek." + data['color']).css('visibility', 'hidden');

                $("#podium").children().eq(gracze.length-2).children().eq(1).html(data['nick']);

                if (gracze.indexOf(data['color']) != -1) {
                    index = gracze.indexOf(data['color']);
                    gracze.splice(index, 1);
                }

                if (gracze.length == 2) {

                    end_game(true);

                }

            } else {

                if (gracze.indexOf(data['color']) != -1) {
                    index = gracze.indexOf(data['color']);
                    gracze.splice(index, 1);
                }

            }

        })

        socket.on('get info', function(data) {
            $("#chat_text").append(data['msg']);
            scroll_to_bottom();
        })

        socket.on('user leave_join', function(data) {
            $("#chat_text").append(data['msg']);
            scroll_to_bottom();
        })

        socket.on('receive message', function(data) {
            new_message = '<p><b>' + data['nick'] + ":</b> " + data['msg'] + "</p>";
            $("#chat_text").append(new_message);
            scroll_to_bottom();
        })

        socket.on('set dice', function(data) {
            roll_dice_anim();
            $("#kostka").children().eq(0).children().eq(0).attr('class', 'svg-inline--fa fas fa-dice-' + kostka[data['dice']] + '  fa-w-14');
        })


        socket.on('send zbity pionek', function(data) {

            $(".home." + data['kolor_bazy']).each(function() {

                if ($(this).children().length == 0) {

                    $(data['zbity_pionek']).detach().appendTo($(this));

                    return false;

                }

            })

            if (data['kolor_bazy'] == kolor) {

                var numer_pionka = parseInt(data['zbity_pionek'].slice(data['zbity_pionek'].length - 1));

                licznik[numer_pionka] = -1;

            }

        })


        function check_if_pionek_do_zbicia(ruch, callback) {

            var zbity = false;

            if ($(".pole." + ruch).children().length > 0) {

                $(".pole." + ruch).children().each(function () {

                    var pionek = this;

                    if ($(pionek).attr('class').indexOf(kolor) == -1) {

                        var kolor_sprawdzany = $(pionek).attr('class').split(" ")[1];

                        var zbity_pionek = ".pionek." + kolor_sprawdzany + ".p" + $(pionek).attr('class').split(" ")[2].slice(1, 2);

                        if ($(zbity_pionek).parent().attr('class').indexOf(kolor_sprawdzany) == -1) {

                            var zbity_pionek = ".pionek." + kolor_sprawdzany + ".p" + $(pionek).attr('class').split(" ")[2].slice(1, 2);

                            socket.emit('zbity pionek', {"zbity_pionek": zbity_pionek, "kolor_bazy": kolor_sprawdzany, "ruch": ruch});

                            zbity = true;

                        } else {

                            return callback(zbity);

                        }

                    }

                })

            }

            return callback(zbity);

        }


        socket.on('send ruch pionka', function(data) {

            numer_pionka = data['pionek'];
            color = data['color'];
            ruch = data['ruch'];

            if (ruch == "domek") {

                $("." + data['color'] + ".p" + numer_pionka).detach().appendTo($(".start." + color));

                
            } else if (ruch == "finish") {

                $("." + data['color'] + ".p" + numer_pionka).detach().appendTo($(".finish." + data['finishPosition'] + "." + color));

            } else {

                $("." + data['color'] + ".p" + numer_pionka).detach().appendTo($(".pole." + ruch));

            }

            $(".pionek." + kolor).css('cursor', 'default');
            $(".pionek." + kolor).removeClass('movable');

            size_of_pioneks();
        })

        function ponowny_rzut() {
            
            proba = 0;
            proba_wyjsica = false;
            mozliwe_ruchy = 0;
            $(".pionek").off();
            $("#kostka").off();
            $("#kostka").prop('disabled', false);
            $("#kostka").click(function() {
                open_kostka();
            })
        }

        function sendMessage(msg) {
            socket.emit('send message', {"msg": msg});
        }

        function nastepny_gracz() {

            proba_wyjscia = false;
            first_six = false;
            mozliwe_ruchy = 0;
            $(".pionek." + kolor).off();
            $("#kostka").off();
            $("#kostka").prop('disabled', true);
            index_stary = gracze.indexOf(kolor);
            
            index_nowy = index_stary+1;

            if (index_nowy > gracze.length-1) {
                index_nowy = 1;
            }

            nowy_kolor = gracze[index_nowy];

            socket.emit('nastepny gracz', {"color": nowy_kolor});
        }

        socket.on('send nastepny gracz', function(data) {
            proba = 0;
            var nowy_kolor = data['color'];
            aktualny_kolor = data['color'];

            $(".home").each(function() {

                $(this).removeClass('active_player');

            })

            $(".home." + nowy_kolor).addClass('active_player');


            if (kolor == nowy_kolor) {
                $("#kostka").prop('disabled', false);
                $("#kostka").click(function() {
                    open_kostka();
                })
            }
            size_of_pioneks();
        });

        function wyjdz_z_domku(numer_pionka, callback) {

            licznik[numer_pionka] = 1;

            socket.emit('ruch pionka', {"color": kolor, "pionek": numer_pionka, "ruch": "domek"})

            callback();

        }


        function poruszenie_sie(numer_pionka, rzut, tmp_background) {

            licznik[numer_pionka] += rzut;

            nowe_pole = getNextPosition(numer_pionka);

            if (licznik[numer_pionka] <= 40) {

                socket.emit('ruch pionka', {"color": kolor, "pionek": numer_pionka, "ruch": nowe_pole, "rzut": rzut});

                $(".pole." + nowe_pole).css("background", tmp_background);

            }

        }

        function wejscie_do_finish(numer_pionka, nowe_pole, tmp_background, callback) {

            licznik[numer_pionka] += rzut;

            $(".finish." + nowe_pole + "." + kolor).css("background", tmp_background);

            socket.emit('ruch pionka', {"color": kolor, "pionek": numer_pionka, "ruch": "finish", "finishPosition": nowe_pole});

            callback();

        }

        function send_pionki_na_mecie() {

            socket.emit('send pionki na mecie', {"color": kolor, "pionki_na_mecie": pionki_na_mecie})

            if (pionki_na_mecie == 4) {
                
                socket.emit('send player end', {"color": kolor});

            }

        }

        function end_game(last_player=false) {

            socket.emit('send info', {"msg": "<p class='greenMsg'></b>KONIEC GRYYY!</b></p>"});
            socket.emit('end game', {"last_player": last_player});

        }


        socket.on('send end game', function(data) {

            if (data['last_player']) {

                places.push(gracze[1]);

                var nick = $("#tab_" + gracze[1]).parent().children().eq(2).children().eq(0).html();

                $("#podium").children().eq(places.length-1).children().eq(1).html(nick);

                index = gracze.indexOf(nick);
                gracze.splice(index, 1);

            }
            $("#kostka").off();
            $("#kostka").prop('disabled', true);
            results();

        })


        socket.on('receive player end', function(data) {

            places.push(data['color']);

            $("#podium").children().eq(places.length-1).children().eq(1).html(data['nick']);
            
            index = gracze.indexOf(data['color']);
            gracze.splice(index, 1);

            if (places[places.length-1] == kolor) {
                if (gracze.length == 1) {

                    end_game();

                }

                if (gracze.length == 2) {

                    end_game(true);

                }
            }

        })

        
        socket.on('receive pionki na mecie', function(data) {

            nick = data['nick']
            color = data['color']
            pionki = data['pionki_na_mecie']

            $(".nick").each(function () {
                var tmp = this;

                if ($(tmp).html() == nick) {

                    $(tmp).parent().parent().children().eq(3).children().eq(0).html(pionki + "/4");

                    return false;
                }
            })

        });
        
        var mode = 1;
        function roll_dice_anim() {
            var myElm = $("#kostka");
            
            if(mode == 1){
                snabbt(myElm, {
                    rotation: [0, 0, -Math.PI],
                    easing: 'spring',
                });
                mode *= -1;
            }else{
                snabbt(myElm, {
                    rotation: [0, 0, Math.PI],
                    easing: 'spring',
                });
                mode *= -1;
            }
        }


        function open_kostka() {

            $("#kostka").prop('disabled', true);
            $(".pionek." + kolor).off();
            rzut = Math.floor(Math.random() * 6 + 1);

            socket.emit('get dice', {"dice": rzut});

            var ilosc_pionkow = 0;

            $(".pionek." + kolor).each(function() {

                if ($(this).parent().attr('class').indexOf("home") == -1) {

                    ilosc_pionkow++;

                }

            });

            var licznik_przejsc = 0;

            $(".pionek." + kolor).each(function() {

                var pionek = this;

                var numer_pionka = parseInt($(pionek).attr('class').split(" ")[2].slice(1, 2));
                
                if (licznik.every(item => (item == -1) || (item > 40))) {

                    proba_wyjscia = true;
                    
                    if (rzut == 6) {

                        proba = 0;

                        if ($(pionek).parent().attr('class').indexOf('home') > -1) {

                            $(pionek).css('cursor', 'pointer');
                            $(pionek).addClass('movable');

                            mozliwe_ruchy++;
                            ilosc_pionkow++;

                            $(pionek).click(() => {
                                wyjdz_z_domku(numer_pionka, function() {

                                    var nowe_pole = $(".start." + kolor).attr('class').split(" ")[1];

                                    check_if_pionek_do_zbicia(nowe_pole, function(czy_zbity) {

                                        ponowny_rzut();

                                    });

                                });
                            });
                        }

                    } else {

                        if ($(pionek).parent().attr('class').indexOf('home') > -1) {

                            $("#kostka").prop('disabled', false);

                        }
                        if ($(pionek).parent().attr('class').indexOf('finish') > -1) {

                            if (check_in_finish(numer_pionka, rzut) != -1) {

                                $(pionek).css('cursor', 'pointer');
                                $(pionek).addClass('movable');

                                $("#kostka").prop('disabled', true);

                                var nowe_pole = check_in_finish(numer_pionka, rzut);
                                var tmp_background = $(".finish." + nowe_pole + "." + kolor).css("background");

                                $(pionek).hover(function() {
                                    $(".finish." + nowe_pole + "." + kolor).css("background", "black")
                                }, function() {
                                    $(".finish." + nowe_pole + "." + kolor).css("background", tmp_background)
                                });

                                mozliwe_ruchy++;

                                $(pionek).click(() => {
                                    wejscie_do_finish(numer_pionka, nowe_pole, tmp_background, function() {

                                        nastepny_gracz();

                                    });
                                });

                            } else {

                                ilosc_pionkow--;

                            }

                        }
                    }

                } else {
                    if (licznik[numer_pionka] == -1) {

                        if (rzut == 6) {

                            $(pionek).css('cursor', 'pointer');
                            $(pionek).addClass('movable');
                            
                            mozliwe_ruchy++;
                            ilosc_pionkow++;

                            $(pionek).click(() => {
                                wyjdz_z_domku(numer_pionka, function() {

                                    var nowe_pole = $(".start." + kolor).attr('class').split(" ")[1];

                                    check_if_pionek_do_zbicia(nowe_pole, function(czy_zbity) {

                                        ponowny_rzut();

                                    });

                                });
                            });

                        }

                    } else {

                        if (licznik[numer_pionka] <= 40) {

                            if (returnPoleFinish(numer_pionka, rzut) == 0 ) {

                                $(pionek).css('cursor', 'pointer');
                                $(pionek).addClass('movable');

                                var nowe_pole = getNextPosition(numer_pionka, rzut);
                                var tmp_background = $(".pole." + nowe_pole).css("background");

                                $(pionek).hover(function() {
                                    $(".pole." + nowe_pole).css("background", "black")
                                }, function() {
                                    $(".pole." + nowe_pole).css("background", tmp_background)
                                });

                                mozliwe_ruchy++;

                                $(pionek).click(() => {

                                    poruszenie_sie(numer_pionka, rzut, tmp_background);

                                    var nowe_pole = getNextPosition(numer_pionka);

                                    check_if_pionek_do_zbicia(nowe_pole, function(czy_zbity) {

                                        if (czy_zbity) {

                                            ponowny_rzut();

                                        } else {

                                            if (rzut == 6) {

                                                if (!first_six) {

                                                    ponowny_rzut();
                                                    first_six = true;

                                                } else {

                                                    nastepny_gracz();

                                                }

                                            } else {

                                                nastepny_gracz();

                                            }

                                            
                                        }

                                    });

                                });

                                
                            } else if (returnPoleFinish(numer_pionka, rzut) != -1 ){

                                $(pionek).css('cursor', 'pointer');
                                $(pionek).addClass('movable');

                                var nowe_pole = returnPoleFinish(numer_pionka, rzut);
                                var tmp_background = $(".finish." + nowe_pole + "." + kolor).css("background");

                                $(pionek).hover(function() {
                                    $(".finish." + nowe_pole + "." + kolor).css("background", "black")
                                }, function() {
                                    $(".finish." + nowe_pole + "." + kolor).css("background", tmp_background)
                                });

                                mozliwe_ruchy++;

                                $(pionek).click(() => {

                                    pionki_na_mecie++;

                                    send_pionki_na_mecie();

                                    wejscie_do_finish(numer_pionka, nowe_pole, tmp_background, function() {

                                        if (rzut == 6) {

                                            if (!first_six) {

                                                ponowny_rzut();
                                                first_six = true;

                                            } else {

                                                nastepny_gracz();

                                            }

                                        } else {

                                            nastepny_gracz();

                                        }

                                    });
                                });

                            }

                        } else if (licznik[numer_pionka] < 44) {

                            if (check_in_finish(numer_pionka, rzut) != -1) {

                                $(pionek).css('cursor', 'pointer');
                                $(pionek).addClass('movable');

                                var nowe_pole = check_in_finish(numer_pionka, rzut);
                                var tmp_background = $(".finish." + nowe_pole + "." + kolor).css("background");

                                $(pionek).hover(function() {
                                    $(".finish." + nowe_pole + "." + kolor).css("background", "black")
                                }, function() {
                                    $(".finish." + nowe_pole + "." + kolor).css("background", tmp_background)
                                });

                                mozliwe_ruchy++;

                                $(pionek).click(() => {
                                    wejscie_do_finish(numer_pionka, nowe_pole, tmp_background, function() {

                                        nastepny_gracz();

                                    });
                                });

                            } else {

                                ilosc_pionkow--;

                            }
                        }
                    }
                }
                licznik_przejsc++;
            })

            if (!proba_wyjscia) {

                if (mozliwe_ruchy == 0) {

                    nastepny_gracz();
                    return false;

                }
            } else {

                proba++;

                if (proba == 3) {

                    nastepny_gracz();
                    return false;

                }

            }

        }


        function check_in_finish(numer_pionka, rzut) {

            var pole_aktualne = $(".finish." + $(".pionek.p" + numer_pionka + "." + kolor).parent().attr('class').split(" ")[1] + "." + kolor).attr('class').split(" ")[1];

            if (4 - parseInt(pole_aktualne) >= rzut) {

                var nowe_pole = parseInt(pole_aktualne) + rzut;

                if ($(".finish." + nowe_pole + "." + kolor).children().length > 0) {
                    if ($(".finish." + nowe_pole + "." + kolor).children().eq(0).prop('classList').length > 0) {
                        if ($(".finish." + nowe_pole + "." + kolor).children().eq(0).attr('class').indexOf("pionek") == -1) {

                            return nowe_pole;

                        } else {

                            return -1;

                        }
                    } else {

                        return -1;

                    }
                } else {

                    return nowe_pole;

                }

            } else {

                return -1;

            }

        }


        function returnPoleFinish(numer_pionka, rzut=0) {

            var pole_aktualne = $(".pionek." + kolor + ".p" + numer_pionka).parent().attr('class').split(" ")[1];

            if (((parseInt(licznik[numer_pionka]) + rzut) > 40) && ((parseInt(licznik[numer_pionka]) + rzut) <= 44)) {
                
                var pole_startu = $(".start." + kolor).attr('class').split(" ")[1];


                if (parseInt(pole_startu) < parseInt(pole_aktualne)) {
                    pole_startu = parseInt(pole_startu) + 40;
                }

                var roznica_do_mety = parseInt(pole_startu) - parseInt(pole_aktualne) - 1;

                var pole_mety = rzut - roznica_do_mety;

                if ($(".finish." + pole_mety + "." + kolor).children().length > 0) {
                    if ($(".finish." + pole_mety + "." + kolor).children().eq(0).prop('classList').length > 0) {
                        if ($(".finish." + pole_mety + "." + kolor).children().eq(0).attr('class').indexOf("pionek") == -1) {

                            return pole_mety;

                        } else {

                            return -1;

                        }
                    } else {

                        return -1;

                    }
                } else {

                    return pole_mety;

                }
   
            } else if (((parseInt(licznik[numer_pionka]) + rzut) <= 40)){

                return 0;

            } else if (((parseInt(licznik[numer_pionka]) + rzut) > 44)){

                return -1;

            } else {
                
                return -2;

            }

        }


        function getNextPosition(numer_pionka, rzut=0) {

            var pole_startu = $(".start." + kolor).attr('class').split(" ")[1];

            var nowe_pole = parseInt(pole_startu) + parseInt(licznik[numer_pionka]) + parseInt(rzut) - 1;

            if (nowe_pole > 40) {
                nowe_pole -= 40;
                return nowe_pole;
            } else {
                return nowe_pole;
            }
 
        }

    }); 

    function size_of_pioneks() {
    $(".pole, .finish").each(function() {
        if(this.childElementCount >= 3){
            $(this).children().addClass('pionek_50');
        }
        else if(this.childElementCount >= 4){
            $(this).children().addClass('pionek_25');
        }
        else{
            $(this).children().removeClass('pionek_50');
            $(this).children().removeClass('pionek_25');
        }
    });
}

</script>