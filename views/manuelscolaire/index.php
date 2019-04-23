<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_email.png"; ?>" /></div>
</div>
<div class="page">
    <div id="ajout-manuel-dialog" class="dialog" title="Ajouter des manuels scolaires">
        <span><label>Titre du manuel scolaire : </label>
            <input type="text" name = 'titre' style="width: 90%"/>
        </span>
        <span><label>Editeurs</label>
            <textarea style="width: 90%" name="editeurs" rows="4" cols="10"></textarea>
        </span>
        <span><label>Auteurs</label>
            <textarea style="width: 90%" name="auteurs" rows="4" cols="10"></textarea>
        </span>
        <span><label>Prix</label>
            <input style="width: 90%" name="prix" type="text" />
        </span>
    </div>
    <div id="edit-manuel-dialog" class="dialog" title="Modifier un manuel scolaire">
        <span><label>Titre du manuel scolaire : </label>
            <input type="text" name = 'edit_titre' style="width: 90%"/>
        </span>
        <span><label>Editeurs</label>
            <textarea style="width: 90%" name="edit_editeurs" rows="4" cols="10"></textarea>
        </span>
        <span><label>Auteurs</label>
            <textarea style="width: 90%" name="edit_auteurs" rows="4" cols="10"></textarea>
        </span>
        <span><label>Prix</label>
            <input style="width: 90%" name="edit_prix" type="text" />
        </span>
        <input type="hidden" name="idmanuel" value="" />
    </div>
    <div id="manuel-content">
        <table id="tableManuel" class='dataTable'>
            <thead><th>Titre du manuel</th><th>Editeurs</th><th>Auteurs</th><th>Prix</th>
            <th>Action</th></thead>
            <tbody>
                <?php
                if (isset($manuels) && !empty($manuels)) {
                    foreach ($manuels as $m) {
                        echo "<tr><td>" . $m['TITRE'] . "</td><td>" . $m['EDITEURS'] . "</td><td>"
                        . $m['AUTEURS'] . "</td><td align='right'>" . $m['PRIX'] . "</td>"
                        . "<td align='right'><img style='cursor:pointer' src='" . img_edit() . "' "
                        . "onclick=\"openEditForm(" . $m['IDMANUELSCOLAIRE'] .")\" />";
                        if (isAuth(244)) {
                            echo "&nbsp;&nbsp;<img style='cursor:pointer' src='" . img_delete() . "' "
                           . "onclick='supprimerManuel(" . $m['IDMANUELSCOLAIRE'] . ", \"". $m['TITRE']."\")' />";
                        } else {
                            echo "&nbsp;&nbsp;<img style='cursor:pointer' src='" . img_delete_disabled() . "' />";
                        }
                        echo "</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="navigation">
    <div class="editions" style="float: left">
        <input type="radio" value="excel" name="type_impression" />
        <img src="<?php echo img_excel(); ?>" />&nbsp;&nbsp;
        <input type="radio" value="pdf" name="type_impression" checked="checked" />
        <img src="<?php echo img_pdf(); ?>" />&nbsp;&nbsp;Editions:
        <select onchange="imprimer();" name = "code_impression">
            <option></option>
            <option value="0001">Liste des Manuels Scolaires</option>
        </select>
    </div>
    <div>
        <img src="<?php echo SITE_ROOT . "public/img/btn_add.png" ?>" id="ajout-manuel"/>
    </div>
</div>
<div class="status"></div>