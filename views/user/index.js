$(document).ready(function(){
   $("#tableUser").DataTable({
      bInfo: false,
      paging: false,
      columns : [
          {"width" : "10%"},
          null,
          null,
          {"width" : "10%"},
          {"width" : "2%"}
      ]
   });
});