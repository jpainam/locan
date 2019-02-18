<div id="entete">
    <div class="logo"></div>
    <div style="margin-left: 100px">
        <span class="select" style="width: 250px"><label>Classes : </label>
            <?php echo $comboClasses; ?></span>
        <span class="select" style="width: 250px"><label>Enseignements : </label>
            <select name="comboEnseignements">
                <option></option>
            </select></span>
    </div>
</div>
<form name="frmProgrammation" action="<?php echo Router::url("pedagogie", "programmation"); ?>" method="post">
    <div class="page">

    </div>

    <div class="navigation">
        <?php
        if (isAuth(526)) {
            echo btn_ok("validerProgrammation()");
        }
        ?>
    </div>
    <input type="hidden" name="idenseignement" value="" />
</form>
<div class="status">

</div>
<?php 
