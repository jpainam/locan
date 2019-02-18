<style>
    .dataTable .centrer{
        text-align: center;
    }
</style>
<div id="entete" style="height: 70px">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_appel.png"; ?>" /></div>
    <div style="margin-left: 100px">
        <span class="text" style="width: 250px; margin-top: 0"><label>Date de l'appel</label>
            <input disabled="disabled" value="<?php
            $d = new DateFR($appel['DATEJOUR']);
            echo $d->getJour(3) . " " . $d->getDate() . " " . $d->getMois() . " " . $d->getYear()
            ?>" />
        </span>
        <span class="select" style="width: 255px; margin-top: 0;clear: both; "><label>Classes : </label>
            <?php echo $comboClasses; ?></span>

    </div>
</div>
<form name="formAppel" action="<?php echo Router::url("appel", "edit", $appel['IDAPPEL']); ?>" method="post">
    <div class="page">
        <?php
        $colonnes = getNbHoraire($classe['GROUPE']);
        echo "<input type='hidden' name = 'idappel' value='".$appel['IDAPPEL']."' />";
        ?>
        <table class="dataTable" cellpadding='0' id="tableAbsences">
            <thead><tr><th>N°</th><th>Noms & Pr&eacute;noms</th>
                    <?php
                    for ($j = 1; $j <= $colonnes; $j++) {
                        if ($j === 1) {
                            echo "<th>1<sup>&egrave;re</sup>H</th>";
                        } elseif ($j !== $colonnes) {
                            echo "<th>" . $j . "<sup>&egrave;me</sup>H</th>";
                        } else {
                            echo "<th>" . $j . "<sup>&egrave;me</sup>H</th>";
                        }
                    }
                    ?>
                </tr></thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($eleves as $el) {
                    $mat = $el['MATRICULE'];
                    echo "<tr>";
                    if ($i < 10) {
                        echo "<td>0" . $i . "</td>";
                    } else {
                        echo "<td>" . $i . "</td>";
                    }
                    echo "<td>" . $el['NOM'] . " " . $el['PRENOM'] . "</td>";
                    for ($j = 1; $j <= $colonnes; $j++) {
                        $abs = estAbsent($el['IDELEVE'], $absences, $j);
                        if (!empty($abs['JUSTIFIER'])) {
                            $class = "justifier";
                        }if (!is_null($abs) && $abs['ETAT'] === "A") {
                            $class = "absent";
                        } elseif (!is_null($abs) && $abs['ETAT'] === "R") {
                            $class = "retard";
                        } elseif (!is_null($abs) && $abs['ETAT'] === "E") {
                            $class = "exclu";
                        } else {
                            $class = "";
                        }
                        echo "<td class='centrer $class'><select name='" . $mat . "_" . $j . "' onchange='choisir(this);'>";
                        echo "<option " . (is_null($abs) ? "selected" : "") . "></option>";
                        echo "<option " . (!is_null($abs) && $abs['ETAT'] === "A" ? "selected" : "") . " value='A'>A</option>";
                        echo "<option " . (!is_null($abs) && $abs['ETAT'] === "R" ? "selected" : "") . " value='R'>R</option>";
                        echo "<option " . (!is_null($abs) && $abs['ETAT'] === "E" ? "selected" : "") . " value='E'>E</option>";
                    }
                    echo "</tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
        <p style="margin:5px 10px 0 10px; padding: 0">
            <label style="font-weight: bold;text-decoration: underline">L&eacute;gendes:</label>&nbsp;&nbsp;
            <span class="present"></span><b>P : </b>Pr&eacute;sent &nbsp;&nbsp;&nbsp; 
            <span class="absent"></span><b>A : </b> Absent &nbsp;&nbsp;&nbsp;
            <span class="retard">R</span><b>R : </b>en Retard &nbsp;&nbsp;&nbsp;
            <span class="exclu">E</span><b>E : </b>Exclu de cours&nbsp;&nbsp;&nbsp;
            <span class="justifier">&nbsp;&nbsp;&nbsp;&nbsp;</span><b>A : </b> Absence justifi&eacute;e
        </p>
    </div>
    <p style="color: #0033cc;margin: 0;padding: 0; text-align: right;margin-right: 10px;">
        Appel pr&eacute;c&eacute;demment r&eacute;alis&eacute; par <?php echo $appel['NOMREALISATEUR']." ".$appel['PRENOMREALISATEUR']; ?></p>
    <div class="navigation">
        En cochant cette case, vous certifiez l'exactitude des donn&eacute;es saisies 
        en votre nom : <input style="vertical-align: middle;" type="checkbox" name="certifier" />
        <?php echo btn_save_appel("validerAppel();"); ?>
    </div>
</form>
<div class="status">

</div>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable("#tableAbsences")) {
            $("#tableAbsences").DataTable({
                "bInfo": false,
                "paging": false,
                "searching": false,
                "scrollY": $(".page").height() - 80

            });
        }
    });
</script>