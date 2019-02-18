<?php

$data = array();
$d = new DateFR();
foreach ($eleves as $el) {
    $d->setSource($el['DATENAISS']);
    $action =  "";
    if (isAuth(520)) {
        $action .= "<img style='cursor:pointer' src='" . img_edit() . "' "
        . "onclick=\"document.location='" . Router::url("eleve", "edit", $el['IDELEVE']) . "'\" />";
    } else {
        $action .= "<img style='cursor:pointer' src='" . img_edit_disabled() . "' />";
    }

    if (isAuth(521)) {
        $action .= "&nbsp;&nbsp;<img style='cursor:pointer' src='" . img_delete() . "' "
        . "onclick='supprimerEleve(".$el['IDELEVE'].")' />";
    } else {
        $action .= "&nbsp;&nbsp;<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
    }
    $datenaiss = $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear();
    $line_nom = "<span style='cursor:pointer;display:block' "
            . "onclick=\"ouvrirFiche(".$el['IDELEVE'].")\">".$el['NOM']." ".$el['PRENOM']."</span>";
    $row = [
        "MATRICULE" => $el['MATRICULE'],
        "NOM" => $line_nom,
        "SEXE" => $el['SEXE'],
        "DATENAISS" =>  $datenaiss,
        "ACTION" => $action
     ];
   
    $data[] = $row;
}
echo json_encode($data);