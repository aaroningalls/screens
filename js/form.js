function isValid(field){
    if (field.is(":invalid")){
        field.css({
            "border-bottom": "2px solid red"
        })
        if(field.val() == ""){
            field.attr("placeholder", "This field is required");
        }
        return false
    } else {
        field.css("border-bottom", lightBlue)
        return true
    }
}
var lightBlue = "#00a9e0"
$('document').ready(function(){
    $('#submit').click(function(evt){
        var valid = true
       valid = isValid($("#first"))
       valid = isValid($("#last"))
       valid = isValid($("#email"))
       valid = isValid($("#title"))
       valid = isValid($("#channel"))
       valid = isValid($("#url"))
        if($("#time").is(":checked")){
            if($("#startSeconds").is(":invalid")){
                valid = isValid($("#startSeconds"))
            } if ($("#endSeconds").is(":invalid")){
                valid = isValid($("#endSeconds"))
            }
        }
        if($("#list").val() == 0){
            $(".select-selected").css("background-color", "red")
            $('.select').next().text("This field is required")
            valid = false
        } else if ($('.select').next().text() != "") {
            $(".select-selected").css("background-color", lightBlue)
            $('.select').next().text("")
        }
        if(valid == false){
            evt.preventDefault()
        }
    })
})