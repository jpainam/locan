/*var tabres = [];
 tabres = $("input[name=charge]:checked");
 console.log(tabres[0].value);*/


/* data: {
 file: filename
 },
 */
//$('div.dataTables_scrollBody').height( 100 );

/*// Using validation to check for the presence of an input
 $("#form").submit(function (event) {
 // If .required's value's length is zero
 if ($(".required").val().length === 0) {
 // Usually show some kind of error message here
 // Prevent the form from submitting
 event.preventDefault();
 } else {
 // Run $.ajax() here
 }
 });
 
 $("button").click(function(){
 $.ajax({url: "demo_test.txt", success: function(result){
 $("#div1").html(result);
 ,
 error: function (xhr, status, error) {
 alert("Erreur de type : " + error);
 }
 }});
 $.ajax({
 url: 'ajax/personnel',
 type: "GET",
 data: $("function").val(),
 success: function (data) {
 $("#personnel")
 },
 error: function(xml, status, error){
 alert("Erreur de type : " + error);
 }*/


//if(!result)
//location.reload(true);
/*for (var i in result) {
 $("#onglet" + i).html(result[i]);
 }*/


/*.done(function (script, status) {
 
 }).fail(function (xhr, settings, exception) {
 alert(xhr + ' ' + exception + ' ' + settings);
 console.log(xhr + ' ' + exception + ' ' + settings);
 });
 
 <script type="text/javascript" src="<?php echo SITE_ROOT; ?>public/js/jquery-ui.js"></script>
 <script type="text/javascript" src="<?php echo SITE_ROOT; ?>public/js/jquery.dataTables.min.js"></script>
 <script type="text/javascript" src="<?php echo SITE_ROOT; ?>public/js/codebase/webix.js"></script>
 
 *
 *$('#example').dataTable( {
 "columns": [
 { "width": "20%" },
 null,
 null,
 null,
 null
 ]
 } );
 ou
 $('#example').dataTable( {
 "columnDefs": [
 { "width": "20%", "targets": 0 }
 ]
 } );
 
 "bSort": false,
 
 
 $('.table').dataTable({
 'bAutoWidth': false , 
 'aoColumns' : [
 { 'sWidth': '15%' },
 { 'sWidth': '15%' },
 { 'sWidth': '15%' },
 { 'sWidth': '15%' },
 { 'sWidth': '15%' },
 { 'sWidth': '15%' },
 { 'sWidth': '10%' }
 ]
 });
 
 $$("my_input").attachEvent("onChange", function(newv, oldv){
 webix.message("Value changed from: "+oldv+" to: "+newv);
 })
 
 
 function tooltip_on(e, ligne, dec) {
 dec = dec || false;
 var posx = 0;
 var posy = 0;
 if (!e)
 var e = window.event;
 if (dec) {
 var top = 5;
 } else {
 var top = 110;
 }
 if (e.pageX || e.pageY) {
 posx = e.pageX - 210;
 posy = e.pageY - top;
 } else if (e.clientX || e.clientY) {
 posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft - 210;
 posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop - top;
 }
 document.getElementById('tooltip' + ligne).style.left = posx + 'px';
 document.getElementById('tooltip' + ligne).style.top = posy + 'px';
 document.getElementById('tooltip' + ligne).style.display = 'block';
 }
 
 function tooltip_off(ligne) {
 window.off = setTimeout(function () {
 document.getElementById('tooltip' + ligne).style.display = 'none';
 }, 200);
 }
 
 function tooltip_stop(ligne) {
 clearTimeout(window.off);
 }
 
 **/
/**
 <div style="max-height: 150px; overflow: auto; left: 829px; top: 112px; display: none;" onmouseout="tooltip_off(0);" onmouseover="tooltip_stop(0);" class="edt_tooltip" id="tooltip0">
 <p>
 <b>Mathematiques - 2TCI-SEN (Groupe TCI)<br>
 proportionnalité</b>
 </p>
 <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note sur :</span>
 <span style="width:45px; display:inline-block;"><b>20</b></span>
 <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note mini :</span>
 <span style="width:35px; display:inline-block;">4.0</span>
 <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note maxi :</span>
 <span style="width:35px; display:inline-block;">16.0</span>
 <br><span style="width:100px; display:inline-block; font-weight:normal; text-decoration:underline;">Note moyenne :</span>
 <span style="width:35px; display:inline-block;">11.2</span>
 </div>
 */
/**
 * Visible and invisible columns
 * $(document).ready(function() {
 $('#example').dataTable( {
 "columnDefs": [ 
 {
 "targets": [ 2 ],
 "visible": false,
 "searchable": false
 },
 {
 "targets": [ 3 ],
 "visible": false
 }
 ]
 } );
 } );
 $("#comboPeriodes")[0].selectedIndex = 0;
 
 //Selecteur des heure
 $('#heuredebut, #heurefin').datetimepicker({
 datepicker: false,
 format: 'H:i',
 step: 30
 });
 */
/*
var y = 0;
var pas = 2;
var bas = true;
var tmp = pas;
function progressif(elem, h) {
    obj = document.getElementById(elem);
    if (y > h && bas) {
        pas = -pas;
        bas = false;
        clearInterval(t);
        return false;
    }
    if (y < tmp && !bas) {
        pas = -pas;
        bas = true;
        y = 0;
        clearInterval(t);
        return false;
    }
    y += pas;
    obj.style.height = y + 'px';
}
function deroulement(elem, h) {
    t = setInterval(function () {
        progressif(elem, h);
    });
}
*/