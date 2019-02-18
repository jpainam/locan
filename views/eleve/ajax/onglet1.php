<style>
    .photo-eleve{
        position: absolute;
        display: block;
        width: 130px;
        height: 150px;
        right: 0;
        margin-right: 20px;
        margin-top: 2px;
        border: 1px solid #CCC;
        background-color: #F7F7F7;
        border-radius: 5px;
        text-align: center;
        vertical-align: middle;
        line-height: 150px;
    }
</style>
<div class="fiche">
    <fieldset  style="width: 80%;float: none; margin: auto;margin-top: 20px"><legend>Identit&eacute;</legend>
        <img src="<?php echo $photo; ?>" alt="Photo eleve" class="photo-eleve">
        <table cellpadding = "5">
            <tr><td width = "20%" style="font-weight: bold">Nom : </td><td><?php echo $nom; ?></td></tr>
            <tr><td style="font-weight: bold">Pr&eacute;nom : </td><td><?php echo $prenom; ?></td></tr>
            <tr><td style="font-weight: bold">Sexe : </td><td><?php echo $sexe; ?></td></tr>
            <tr><td style="font-weight: bold">Lieu de r&eacute;sidence : </td><td><?php echo $residence; ?></td></tr>
            <?php
            $d = new DateFR($datenaiss);
            ?>
            <tr><td style="font-weight: bold">Date de naissance : </td>
                <td><?php echo $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear(); ?> &agrave; <?php echo $lieunaiss; ?></td></tr>
            <tr><td style="font-weight: bold">Pays de naissance : </td><td><?php echo $paysnaiss; ?>
                    &nbsp;&nbsp;&nbsp;<b>Pays de nationalit&eacute; : </b><?php echo $nationalite; ?></td></tr>
            <tr><td style="font-weight: bold">Fr&egrave;res et s&oelig;urs : </td><td><?php echo $freresoeur; ?></td></tr>
        </table>
    </fieldset>
    <fieldset style="width: 80%;float: none; margin: auto;margin-top: 20px"><legend>Scolarité actuelle</legend>
        <table cellpadding = "5">
            <tr><td  width = "20%" style="font-weight: bold">Classe : </td><td><?php
                    echo $niveau . " " . $classe;
                    if (!empty($classe)) {
                        echo "&nbsp;&nbspinscrit par " . $inscripteur['CIVILITE'] . " " . $inscripteur['NOM'];
                    }
                    ?></td></tr>
            <tr><td style="font-weight: bold">Redoublant : </td><td><?php echo $redoublant === true ? "Oui" : "Non"; ?>
                    &nbsp;et <?php
                    if (count($nbInscription) <= 1) {
                        if ($eleve['PROVENANCE'] == ETS_ORIGINE) {
                            echo "Ancien &agrave; l'IPW";
                        } else {
                            echo "Nouveau &agrave; l'IPW";
                        }
                    } else {
                        echo "Ancien &agrave; l'IPW";
                    }
                    ?></td></tr>
            <?php
            $d->setSource($dateentree);
            ?>
            <tr><td style="font-weight: bold">Date d'entr&eacute;e : </td>
                <td><?php
                    if (!empty($dateentree) && $dateentree != "0000-00-00" && $d->getYear() != 1970) {
                        echo $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear();
                    }
                    ?></td></tr>
            <tr><td style="font-weight: bold">Provenance : </td><td><?php echo $provenance; ?></td></tr>
            <?php
            $d->setSource($datesortie);
            ?>
            <tr><td style="font-weight: bold">Date de sortie : </td><td>
                    <?php
                    if (!empty($datesortie) && $datesortie != "0000-00-00" && $d->getYear() != 1970) {
                        echo $d->getDate() . " " . $d->getMois(3) . " " . $d->getYear();
                    }
                    ?>
                </td></tr>
            <tr><td style="font-weight: bold">Motif sortie : </td><td><?php echo $motifsortie; ?></td></tr>
        </table>

    </fieldset>
</div>