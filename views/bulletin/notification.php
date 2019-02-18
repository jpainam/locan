<div id="entete">
    <div class="logo">
        
    </div>
    <div style="margin-left: 100px">
        <span class="select" style="width: 250px"><label>Classes : </label>
        <?php echo $comboClasses; ?>
        </span>
        <span class="select" style="width: 250px"><label>P&eacute;riodes : </label>
        <?php echo $comboPeriodes; ?>
        </span>
    </div>
</div>
<div class="page">
    <div style="text-align: center; margin: 0 5px 5px 5px">
        
        <input style="width: 350px; border: 2px outset buttonface; margin:0" type="button" 
               value="Envoyer un message contenant le bulletin r&eacute;capitulatif" 
               onclick="envoyerBulletin()"/>
    </div>
    <div id="bulletin-content">
    <table class="dataTable" id="tableBulletin">
        <thead>
            <tr><th>Classe</th><th>S&eacute;quence</th><th>Date</th><th>Parents &agrave; notifier</th><th>Messages envoy&eacute;s</th><th>Effectu&eacute;e par</th></tr>
        </thead>
        <tbody>
            <?php 
            if(!$notifications){
                $notifications = array();
            }
          
            $i = 1;
            $d = new DateFR();
            foreach($notifications as $not){
                $d->setSource($not['DATENOTIFICATION']);
                echo "<tr><td>".$not['NIVEAUHTML']."</td><td>".$not['LIBELLESEQUENCE']."</td><td align='right'>".$d->getDate()." ".$d->getMois(3)." ".$d->getYear()."</td>"
                        . "<td>".$not['NBREPARENT'].'</td><td>'.$not['NBREMESSAGE']."</td>"
                        . "<td>".$not['NOM'].' '.$not['PRENOM'].'</td></tr>';
                $i++;
            }
            ?>
        </tbody>
    </table>
    </div>
</div>
<div class="navigation">

</div>
<div class="status">

</div>