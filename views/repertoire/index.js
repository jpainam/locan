$(document).ready(function(){
   $("#tableRepertoire").DataTable({
       "bInfo": false,
       "paging": false,
       columns: [
           {"width": "7%"},
           null,
           null,
           {"width" : "10%"},
           {"width" : "15%"}
       ]
   }) 
});