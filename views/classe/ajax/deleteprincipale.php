<script>
    if (!$.fn.DataTable.isDataTable("#tab_pp")) {
        $('#tab_pp').DataTable({
            "paging": false,
            "bInfo": false,
            "searching": false,
            "scrollCollapse": true,
            "columns": [
                {"width": "20%"},
                null,
                {"width": "5%"}
            ]
        });
    }
    if (!$.fn.DataTable.isDataTable("#tab_ra")) {
        $("#tab_ra").DataTable({
            "paging": false,
            "bInfo": false,
            "searching": false,
            "scrollCollapse": true,
            "columns": [
                {"width": "20%"},
                null,
                {"width": "5%"}
            ]
        });
    }
    if (!$.fn.DataTable.isDataTable("#tab_cpe")) {
        $("#tab_cpe").DataTable({
            "paging": false,
            "bInfo": false,
            "searching": false,
            "scrollCollapse": true,
            "columns": [
                {"width": "20%"},
                null,
                {"width": "5%"}
            ]
        });
    }
</script>

<table class="dataTable" id="<?php echo $tableid; ?>">
    <thead><tr><th>Matricule</th><th>Nom et Pr&eacute;nom</th><th></th></tr></thead>
    <tbody>
    </tbody>
</table>