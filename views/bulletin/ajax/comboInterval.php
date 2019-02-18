<?php
echo "<option></option>";
$nbEleve = count($eleves);
for ($i = 1; $i <= $nbEleve; $i++) {
    echo "<option value='" . $i . "'>" . $i . "</option>";
}
                    