<option value=""></option>
<?php
foreach($comptes as $c){
    echo "<option value = '".$c['IDCOMPTE']."'>".$c['NOM'].' '.$c['PRENOM']."</option>";
}