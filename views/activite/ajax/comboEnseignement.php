<option value=""></option>
<?php
foreach($enseignements as $ens){
    echo "<option value='".$ens['IDENSEIGNEMENT']."'>".$ens['MATIERELIBELLE']."</option>";
}
