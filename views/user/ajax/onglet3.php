<script>
    $(document).ready(function () {
        $("#dataTable").DataTable({
            /*"columnDefs": [
                {"width": "12%", "targets": 0},
                {"width": "5%", "targets": 1}
            ],*/
            "bInfo": false
        });
    });
</script>
<?php
echo $connexions;
