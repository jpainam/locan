<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT."public/img/wide_user.png"; ?>" /></div>
</div>
<div class="page">
    <table class="dataTable" id="tableUser">
        <thead><tr><th>Login</th><th>Profile</th><th>Noms & Pr&eacute;noms</th><th>Actif</th><th></th></tr></thead>
        <tbody>
            <?php 
            foreach ($users as $u){
                echo "<tr><td>".$u['LOGIN']."</td><td>".$u['PROFILE']."</td><td>".$u['NOM'].' '.$u['PRENOM']."</td>";
                if($u['ACTIF'] == 1){
                    echo "<td align='center'><input type='checkbox' disabled checked /></td>";
                }else{
                    echo "<td align='center'><input type='checkbox' disabled /></td>";
                }
                if(isAuth(608)){
                    echo "<td align='center'><img style='cursor:pointer' src='".img_delete()."' "
                            . "onclick =\"document.location='".Router::url("user", "delete", $u['IDUSER'])."'\"/></td>";
                }else{
                    echo "<td align='center'><img style='cursor:pointer' src='".img_delete_disabled()."' /></td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
        
    </table>
</div>
<div class="navigation">
    <?php 
    if(isAuth(607)){
        echo btn_add("document.location='".Router::url("user", "saisie")."'");
    }else{
        echo btn_add_disabled();
    }
    ?>
</div>
<div class="status">
    
</div>