$(function(){

    $("#botonModalResultados").click(function(){
        $("#modal_SubMuestras").modal('show')
        .find("#modalContent")
        .load($(this).attr('value'));
    });
});