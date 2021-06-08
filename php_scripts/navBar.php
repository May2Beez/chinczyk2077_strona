<?php
    function logo() {
        $text = "";
        $text .= '<div class="head">';
        $text .= '    <div class="text">';
        $text .= '        <span aria-hidden="true">Chinczyk</span>';
        $text .= '        <p>Chinczyk</p>';
        $text .= '        <span aria-hidden="true">Chinczyk</span>';
        $text .= '    </div>';
            
        $text .= '    <div class="numbers">';
        $text .= '        <span aria-hidden="true">2077</span>';
        $text .= '        <p>2077</p>';
        $text .= '         <span aria-hidden="true">2077</span>';
        $text .= '     </div>';
        $text .= '</div>';

        echo $text;
    }

?>