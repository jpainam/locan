<style>
    .olChapitre, .olLecon, .olChapitre li, .olLecon li{
        padding: 0;
        margin: 0 20px auto;
    }
    .olChapitre li{
        list-style-type: upper-roman;
        font-size: 15px;
        color: #B63B00;
    }
    .olLecon li{
        font-size: 12px;
        list-style-type: decimal;
        color: black;
    }
</style>

<?php
echo "<ol class='olChapitre'>";
$previousChap = 0;
$firstChap = true;
foreach ($lecons as $le) {
    if ($previousChap != $le['IDCHAPITRE']) {
        if (!$firstChap) {
            # Fermer le chapitre precedent si ce n'est pas le premier chapitre
            echo "</ol></li>";
            
        }
        echo "<li>" . $le['TITRECHAPITRE'];
        echo "<ol class='olLecon'>";
    }
    echo "<li>" . $le['TITRELECON'] . "</li>";
    $previousChap = $le['IDCHAPITRE'];
    $firstChap = false;
}
echo "</li></ol>";
