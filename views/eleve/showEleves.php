<div id="entete">
    <div class="logo"><img src="<?php echo SITE_ROOT . "public/img/wide_saisieeleve.png"; ?>" /></div>
</div>
<script>
    $(document).ready(function () {
        $("#tableEleves").DataTable({
            ajax: {
                url: './lazyload',
                dataSrc: ''
            },
            "columns": [
                {data: "MATRICULE", width: "10%"},
                {data: "NOM", width: null},
                {data: "SEXE", width: "5%"},
                {data: "DATENAISS", width: "15%"},
                {data: "ACTION", width: "7%"}
            ]
        });
    });

</script>
<form action="<?php echo Router::url("eleve", "saisie"); ?>" method="post">
    <div class="page">
        <table class="dataTable" id="tableEleves">
            <thead><tr><th>Matricule</th><th>Noms et Pr&eacute;noms</th><th>Sexe</th><th>DateNaiss</th><th></th></tr></thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
    <!-- div class="recapitulatif">
    <?php //echo $total . " &eacute;l&egrave;ves"; ?>
    </div !-->
    <div class="navigation">
        <input type="hidden" value="true" name="saisie" />
        <img src="<?php echo SITE_ROOT . "public/img/btn_add.png" ?>" onclick="document.forms[0].submit();" />
    </div>
</form>
<div class="status"></div>
<?php
