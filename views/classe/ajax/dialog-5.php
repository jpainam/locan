<?php
foreach($matieres as $mat){
    echo "<option value = '".$mat['IDMATIERE']."'>".$mat['LIBELLE']."</option>";
}