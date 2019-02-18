<option></option>
<?php 
# Generer les options de mois si $periode = 1
if($periode == 1){
    $mois = getMonthOfTheYear($anneeacademique);
    foreach ($mois as $key => $val){
        echo "<option value = '".$key."'>".$val."</option>";
    }
}elseif($periode == 2){
    foreach($sequences as $seq){
        echo "<option value ='".$seq['IDSEQUENCE']."'>".$seq['LIBELLE']."</option>";
    }
}elseif ($periode == 3) {
    foreach($trimestres as $trim){
        echo "<option value ='".$trim['IDTRIMESTRE']."'>".$trim['LIBELLE']."</option>";
    }
}elseif ($periode == 4) {
    foreach($annee as $an){
        echo "<option value ='".$an['ANNEEACADEMIQUE']."'>".$an['ANNEEACADEMIQUE']."</option>";
    }
}