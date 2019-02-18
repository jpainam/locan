<table class="dataTable" cellpadding='0' id="tableAppel">
    <thead><tr><th>N°</th><th>Noms & Pr&eacute;noms</th>
            <?php
            for ($j = 1; $j <= HEURE_TRAVAIL; $j++) {
                if ($j === 1) {
                    echo "<th>1<sup>&egrave;re</sup>H</th>";
                } else {
                    echo "<th>" . $j . "<sup>&egrave;me</sup>H</th>";
                }
            }
            ?>
            <th><img src="<?php echo img_phone_ring(); ?>" /></th>
        </tr></thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($enseignants as $ens) {
            echo "<tr>";
            if ($i < 10) {
                echo "<td>0" . $i . "</td>";
            } else {
                echo "<td>" . $i . "</td>";
            }
            echo "<td>" . $ens['NOM'] . " " . $ens['PRENOM'] . "</td>";
            for ($j = 1; $j <= HEURE_TRAVAIL; $j++) {
                $abs = enseignantAbsent($ens['IDPERSONNEL'], $absences, $j);
                if ($abs === null) {
                    echo "<td class='present'></td>";
                } elseif ($abs['ETAT'] === "A") {
                    echo "<td class='absent'></td>";
                } elseif ($abs['ETAT'] === "R") {
                    echo "<td class='retard' align='center'>".$abs['RETARD']."</td>";
                } else {
                    echo "<td></td>"; # Ne dois jamais arriver ici
                }
            }
            # Pour l'envoi de SMS
            echo "<td align='center' title='Nombre de notification envoyee'>"
            . "<img style='cursor:pointer' src='" . img_phone_add() . "' </td>";

            echo "</tr>";
            $i++;
        }
        ?>
    </tbody>

</table>
<p style="color: #0033cc;margin: 0;padding: 0; text-align: right; margin-top: 5px; margin-right: 10px;">
    Appel d&eacute;j&agrave; r&eacute;alis&eacute; par <?php
    echo $appel['NOMREALISATEUR'] . " " . $appel['PRENOMREALISATEUR'];
    if (isAuth(320)) {
        echo "&nbsp;&nbsp;|&nbsp;&nbsp;Editer <a href='" . Router::url("enseignant", "discipline", ["edit",$appel['IDAPPELENSEIGNANT']]) . "'>ici</a>";
    }
    if (isAuth(324)) {
        echo "&nbsp;&nbsp;|&nbsp;&nbsp;Supprimer <a href='" . Router::url("enseignant", "appel", $appel['IDAPPELENSEIGNANT']) . "'>ici</a>";
    }
    ?></p>
<p style="margin:5px 10px 0 10px; padding: 0">
    <?php echo $legendes; ?>
</p>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableAppel")) {
            $("#tableAppel").DataTable({
                "bInfo": false,
                "paging": false,
                "searching": false,
                "scrollY": $(".page").height() - 100,
                "columnDefs": [
                    {"width": "5%", "targets": 0}
                ]

            });
        }
    });
</script>