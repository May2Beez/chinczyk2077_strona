<html>
    <head>
        <meta charset="utf-8">
        <title>Chińczyk 2077 - Profil</title>
        <link href="css/everySite.css" type="text/css" rel="stylesheet">
        <link href="css/profil.css" type="text/css" rel="stylesheet">
        <link href="fontawesome/css/all.css" type="text/css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" data-auto-replace-svg="nest"></script>
        <script src="js/check_nick_and_servers.js" type="text/javascript"></script>
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
        <?php
            error_reporting(0); 
            /* -----------------------
            --------- Zmienne --------
            ------------------------ */
            $nick = "";
            $elo = 0;
            $opis = "Brak opisu";

            $next_rank = 0;

            $zagraneR = 0;
            $wygraneR = 0;
            $win_ratioR = 0;
            $avg_posR = 0;
            $p_straconeR = 0;
            $p_zbiteR = 0;

            $zagrane = 0;
            $wygrane = 0;
            $win_ratio = 0;
            $avg_pos = 0;
            $p_stracone = 0;
            $p_zbite = 0;
            
            /* -----------------------
            ------- Polaczenia -------
            ------------------------ */
            session_start();
            require_once "connect.php";
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

            if(isset($_GET['id'])){                   
                $id = $_GET['id'];
            }else if(isset($_SESSION['zalogowany'])){
                $id = $_SESSION['id'];
            }else{
                header('Location: index.php');
            }

            $wynik = $polaczenie->query("SELECT nick FROM users WHERE id = $id");               
            $users = $wynik->fetch_assoc();

            $wynik = $polaczenie->query("SELECT elo, opis FROM user_info WHERE id_user = $id");               
            $user_info = $wynik->fetch_assoc();

            $wynik = $polaczenie->query("SELECT pozycje, pionki_s_z FROM user_stats_no_rank WHERE id_user = $id");               
            $user_stats_no_rank = $wynik->fetch_assoc();
            
            $wynik = $polaczenie->query("SELECT pozycje, pionki_s_z FROM user_stats_rank WHERE id_user = $id");               
            $user_stats_rank = $wynik->fetch_assoc();

            
            
            $polaczenie->close();
            /* -----------------------
            ------- Obliczenia ------
            ------------------------ */

            $nick = $users['nick'];
            $opis = $user_info['opis'];
            $elo = $user_info['elo'];

            // $wynik = $polaczenie->query("SELECT r.nazwa_klasy FROM rangi r, user_info ui, users u WHERE u.nick = $nick AND u.id = ui.id_user AND ui.elo BETWEEN r.min AND r.max");               
            // $ranga = $wynik->fetch_assoc();
            // $rank_class = $ranga['nazwa_klasy'] . ' i path';

            if($elo < 1000){
                $next_rank = 1000;
                $rank_name = "Unranked";
                $rank_class = "unranked";
            }
            else if($elo > 999 && $elo < 1250){
                $next_rank = 1250;
                $rank_name = "Bronze";
                $rank_class = "bronze";
            }
            else if($elo > 1249 && $elo < 1500){
                $next_rank = 1500;
                $rank_name = "Silver";
                $rank_class = "silver";
            }
            else if($elo > 1499 && $elo < 1750){
                $next_rank = 1750;
                $rank_name = "Gold";
                $rank_class = "gold";
            }
            else if($elo > 1749 && $elo < 2000){
                $next_rank = 2000;
                $rank_name = "Diamond";
                $rank_class = "diamond";
            }
            else if($elo > 1999 && $elo < 20000){
                $next_rank = 20000;
                $rank_name = "Grand Master";
                $rank_class = "grand_master";
            }
            else if($elo > 19999){
                $next_rank = 20000;
                $rank_name = "Infinity Master";
                $rank_class = "infinity_master";
            }

            if($elo < 20000){
                $next_rank_display = $elo . " / " . $next_rank;
            }
            else{
                $next_rank_display = $elo . " / " . "-";
            }

            // Rankingowe
            $pozycje_R = explode(",", $user_stats_rank['pozycje']);
            $zagraneR = $pozycje_R[0] + $pozycje_R[1] + $pozycje_R[2] + $pozycje_R[3];
            $wygraneR = $pozycje_R[0];
            $win_ratioR = ($pozycje_R[0] / ($pozycje_R[0] + $pozycje_R[1] + $pozycje_R[2] + $pozycje_R[3])) * 100;
            $win_ratioR = round($win_ratioR, 2);
            $avg_posR = (($pozycje_R[0] * 1) + ($pozycje_R[1] * 2) + ($pozycje_R[2] * 3) + ($pozycje_R[3] * 4)) / $zagraneR;
            $avg_posR = round($avg_posR, 2);

            $pionkiR = explode(",", $user_stats_rank['pionki_s_z']);
            $p_straconeR = $pionkiR[0];
            $p_zbiteR = $pionkiR[1];

            // Nierankingowe
            $pozycje_NR = explode(",", $user_stats_no_rank['pozycje']);
            $zagrane = $pozycje_NR[0] + $pozycje_NR[1] + $pozycje_NR[2] + $pozycje_NR[3];
            $wygrane = $pozycje_R[0];
            $win_ratio = ($pozycje_NR[0] / ($pozycje_NR[0] + $pozycje_NR[1] + $pozycje_NR[2] + $pozycje_NR[3])) * 100;
            $win_ratio = round($win_ratio, 2);
            $avg_pos = (($pozycje_NR[0] * 1) + ($pozycje_NR[1] * 2) + ($pozycje_NR[2] * 3) + ($pozycje_NR[3] * 4)) / $zagrane;
            $avg_pos = round($avg_pos, 2);

            $pionkiNR = explode(",", $user_stats_no_rank['pionki_s_z']);
            $p_stracone = $pionkiNR[0];
            $p_zbite = $pionkiNR[1];

        ?>
        <section class="serversList">
            <div class="servers">

                <div id="p_box">
                    <span></span>

                    <div class="p_content">

                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 25%"></th>
                                    <th style="width: 10%"></th>
                                    <th style="width: 10%"></th>
                                    <th style="width: 10%"></th>
                                    <th style="width: 10%"></th>
                                    <th style="width: 10%"></th>
                                    <th style="width: 10%"></th>
                                    <th style="width: 10%"></th>
                                    <th style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tbody id="p_info">

                                <tr>
                                    <td rowspan="2"><div id="p_avatar"><img style="width: 200px; height: 200px" src="images/boardCenter2077.png"></img></div></td>
                                    <td><div id="p_nick"><?php echo $nick; ?></div></td>
                                    <td>ELO:</td>
                                    <td colspan="7" id="elo_cell">Next rank: <?php echo $next_rank_display ?><br><progress id="elo" value="<?php echo $elo ?>" max="<?php echo $next_rank ?>"><p></p></progress></td>
                                </tr>
                                <tr>
                                    <td id="p_opis_cell" colspan="7" style="text-align: left; resize: no"><div id="p_opis" style="overflow-wrap: break-word; overflow: auto"><?php echo $opis ?></div><hr></td>
                                    <td></td>
                                    <td style="width: 100%"></td>
                                </tr>
                                <tr>
                                    <td rowspan="2"><div class="tooltip"><div id="p_rank" class="<?php echo $rank_class ?>"><i class="fas fa-chess-pawn"></i></div><span class="tooltiptext"><?php echo $rank_name ?></span></div></td>
                                    <td style="color: purple">Rankingowe:</td>
                                    <td class="styl_b">Zagrane<hr><?php echo $zagraneR ?></td>
                                    <td class="styl_a">Wygrane<hr><?php echo $wygraneR ?></td>
                                    <td class="styl_b">Win ratio<hr><?php echo $win_ratioR ?>%</td>
                                    <td class="styl_a">Śr. pozycja<hr><?php echo $avg_posR ?></td>                                
                                    <td class="styl_b">P. stracone<hr><?php echo $p_straconeR ?></td>
                                    <td class="styl_a">P. zbite<hr><?php echo $p_zbiteR ?></td>      
                                    <td></td>
                                    <td style="width: 100%"></td>
                                </tr>
                                <tr>
                                    <td style="color: brown">Nierankingowe:</td>
                                    <td class="styl_b">Zagrane<hr><?php echo $zagrane ?></td>
                                    <td class="styl_a">Wygrane<hr><?php echo $wygrane ?></td>
                                    <td class="styl_b">Win ratio<hr><?php echo $win_ratio ?>%</td>
                                    <td class="styl_a">Śr. pozycja<hr><?php echo $avg_pos ?></td>                                
                                    <td class="styl_b">P. stracone<hr><?php echo $p_stracone ?></td>
                                    <td class="styl_a">P. zbite<hr><?php echo $p_zbite ?></td>  
                                    <td></td>
                                    <td style="width: 100%"></td>
                                </tr>
                                
                            </tbody>
                        </table>
                        
                    </div>
                    
                </div>
                    <?php
                        if(isset($_GET['id']) && $_GET['id'] == $_SESSION['id']){                   
                            echo "<a id='p_edit_b' href='konto.php'>Edytuj profil</a>";
                        }else if(!isset($_GET['id'])){
                            echo "<a id='p_edit_b' href='konto.php'>Edytuj profil</a>";
                        }
                    ?>
            </div>
  
    </body>
    <?php require_once "php_scripts/footer.php" ?>
</html>
