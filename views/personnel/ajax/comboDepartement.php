<option value=""></option>
<option value="-1">Autre - Pr&eacute;ciser</option>
<?php
foreach ($departements as $dep) {
    if (isset($lastinsert) && $dep['IDDEPARTEMENT'] == $lastinsert) {
        echo "<option value='" . $dep['IDDEPARTEMENT'] . "' selected='selected'>"
        . $dep['LIBELLE'] . "</option>";
    } else {
        echo "<option value='" . $dep['IDDEPARTEMENT'] . "'>" . $dep['LIBELLE'] . "</option>";
    }
}