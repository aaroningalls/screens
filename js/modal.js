$(document).ready(function(){
    $('#openModal').click(function(){
        $('.modal').css("display", "block")
    })
    $('.close').click(function(){
        $('.modal').css("display", "none")
    })
    $(window).click(function(event){
        if(event.target == $('.modal')){
            $('.modal').css("display", "none")
        }
    })
})