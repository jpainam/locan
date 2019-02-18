$(document).ready(function () {
    $("#punitionTable").DataTable({
        "bInfo": false,
        "columnDefs": [
            {"width": "10%", "targets": 0},
            {"width": "7%", "targets": 5},
            {"width": "7%", "targets": 6}
        ]
    });
});
function supprimerPunition(_id){
    if(confirm("Etes vous sur de vouloir effectuer cette suppression?")){
        document.location = "./punition/delete/"+_id;
    }
}

function printPunition(_id){
    //document.op
    window.open("./punition/imprimer/" + _id, "_blank");
}