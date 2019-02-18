<option></option>
<?php 
foreach($eleves as $el){
    echo "<option value = '".$el['IDELEVE']."'>".$el['NOM']. " ".$el['PRENOM']."</option>";
}