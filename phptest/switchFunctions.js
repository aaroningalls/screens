function defSwitch(type){
    var def
    switch(type){
        case "adv":
            def = "is one of the many shops responsible for selling adventuring gear to the many adventerers. Among it's shelves people can find weapons, traps, and other equipment useful when exploring the wild. Adventurer's should reload on anything they might deem necessary whenever they can."
        case "brw":
        case "wne":
        case "bsm":
        case "bks":
        case "bnd":
        case "flt":
        case "gen":
        case "inn":
        case "tnr":
        case "mgc":
        case "bch":
        case "bkr":
        case "fsh":
        case "mkt":
        case "tvn":
        case "ptn":
        case "tlr":
        case "tmp":
        case "dck":
        case "sdl":
        case "stb":
        case "wpn":
        default:
    }
    return def
}
function shopId(id){
    var shop
    switch(id){
        case "adv":
            shop = "adventuring"
            break
        case "brw":
            shop = "alcohol"
            break
        case "bsm":
            shop = "blacksmith"
            break
        case "bnd":
        case "bks":
            shop = "book"
            break
        case "flt":
            shop = "fletcher"
            break
        case "gen":
            shop = "general"
            break
        case "inn":
            shop = "inn"
            break
        case "tnr":
            shop = "tanner"
            break
        case "mgc":
            shop = "magic"
            break
        case "bch":
            shop = "butcher"
            break
        case "bkr":
            shop = "baker"
            break
        case "fsh":
            shop = "fish"
            break
        case "mkt":
            shop = "market"
            break
        case "tvn":
            shop = "meals"
            break
        case "ptn":
            shop = "potion"
            break
        case "tlr": 
            shop = "tailor"
            break
        case "tmp":
            shop = "temple"
            break
        case "dck":
            shop = "dock"
            break
        case "sdl":
            shop = "saddle"
            break
        case "stb":
            shop = "stable"
            break
        case "wpn":
            shop = "weapon"
            break
        default:
            shop = ""
    }
    return shop
}
function levelSwitch(npcClass){

    switch(npcClass){
        case "barbarian":
            pref = ['str', 'con']
            if(level < 4){
                improvement = 0
            } else if(level < 8){
                improvement = 2
            } else if(level < 12){
                improvement = 4
            } else if(level < 16){
                improvement = 6
            } else if(level < 19){
                improvement = 8
            } else {
                improvement = 10
            }
            break
        case "bard":
            pref = ['cha', 'dex']
            if(level < 4){
                improvement = 0
            } else if(level < 8){
                improvement = 2
            } else if(level < 12){
                improvement = 4
            } else if(level < 16){
                improvement = 6
            } else if(level < 19){
                improvement = 8
            } else {
                improvement = 10
            }
            break
        case "cleric":
            pref = ['cha', 'dex']
            if(level < 4){
                improvement = 0
            } else if(level < 8){
                improvement = 2
            } else if(level < 12){
                improvement = 4
            } else if(level < 16){
                improvement = 6
            } else if(level < 19){
                improvement = 8
            } else {
                improvement = 10
            }
            break
        case "druid":
            pref = ['wis', 'int']
            if(level < 4){
                improvement = 0
            } else if(level < 8){
                improvement = 2
            } else if(level < 12){
                improvement = 4
            } else if(level < 16){
                improvement = 6
            } else if(level < 19){
                improvement = 8
            } else {
                improvement = 10
            }
            break
        case "fighter":
            if(flip()){
                pref = ['str', 'dex', 'con']
            } else {
                pref = ['dex', 'str', 'con']
            }
            if(level < 4){
                improvement = 0
            } else if(level < 6){
                improvement = 2
            } else if(level < 8){
                improvement = 4
            } else if(level < 12){
                improvement = 6
            } else if(level < 14){
                improvement = 8
            } else if(level < 16){
                improvement = 10
            } else if(level < 19){
                improvement = 12
            } else {
                improvement = 14
            }
            break
        case "monk":
            if(flip()){
                pref = ['dex', 'wis', 'str']
            } else {
                pref = ['wis', 'dex', 'str']
            }
            if(level < 4){
                improvement = 0
            } else if(level < 8){
                improvement = 2
            } else if(level < 12){
                improvement = 4
            } else if(level < 16){
                improvement = 6
            } else if(level < 19){
                improvement = 8
            } else {
                improvement = 10
            }
            break
        case "paladin":
            if(flip()){
                pref = ['str', 'cha', 'wis']
            } else {
                pref = ['cha', 'str', 'wis']
            }
            if(level < 4){
                improvement = 0
            } else if(level < 8){
                improvement = 2
            } else if(level < 12){
                improvement = 4
            } else if(level < 16){
                improvement = 6
            } else if(level < 19){
                improvement = 8
            } else {
                improvement = 10
            }
            break
        case "ranger":
            if(flip()){
                pref = ['dex', 'wis', 'str']
            } else {
                pref = ['wis', 'dex', 'str']
            }
            if(level < 4){
                improvement = 0
            } else if(level < 8){
                improvement = 2
            } else if(level < 12){
                improvement = 4
            } else if(level < 16){
                improvement = 6
            } else if(level < 19){
                improvement = 8
            } else {
                improvement = 10
            }
            break
        case "rogue":
            pref = ['dex', 'int']
            if(level < 4){
                improvement = 0
            } else if(level < 8){
                improvement = 2
            } else if(level < 10){
                improvement = 4
            } else if(level < 12){
                improvement = 6
            } else if(level < 16){
                improvement = 8
            } else if(level < 19){
                improvement = 10
            } else {
                improvement = 12
            }
            break
        case "sorcerer":
            pref = ['cha', 'con']
            if(level < 4){
                improvement = 0
            } else if(level < 8){
                improvement = 2
            } else if(level < 12){
                improvement = 4
            } else if(level < 16){
                improvement = 6
            } else if(level < 19){
                improvement = 8
            } else {
                improvement = 10
            }
            break
        case "warlock":
            pref = ['cha', 'wis']
            if(level < 4){
                improvement = 0
            } else if(level < 8){
                improvement = 2
            } else if(level < 12){
                improvement = 4
            } else if(level < 16){
                improvement = 6
            } else if(level < 19){
                improvement = 8
            } else {
                improvement = 10
            }
            break
        case "wizard":
            pref = ['int', 'wis']
            if(level < 4){
                improvement = 0
            } else if(level < 8){
                improvement = 2
            } else if(level < 12){
                improvement = 4
            } else if(level < 16){
                improvement = 6
            } else if(level < 19){
                improvement = 8
            } else {
                improvement = 10
            }
            break
        default:
            pref = []
            improvement = 0
    }
    return {pref: pref, improvement: improvement}
}
function dimmensionSwitch(race){
    switch(race){
        case "human":
            height = 56
            weight = 110
            i = 2
            j = 2
            hd = 10
            wd = 4
            max = 90
            break
        case "elf":
            height = 54
            weight = 100
            i = 2
            j = 1
            hd = 10
            wd = 4
            max = 755
            break
        case "azNar":
            height = 50
            weight = 120
            i = 2
            j = 2
            hd = 6
            wd = 4
            max = 355
            break
        case "dwarf":
            height = 48
            weight = 130
            i = 2
            j = 2
            hd = 4
            wd = 6
            max = 355
            break
        case "halfling":
            height = 31
            weight = 35
            i = 2
            j = 1
            hd = 4
            wd = 0
            max = 250
            break
        case "tiefling":
            height = 57
            weight = 110
            i = 2
            j = 2
            hd = 8
            wd = 4
            max = 105
            break
        default:
            break
    }
    return {height: height, weight: weight, i: i, j: j, hd: hd, wd: wd, max, max}
}