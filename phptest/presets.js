function presetChar(preset){
    var character = []
    switch(preset){
        case "shop-gen":
        case "shop":
            character["race"] = "human"
            character["class"] = "none"
            character["gender"] = "40"
    }
    if(preset == "shop-gen"){
        preset = "shop"
    }
    $("#preset").val(preset)
    $("#race").val(character["race"])
    $("#class").val(character["class"])
    $("#gender").val(character["gender"])
    $("#attributes").prop("checked", false)
    genderText()
    toggleLevel()
    return character
}
function presetAbilities(preset){

}



