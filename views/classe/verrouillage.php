<div id="entete">
    <div class="logo">
        <img src="<?php echo SITE_ROOT . "public/img/wide_sequence.png"; ?>" />
    </div>
    <div style="margin-left: 100px">
        <span class="select" style="width: 250px">
            <label>S&eacute;quences : </label>
            <?php
            echo $comboSequences;
            ?>
        </span>
    </div>
</div>
<div class="page">
    <div id="classe-content">
        <table class="dataTable" id="classeTable">
            <thead><tr><th>N°</th><th>Libell&eacute;</th>
                    <th><img src="<?php echo SITE_ROOT . "public/img/lock.png"; ?>" /></th>
                    <th></th></tr></thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<div class="navigation">

</div>
<div class="status"></div>