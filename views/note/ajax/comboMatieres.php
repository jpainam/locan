<option value=""></option>
<?php 
foreach($matieres as $mat){
    echo "<option value = '".$mat['IDENSEIGNEMENT']."'>".$mat['MATIERELIBELLE']."</option>";
}