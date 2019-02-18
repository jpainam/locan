<option value=""></option>
<?php 
foreach($enseignants as $ens){
    echo "<option value='".$ens['IDPERSONNEL']."'>".$ens['NOM']." ". $ens['PRENOM']."</option>";
}