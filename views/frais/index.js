$(document).ready(function () {
    $("#fraisTable").DataTable({
        "bInfo": false,
        "searching": false,
        "paging": false,
        scrollY : $(".page").height() - 50,
        "columns": [
            {"width": "20%"},
            null,
			null,
            {"width": "15%"},
            {"width": "15%"},
            {"width": "5%"}
        ]
    });
});