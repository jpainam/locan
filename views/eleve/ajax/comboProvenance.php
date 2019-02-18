<option value=""></option>
<option value='-1'>--Pr&eacute;ciser - Si nouveau--</option>
<?php
foreach ($etablissements as $ets) {
    if (isset($lastinsert) && $ets['IDETABLISSEMENT'] == $lastinsert) {
        echo "<option value='" . $ets['IDETABLISSEMENT'] . "' selected='selected'>"
        . $ets['ETABLISSEMENT'] . "</option>";
    } else {
        echo "<option value='" . $ets['IDETABLISSEMENT'] . "'>" . $ets['ETABLISSEMENT'] . "</option>";
    }
}