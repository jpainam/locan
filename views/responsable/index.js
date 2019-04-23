$(document).ready(function(){
    $('select[name=responsable]').select2();
    $('select[name=responsable]').change(function(){
        if($(this).val() === ""){
            return;
        }
        $.ajax({
            url: './responsable/ajaxindex',
            dataType: 'json',
            type: 'post',
            data: {
                idresponsable: $('select[name=responsable]').val()
            },
            success: function(result){
                $('.page').html(result[0]);
            },
            error: function(xhr){
                alert(xhr.responseText);
            }
        });
    });
});