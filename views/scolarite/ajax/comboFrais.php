<option></option>
<?php
foreach($frais as $f){
    echo "<option value = '".$f['IDFRAIS']."'>".$f['DESCRIPTION']. " - ".$f['MONTANT']." FCFA</option>";
}