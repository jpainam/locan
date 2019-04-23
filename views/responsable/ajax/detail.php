<table cellpadding = "5">
    <tr><td width = "20%" style="font-weight: bold">Nom : </td><td><?php echo $r['NOM']; ?></td></tr>
    <tr><td style="font-weight: bold">Pr&eacute;nom : </td><td><?php echo $r['PRENOM']; ?></td></tr>
    <tr><td style="font-weight: bold">T&eacute;l&eacute;phone : </td><td><?php echo $r['TELEPHONE']; ?></td></tr>
    <tr><td style="font-weight: bold">Portable : </td><td><?php echo $r['PORTABLE']; ?></td></tr>
    <tr><td style="font-weight: bold">Adresse : </td>
        <td><?php echo $r['ADRESSE']. ' BP.' . $r['BP']; ?></td></tr>
    <tr><td style="font-weight: bold">Email: </td><td><?php echo $r['EMAIL']; ?>
            &nbsp;&nbsp;&nbsp;<b>Profession : </b><?php echo $r['PROFESSION']; ?></td></tr>
</table>
<hr />

    <h2>El&egrave;ves dont il est parent</h2>
    <?php 
    foreach($eleves as $el){
        echo '- '. $el['NOM']. ' '. $el['PRENOM']. ' <br/>'
                . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                . '<b>Lien de parent&eacute; : ' . $el['PARENTE']. '</b><br/>';
    }
    ?>
