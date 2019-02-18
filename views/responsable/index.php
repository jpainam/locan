<div id="entete"></div>
<script>
$(document).ready(function(){
   $("#responsableTable").DataTable({
       "columns": [
           {"width": "5%"},
           null,
           {"width": "10%"},
           {"width": "10%"},
           {"width": "10%"},
           {"width": "5%"}
       ]
   }) 
});
</script>
<div class="page">
    <?php echo $responsables; ?>
</div>
<div class="navigation">
    <?php if(isAuth(319)){
        echo btn_add("document.location='".Router::url("responsable", "saisie")."'");
    }else{
        echo btn_add_disabled();
    }
    ?>
</div>