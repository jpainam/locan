<table class="dataTable" id="droitTable">
    <thead><tr><th>Date</th><th>El&egrave;ve</th><th>Ref. Caisse</th><th>Description</th><th>Montant</th>
            <th></th><th></th></tr></thead>
    <tbody>
        <?php
        //var_dump($operations);
        $d = new DateFR();
        $montant = 0;
        foreach ($operations as $op) {
            $d->setSource($op['DATETRANSACTION']);

            # $type = ($op['TYPE'] == "C" ? "CREDIT" : "DEBIT");
            $type = $op['TYPE'];
            if($type == 'R'){
                echo "<tr style='background-color:orange !important'>";
            }else{
                echo "<tr>";
            }
            echo "<td>" . $d->getDate() . '-' . $d->getMois(3) . "-" . $d->getYear(2) . "</td>"
            . "<td>" . $op['NOMEL'] . ' ' . $op['PRENOMEL'] . ".</td><td>" . $op['REFCAISSE'] . "</td>"
            . '<td>' . $op['DESCRIPTION'] . '</td><td align="right">' . moneyString($op['MONTANT']) . "</td>";

            echo "<td align='center' title='Restaurer'>";
            if (isAuth(532)) {
                echo "<img style='cursor:pointer' src='" . SITE_ROOT . "public/img/icons/restaurer.png' "
                . "onclick=\"document.location='" . Router::url("caisse", "restaurer", $op['IDCAISSE']) . "'\" />";
            } else {
                echo "<img src='" . img_valider_disabled() . "' />";
            }

            echo "</td><td align='center' title='Observations li&eacute;es &agrave; la suppression'>";
            # Modification car une observation existe deja
            if (!empty($op['OBSERVATIONS'])) {
                echo "<img style='cursor:pointer' src='" . SITE_ROOT . 'public/img/icons/observation.png' . "' "
                . "onclick=\"showObservation(" . $op['IDCAISSE'] . ", 1, 'S')\" />";
            } else {
                if (isAuth(535)) {
                    echo "<img style='cursor:pointer' src='" . SITE_ROOT . 'public/img/icons/observationadd.png' . "' "
                    . "onclick=\"showObservation(" . $op['IDCAISSE'] . ", 2, 'S')\" />";
                } else {
                    echo "<img style='cursor:pointer' src='" . img_valider_disabled() . "' />";
                }
            }
            echo "</td></tr>";
            $montant += intval($op['MONTANT']);
        }
        ?>
        <tr><td></td><td style='font-weight: bold'>TOTAL</td><td></td><td></td>
            <td style="text-align: right"><?php echo moneyString($montant); ?></td>
            <td></td><td></td></tr>
    </tbody>
</table>
<div id="observation-dialog-form" class="dialog" title="Ajouter/Modifier une Observation" >
    <span><label>Observations</label>
        <textarea rows="3" cols="10" name="observations" style="width: 100%" ></textarea>
    </span>
    <span><label>Date de saisie de l'observation</label>
        <input type="text" name="dateobservation" style="width: 100%" /></span>
</div>

<script>
    ___idcaisse = 0;
    ___type = 'S';
    $(document).ready(function () {
        $("input[name='dateobservation']").datepicker({});

        if (!$.fn.DataTable.isDataTable("#droitTable")) {
            $("#droitTable").DataTable({
                scrollY: $(".page").height() - 175,
                columns: [
                    {"width": "7%"},
                    null,
                    {"width": "12%"},
                    null,
                    {"width": "8%"},
                    {"width": "5%"},
                    {"width": "5%"}
                ]
            });
        }
        $("#observation-dialog-form").dialog({
            autoOpen: false,
            height: 260,
            width: 375,
            modal: true,
            resizable: true,
            buttons: {
                Valider: function () {
                    miseAjourObservation();
                    $(this).dialog("close");
                },
                Annuler: function () {
                    $(this).dialog("close");
                }
            }
        });
    });
    function showObservation(idcaisse, etat, type) {
        ___idcaisse = idcaisse;
        ___type = type;
        $("input[name='dateobservation']").attr("disabled", "disabled");
        $("textarea[name=observations]").attr("disabled", "disabled");

        if (etat === 1) {
            $.ajax({
                url: "./ajaxobservation",
                type: "POST",
                dataType: "json",
                data: {
                    idcaisse: ___idcaisse,
                    action: "getobservation",
                    type: type
                },
                success: function (result) {
                    $("input[name='dateobservation']").datepicker("setDate", new Date(result[0]));
                    $("textarea[name=observations]").val(result[1]);
                    $("input[name='dateobservation']").removeAttr("disabled");
                    $("textarea[name=observations]").removeAttr("disabled");
                },
                error: function (xhr, status, error) {
                    alert("Une erreur X1 s'est produite " + xhr + " " + error);
                }
            });
        } else {
            $("input[name='dateobservation']").datepicker("setDate", new Date());
            $("textarea[name=observations]").val("");
            $("input[name='dateobservation']").removeAttr("disabled");
            $("textarea[name=observations]").removeAttr("disabled");
        }
        $("#observation-dialog-form").dialog("open");

    }
    function miseAjourObservation() {
        $.ajax({
            url: "./ajaxobservation",
            type: "POST",
            dataType: "json",
            data: {
                idcaisse: ___idcaisse,
                observations: $("textarea[name=observations]").val(),
                dateobservation: $("input[name=dateobservation]").val(),
                action: "miseajour",
                type: ___type
            },
            success: function (result) {
                alertWebix(result[0]);
                if (result[1]) {
                    $("#onglet3").html(result[1]);
                    $("#onglet4").html(result[2]);
                }
            },
            error: function (xhr, status, error) {
                alert("Une erreur X2 s'est produite " + xhr + " " + error);
            }
        });
    }
</script>
