<style>
    .listePedagogie{
        border-collapse: collapse;
        font-size: 13px;
        margin: auto;
        width: 100%;
        background-color: #FFF;

    }
    .listePedagogie td{
        border: 1px solid #000;
        padding: 5px;
    }
</style>
<table class="listePedagogie">
    <thead><tr><th>Activit&eacute;s</th><th>Chapitres</th><th>S&eacute;quences</th></tr></thead>
    <tbody>
        <?php
        $previous = 0;
        foreach ($chapitres as $chap) {
            echo "<tr>";
            if ($previous != $chap['ACTIVITE']) {
                $nb = nbChapitres($chap['ACTIVITE'], $chapitres);
                echo "<td rowspan='" . $nb . "'>" . $chap['TITREACTIVITE'] . "</td>";
            }
            $previous = $chap['ACTIVITE'];
            echo "<td>" . $chap['TITRECHAPITRE'] . "</td>"
            . "<td style='width:20%'>" . $chap['TITRESEQUENCE'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php 
