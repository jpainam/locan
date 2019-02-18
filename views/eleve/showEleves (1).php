<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_saisieeleve.png"; ?>" /></div>
</div>
<script>
    $(document).ready(function () {
        $("#tableEleves").DataTable({
            ajax: {
                url: './lazyload',
                dataSrc: ''
            },
            "columns": [
                {data: "MATRICULE", width: "10%"},
                {data: "NOM", width: null},
                {data: "SEXE", width: "5%"},
                {data: "DATENAISS", width: "15%"},
                {data: "ACTION", width: "7%"}
            ]
        });
    });

</script>
<form action="<?php echo Router::url("eleve", "saisie"); ?>" method="post">
    <div class="page">
        <table class="dataTable" id="tableEleves">
            <thead><tr><th>Matricule</th><th>Noms et Pr&eacute;noms</th><th>Sexe</th><th>DateNaiss</th><th></th></tr></thead>
            <tbody>
                <?php
                /*$d = new DateFR();
                foreach ($eleves as $el) {
                    echo "<tr><td>". $el['MATRICULE'] . "</td>"
                            . "<td style='cursor:pointer' onclick=\"ouvrirFiche(".$el['IDELEVE'].")\">" . $el['NOM'] . " " . $el['PRENOM'] . "</td>"
                    . "<td>" . $el['SEXE'] . "</td>";
                    $d->setSource($el['DATENAISS']);
                    echo "<td>" . $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear() . "</td>";
                    echo "<td align='center'>";
                    if (isAuth(520)) {
                        echo "<img style='cursor:pointer' src='" . img_edit() . "' "
                        . "onclick=\"document.location='" . Router::url("eleve", "edit", $el['IDELEVE']) . "'\" />";
                    } else {
                        echo "<img style='cursor:pointer' src='" . img_edit_disabled() . "' />";
                    }

                    if (isAuth(521)) {
                        echo "&nbsp;&nbsp;<img style='cursor:pointer' src='" . img_delete() . "' "
                        . "onclick='supprimerEleve(".$el['IDELEVE'].")' />";
                    } else {
                        echo "&nbsp;&nbsp;<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
                    }

                    echo "</td></tr>";
                }*/
                ?>
            </tbody>
        </table>
    </div>
    <!-- div class="recapitulatif">
    <?php //echo $total . " &eacute;l&egrave;ves"; ?>
    </div !-->
    <div class="navigation">
        <input type="hidden" value="true" name="saisie" />
        <img src="<?php echo SITE_ROOT . "public/img/btn_add.png" ?>" onclick="document.forms[0].submit();" />
    </div>
</form>
<div class="status"></div>
<?php
