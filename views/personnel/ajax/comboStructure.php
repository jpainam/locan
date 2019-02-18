<option value=""></option>
<option value="-1">Autre - Pr&eacute;ciser</option>
<?php
foreach ($etablissements as $str) {
    if (isset($lastinsert) && $str['IDETABLISSEMENT'] == $lastinsert) {
        echo "<option value='" . $str['IDETABLISSEMENT'] . "' selected='selected'>"
        . $str['ETABLISSEMENT'] . "</option>";
    } else {
        echo "<option value='" . $str['IDETABLISSEMENT'] . "'>" . $str['ETABLISSEMENT'] . "</option>";
    }
}