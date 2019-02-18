<script type="text/javascript">
    var tab, jsonOnglet2;
    tab = $("#onglet2_table").DataTable({
        "paging": false,
        "bInfo": false,
        "scrollY": 300,
        "searching": false,
        "columns": [
            {"width": "15%"},
            {"width": "60%"},
            {"width": "25%"}
        ]
    });
    tab.columns.adjust().draw();
    
    tab.row().on("click", function (e) {
        var tr = e.target.parentNode, td = tr.firstChild, in1 = td.firstChild, d = null;
        for (var i = 0; i < jsonOnglet2.length; i++)
            if (jsonOnglet2[i].IDRESPONSABLE === parseInt(in1.value))
                d = jsonOnglet2[i];
        if(d === null) 
            return;
        document.getElementById("accident").removeAttribute("checked");
        document.getElementById("financier").removeAttribute("checked");
        
        document.getElementById("contact").removeAttribute("checked");
        
        update(eval(d.CHARGES));
        $("#identite").text(d.CIVILITE + " " + d.NOM + " " + d.PRENOM);
        $("#parente").text(d.PARENTE);
        $("#adresse").text(d.ADRESSE + " " + d.BP);
        $("#tel1").text(d.TELEPHONE);
        $("#tel2").text(d.PORTABLE);
        $("#tel3").text(d.NUMSMS);
        $("#email").text(d.EMAIL);
        $("#prof").text(d.PROFESSION);
        $("#sms").text((parseInt(d.ACCEPTESMS) !== 0) ? "OUI -TEL. :" + d.NUMSMS : "NON");

    });

    function addJson(json) {
        jsonOnglet2 = json;
    }

    function update(charges) {
        //alert(charges.length);
        for (var i = 0; i < charges.length; i++) {
            switch (charges[i]) {
                case "Accident":
                    $("#accident").attr({
                        checked: "checked"});
                    break;
                case "Financier":
                    $("#financier").attr({
                        checked: "checked"});
                    break;
                case "Contact":
                    $("#contact").attr({
                        checked: "checked"});
                    break;
            }
        }
    }

</script>
<style>
    #onglet2_table tbody tr{
        cursor: pointer;
    }
    #onglet2_table tbody tr td{
        text-align: center;
    }
    .detail span {
        height: 15px !important;
        margin-bottom: 5px !important;
    }
    .detail span label:first-child{
        position: relative !important;
        width: 48% !important;
        float: left;
        text-align: right;
        left: 3px !important;
        color: #B63B00;
    }

    .detail span label{
        position: relative !important;
        width: 50% !important;
        float: right;
    }
    .lab{
        font-weight: bolder !important;
    }

    .detail span span{
        /*background-color: yellow;*/
        text-align: left !important;
    }
    .detail span input{
        position: static !important;
        display: inline;
    }

</style>

<?php

function getTbody($table) {
    $str = "";
    for ($i = 0; $i < count($table); $i++) {
        $str.= "<tr>";
        $str.= "<td><input type = 'hidden' value= \"" . $table[$i]["IDRESPONSABLE"] . "\"/>" .
                $table[$i]["CIVILITE"] . "</td>" .
                "<td>" . $table[$i]["NOM"] . "  " . $table[$i]["PRENOM"] . "</td>" .
                "<td>" . $table[$i]["PARENTE"] . "</td>";
        $str.= "</tr>";
    }
    return $str;
}
?>

<script type="text/javascript">addJson(<?php echo json_encode($dataOnglet2) ?>);</script>
<fieldset style="width: 45%; margin-left: 5px; height: 80%;"><legend>Responsable</legend>
    <div>
        <table class="dataTable" id="onglet2_table">
            <thead><th>Civ.</th><th>Nom & Prenom</th><th>Parenté</th></thead>
            <tbody><?php echo getTbody($dataOnglet2); ?></tbody>
        </table>
    </div>
</fieldset>



<fieldset style="width: 45%; margin-left: 25px; height: 80%;" class="detail"><legend>Detail du Responsable</legend>
    <span style="margin-right: 50px"><input type="checkbox" id="accident" value="Accident" disabled="disabled">Accident</span>
    <span style="margin-right:  50px"><input type="checkbox" id="contact" value="Contact" disabled="disabled">Contact</span>
    <span><input type="checkbox" id="financier" value="Financier" disabled="disabled">Financier</span>

    <span class="text" style=" width: 100%; margin-top: 20px;"><label>Identit&eacute; :</label><label id="identite" class="lab"></label></span>
    <span class="text" style=" width: 100%; "><label>Lien de parent&eacute; :</label><label id="parente" class="lab"></label></span>
    <span class="text" style=" width: 100%;  height: 60px !important;"><label>Adresse :</label><label id="adresse" class="lab"></label></span>
    <span class="text" style=" width: 100%; margin-top: 0;"><label>T&eacute;l&eacute;phone :</label><label id="tel1" class="lab"></label></span>
    <span class="text" style=" width: 100%; "><label>Tel. Portable :</label><label id="tel2" class="lab"></label></span>
    <span class="text" style=" width: 100%; "><label>Envoi de SMS :</label><label id="sms" class="lab"></label></span>
    <span class="text" style=" width: 100%; "><label>Tel. Professionnel :</label><label id="tel3" class="lab"></label></span>
    <span class="text" style=" width: 100%; "><label>Email :</label><label id="email" class="lab"></label></span>
    <span class="text" style=" width: 100%; "><label>Profession :</label><label id="prof" class="lab"></label></span>
</fieldset>
</div>



