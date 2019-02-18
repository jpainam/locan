<option value=""></option>
<option value="-1">Autre - Pr&eacute;ciser</option>
<?php
foreach ($arrondissements as $arr) {
    if (isset($lastinsert) && $arr['IDARRONDISSEMENT'] == $lastinsert) {
        echo "<option value='" . $arr['IDARRONDISSEMENT'] . "' selected='selected'>"
        . $arr['LIBELLE'] . "</option>";
    } else {
        echo "<option value='" . $arr['IDARRONDISSEMENT'] . "'>" . $arr['LIBELLE'] . "</option>";
    }
}