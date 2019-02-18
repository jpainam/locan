<legend>Choix des &eacute;l&egrave;ves</legend>
<?php
foreach($absences as $abs){
    echo "<input type = 'checkbox' /><span style ='margin-right:10px'>".$abs['NOM']." ".$abs['PRENOM']."</span>";
}