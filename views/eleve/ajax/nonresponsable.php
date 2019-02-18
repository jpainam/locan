<?php
foreach ($nonresponsable as $non){
    echo "<option value = '".$non['IDRESPONSABLE']."'>".$non['CIVILITE']."-" . $non['NOM']." ".$non['PRENOM']."</option>";
}