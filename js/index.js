$(document).ready(function(){
    $('input:checkbox[name="time"]').change(function(){
        if($(this).is(':checked')){
            $("#timeInput").stop().slideDown(100)
        } else {
            $("#timeInput").stop().slideUp(100)
        }
    })
})