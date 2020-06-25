var rows = [], asc = true, rec, num = false
function flip(chance){
    chance = chance || 50 
    if(Math.random() * 101 <= chance){
        return true
    } else {
        return false
    }
}
function shuffle(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;
  
    while (0 !== currentIndex) {
  
      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex -= 1;
  
      temporaryValue = array[currentIndex];
      array[currentIndex] = array[randomIndex];
      array[randomIndex] = temporaryValue;
    }
  
    return array;
  }
function randItem(array){
    return array[Math.floor(Math.random() * array.length)]
}
function arrSort(array){
    return array.sort(function(a,b){return a-b})
}
function max(array){
    return arrSort(array)[array.length - 1]
}
function upper(string){
    return (string[0].toUpperCase() + string.slice(1)).toString()
}
function attributes(preset, race, npcClass){
    var scores = [], abilities = {}, pref = {}, skills = []
    if(preset == "normal"){
        for(var i = 0; i < 6; i++){
            var dice = [0, 0, 0, 0]
            for(var j = 0; j < 4; j++){
                dice[j] = Math.floor((Math.random() * 6) + 1)
            }
            dice = arrSort(dice)
            scores[i] = dice[1] + dice[2] + dice[3]
        }
        scores = arrSort(scores)
    } else {
        scores = presetAbilities(preset)
    }
    var level = parseInt($("#level").val()) 
    var improvement
    var temp = levelSwitch(npcClass)
    improvement = temp.improvement
    pref = temp.pref
    var list = ['str', 'dex', 'int', 'cha', 'con', 'wis']
    
    for(var i = 0 ; i < 6; i++){
        if(pref.indexOf(list[i]) == -1){
            skills[skills.length] = list[i]
        }
    }
    skills = shuffle(skills)
    for(var i = 0; i < skills.length; i++){
        pref[pref.length] = skills[i]
    }
    for(var i = 0; i < 6; i++){
        abilities[pref[i]] = scores[5 - i]
    }
    var i = 0
    switch(race){
        case "azNar":
        case "dwarf":
            for(i = 0; i < 2; i++){
                if(abilities['con'] < 20){
                    abilities['con']++
                }
            }
            break
        case "elf":
            for(i = 0; i < 2; i++){
                if(abilities['dex'] < 20){
                    abilities['dex'] += 2
                }
            }
            break
        case "goblin":
        case "halfling":
            for(i = 0; i < 2; i++){
                if(abilities['dex'] < 20){
                    abilities['dex'] += 2
                }
            }
            break
        case "human":
            for(var score in abilities){
                if(score <= 19){
                    score++
                }
            }
            break
        case "orc":
            
        case "tiefling":
            for(i = 0; i < 2; i++){
                if(abilities['cha'] < 20){
                    abilities['cha'] ++
                }
            }
            if(abilities['int'] <= 19){
                abilities['int']++
            }
            break
        default:
            break
    }
    i = 0
    while(improvement != 0){
        if(abilities[pref[i]] != 20){
            abilities[pref[i]]++
            improvement--
        } else if (abilities[pref[i]] == 20){
            i++
            if(i == 6){
                break
            }
        }
    } 
    $("#str").val(abilities['str'])
    $("#int").val(abilities['int'])
    $("#dex").val(abilities['dex'])
    $("#wis").val(abilities['wis'])
    $("#con").val(abilities['con'])
    $("#cha").val(abilities['cha'])
}
function ages(race){
    var height, weight, num = 0, mul = 0, i, j, wd, hd, age, max
    var temp = dimmensionSwitch(race)
    height = temp.height
    weight = temp.weight
    i = temp.i
    j = temp.j
    hd = temp.hd
    wd = temp.wd
    max = temp.max
    var k
    for(k = 0; k < i; k++){
        num += (Math.random() * hd) + 1
    }
    height += num
    for(k = 0; k < j; k++){
        mul += (Math.random() * wd) + 1
    }
    weight += (num * mul)
    max++
    age = Math.random() * max
    var feet = Math.floor(height / 12)
    var inches = height % 12
    $("#height").val(feet + "\'" + Math.floor(inches) +"\"")
    $("#weight").val(Math.floor(weight) + " lbs.")
    $("#age").val(Math.floor(age))
}
function generate(){
    var preset = $("#preset").val()
    var race = $("#race").val()
    var npcClass = $("#class").val() 
    var gender = $("#gender").val()
    if(preset != "normal"){
        var x = preset
        var temp = presetChar(preset)
        race = temp["race"]
        npcClass = temp["class"]
        gender = temp['gender']
    }
    if(race == "random"){
        var races = ["azNar", "dwarf", "elf", "goblin", "halfling", "human", "orc", "tiefling"]
        race = randItem(races)
    }
    if(npcClass == "random"){
        var classes = ["barbarian", "bard", "cleric", "druid", "fighter", "monk", "paladin", "ranger", "rogue", "sorcerer", "warlock", "wizard"]
        npcClass = randItem(classes)
    }

    var temp = Math.random() * 100
    if(parseInt(gender) < temp){
        gender = "male"
    } else {
        gender = "female"
    } 
    if($("#attributes").is(":checked")){
        attributes(preset, race, npcClass)
    }
    ages(race, gender)
    var list = race + "-" + gender
    var first = generate_name(list)
    list = race + "-last"
    var last = generate_name(list)
    if(race == "halfling" || race == "dwarf"){
        last = randItem(name_set[list])
    }
    if($("#first").val() + " " + $("#last").val() == $("#shopOwner").val()){
        var temp = $("#shopName").val()
        temp = temp.slice($("#first").val().length)
        $("#shopName").val(first + temp)
        $("#shopOwner").val(first + " " + last)
    } 
    $("#first").val(first)
    $("#last").val(last)
    $("#result-race").val(race)
    $("#result-class").val(npcClass)
    $("#result-" + gender).prop("checked", true)
}
function toggleLevel(){
    if($("#attributes").is(":checked")){
        $("#level").prop("disabled", false)
    } else {
        $("#level").prop("disabled", true)
    }
}
function genderText(){
    $("#female-percent").text($("#gender").val() + "%")
    $("#male-percent").text(100 - $("#gender").val() + "%")
}
function partition(left, right, pivot, sort){
    var leftPoint = left
    var rightPoint = right - 1
    var temp, leftItem, rightItem
    while(true){
        rightItem = rows[rightPoint][sort].toLowerCase() 
        leftItem = rows[leftPoint][sort].toLowerCase()
        if(num){
            pivot = parseInt(pivot)
        }
        if(asc){
            while(rightItem >= pivot && rightPoint > 0){
                rightPoint--
                rightItem = rows[rightPoint][sort].toLowerCase() 
            }
            while(leftItem < pivot && leftPoint < rows.length){
                leftPoint++
                leftItem = rows[leftPoint][sort].toLowerCase() 
            }
        } else {  
            while(rightItem <= pivot && rightPoint > 0){
                rightPoint--
                rightItem = rows[rightPoint][sort].toLowerCase() 
            }
            while(leftItem > pivot){
                leftPoint++
                leftItem = rows[leftPoint][sort].toLowerCase() 
            }
        }
        if (leftPoint >= rightPoint){
            break
        } else {
            temp = rows[rightPoint]
            rows[rightPoint] = rows[leftPoint]
            rows[leftPoint] = temp
        }
    }
    temp = rows[right]
    rows[right] = rows[leftPoint]
    rows[leftPoint] = temp
    return leftPoint
}
function sort(left, right, index){
    if(right - left <= 0){
        return
    } else {
        pivot = rows[right][index].toLowerCase()
        part = partition(left, right, pivot, index)
        sort(left, part - 1, index)
        sort(part + 1, right, index)
    }
}
function sortTable(n) {
    var index, temp = []
    if(n == 0){
        index = "category"
    } else if (n == 2){
        index = "cost"
        num = true
    } else if (n == 3){
        index = "stock"
        num = true
    } else {
        index = "name"
    }
    if(!asc && rec != n){
        asc = true
    }
    sort(0, rows.length - 1,index)
    num = false
    if(asc){
        asc = false
    } else {
        asc = true
    }
    rec = n
    while($("#shop-table > tbody > tr").length > 2){
        $("#shop-table tr:last").remove()
    }
    for(key in rows){
        var item = rows[key], temp
        if(parseInt(item.cost) % 100 == 0 && parseInt(item.cost) / 100 != 0){
            temp = item.cost / 100
            temp = temp.toString() + " gp"
        } else if (parseInt(item.cost) % 10 == 0 && parseInt(item.cost) / 10 != 0){
            temp = item.cost / 10
            temp = temp.toString() + " sp"
        } else {
            temp = item.cost + " cp"
        }
        var row = "<tr><td>"
        row += item.category + "</td><td>"
        row += item.name + "</td><td>"
        row += temp + "</td><td>"
        row += item.stock + "</td></tr>"
        $("#shop-table tbody").append(row)
    }
  }
function copyText(text){
    var temp = $("#wiki-text").val()
    $("#wiki-text").val(text)
    $("#wiki-text").select()
    document.execCommand("copy")
    window.getSelection().removeAllRanges()
    $("#wiki-text").val(temp + "\n----------------------\n----------------------\n----------------------\n" + text)
}
$(document).ready(function(){
    $("#gen-submit").click(function(){
        generate()
    })
    $("#gender").on('input', function(){
        genderText()
    })
    $("#attributes").on("change", function(){
        toggleLevel()
    })
    $("#preset").change(function(){
        presetChar($(this).val())
    })
    $("#shop").change(function(){
        if($(this).val() == "adv" || $(this).val() == "gen"){
            $("#theme").prop("disabled", false)
        } else {
            $("#theme").val("none")
            $("#theme").prop("disabled", true)
        }
    })
    $("#table-search").on("input", function(){
        var input, filter, table, tr, td, i, txtValue;
        input = $("#table-search")
        filter = input.val().toUpperCase();
        table = $("#shop-table");
        tr = table.find("tr");
      
        for (i = 1; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[1];
          if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          } 
        }
      })
    $("#shop-submit").click(function(){
        var type = $("#shop").val()
        var theme = $("#theme").val()
        var premium = $("#premium").is(":checked")
        var city = $("#shopCity").val()
        var num = parseInt($("#shopNum").val())
        var shop = shopId(type)
        if(city == ""){
            $("#shopCity")[0].setCustomValidity("City is required")
        } else {
            city = upper(city)
        }
        if(isNaN(num)){
            $("#shopNum")[0].setCustomValidity("Not a valid number")
            return
        }
        presetChar("shop-gen")
        
        var name, code = city + " " + type.toUpperCase() + "-" + num, owner
        while($("#shop-table > tbody > tr").length > 2){
            $("#shop-table tr:last").remove()
        }
        
        $.getJSON("shop-items.json", function(file){
            $.getJSON("cities.json", function(cities){
                $.getJSON("shops.json", function(shops){
                    var items = [], max = [], cost = [], unit = []
                    var shopObj = {items: []}
                    var exists = false
                    var shopNum, cityObj
                    for(place in shops[shop]){
                        if(shops[shop][place].code == code){
                            exists = true
                            shopNum = place
                            break
                        }
                    }
                    cityObj = cities[city]
                    if(cityObj == null){
                        $("#shopCity")[0].setCustomValidity("City not found")
                        return
                    }
                    if(exists){
                        console.log("exists")
                        for(key in shops[shop][shopNum].items){
                            items.push(file[shop][shops[shop][shopNum].items[key].index])
                            cost.push(shops[shop][shopNum].items[key].cost)
                            unit.push(shops[shop][shopNum].items[key].unit)
                            max.push(shops[shop][shopNum].items[key].max)
                        }
                        name = shops[shop][shopNum].name
                        owner = shops[shop][shopNum].owner
                    } else {
                        generate()
                        name = $("#first").val() + "'s shop"
                        owner = $("#first").val() + " " + $("#last").val()
                        var temp = [], remove =[]
                        temp = file[shop]
                        if(theme != "none"){
                            for(item in file[theme]){
                                temp.push(file[theme][item])
                            }
                        }
                        for(key in temp){
                            var item = temp[key]
                            if(premium && item.premium){
                                items.push(item)
                            } else if(cityObj.urban && item.urban){
                                items.push(item)
                            } else if(cityObj.rural && item.rural){
                                items.push(item)
                            }
                        }
                        for(key in items){
                            var x, temp
                            
                            if(items[key].urba){
                                x = 15
                            } else {
                                x = 5
                            }
                           temp = Math.floor(Math.random() * x)
                            if(temp == 0){
                                remove.push(key)
                            } else {
                                temp += items[key].limited 
                                max.push(temp)
                            }
                            cost[cost.length] = 0, unit[unit.length] = items[key].unit
                            cost[cost.length - 1] = items[key][cityObj.economies[items[key].category]]
                            if(flip()){
                                cost[cost.length - 1] -= Math.floor((Math.random() * (cityObj.mod / 100)) * cost[cost.length - 1])
                            } else {
                                cost[cost.length - 1] += Math.floor((Math.random() * (cityObj.mod / 100)) * cost[cost.length - 1])
                            }
                            if(cost[cost.length - 1] <= 0){
                                if(unit[unit.length - 1] == "cp"){
                                    cost[cost.length - 1] = 1
                                } else if (unit[unit.length - 1] == "sp"){
                                    cost[cost.length - 1] += 10
                                    unit[unit.length - 1] = "cp"
                                } else if (unit[unit.length - 1] == "gp"){
                                    cost[cost.length - 1] += 10
                                    unit[unit.length - 1] = "sp"
                                }
                            }
                        }
                        for(key in remove){
                            items.splice(remove[key], 1)
                            unit.splice(remove[key], 1)
                            cost.splice(remove[key], 1)
                        }
                    }
                    rows.splice(0, rows.length)
                    for(key in items){
                        var itemObj = {index: [], max: [], cost: [], unit: []}
                        var item = items[key], row = "<tr><td>", stock
                        do {
                            stock = Math.floor(Math.random() * 51)
                        }while(stock > max[key])
                        itemObj.index = file[shop].indexOf(item)
                        itemObj.max = max[key]
                        itemObj.cost = cost[key]
                        itemObj.unit = unit[key]
                        shopObj.items.push(itemObj)
                        row += item.category + "</td><td>"
                        row += item.name + "</td><td>"
                        row += cost[key] + " " + unit[key] + "</td><td>"
                        row += stock + "</td></tr>"
                        $("#shop-table tbody").append(row)
                        var temp
                        if(unit[key] == "sp"){
                            temp = cost[key] * 10
                        } else if (unit[key] == "gp"){
                            temp = cost[key] * 100
                        } else {
                            temp = cost[key]
                        }
                        rowObj = {name: item.name, category: item.category, cost: temp.toString(), stock: stock.toString(), max: max[key]}
                        rows.push(rowObj)
                    }
                    shopObj.name = name
                    shopObj.code = code
                    shopObj.owner = owner
                    shops[shop].push(shopObj)
                    var jsonTxt = JSON.stringify(shops)
                    if(!exists){
                        $.post("saveshop.php", {file: jsonTxt})
                        console.log("posted")
                    }
                    $("#shop-table").css("display", "block")
                    $("#shopName").val(name)
                    $("#shopOwner").val(owner)
                    $("#shopId").val(code)
                })
            })
        })
    })
    $("#search").submit(function(event){
        var code = $("#search-city").val()
        var type = shopId((code.substring(code.indexOf(" ") + 1, code.indexOf("-"))).toLowerCase())
        
        $.getJSON("shop-items.json", function(file){
            $.getJSON("shops.json", function(shops){
                var exists = false, shopNum
                for(key in shops[type]){
                    if(shops[type][key].code.toLowerCase() == code.toLowerCase()){
                        exists = true
                        shopNum = key
                        break
                    }
                }
                if(!exists){
                    $("#search-city")[0].setCustomValidity("Shop not found")
                    return
                }
                var shop = shops[type][shopNum], items = []

                for(key in shops[type][shopNum].items){
                    items.push(file[type][shops[type][shopNum].items[key].index])
                }
                rows.splice(0, rows.length)
                while($("#shop-table > tbody > tr").length > 2){
                    $("#shop-table tr:last").remove()
                }
                for(key in items){
                    var item = items[key], row = "<tr><td>", stock
                    do {
                        stock = Math.floor(Math.random() * 51)
                    }while(stock > shop.items[key].max)
                    row += item.category + "</td><td>"
                    row += item.name + "</td><td>"
                    row += shop.items[key].cost + " " + shop.items[key].unit + "</td><td>"
                    row += stock + "</td></tr>"
                    $("#shop-table tbody").append(row)
                    var temp
                    if(shop.items[key].unit == "sp"){
                        temp = shop.items[key].cost * 10
                    } else if (shop.items[key].unit == "gp"){
                        temp = shop.items[key].cost * 100
                    } else {
                        temp = shop.items[key].cost
                    }
                    rowObj = {name: item.name, category: item.category, cost: temp.toString(), stock: stock.toString(), max: shop.items[key].max}
                    rows.push(rowObj)
                }
                $("#shop-table").css("display", "block")
                $("#shopName").val(shop.name)
                $("#shopOwner").val(shop.owner)
                $("#shopId").val(shop.code) 
            })
        })
        
        event.preventDefault()
    })
    $("#result-submit").click(function(){
        var text = "[[Category:People]]\n"
        text += $("#first").val() + " " + $("#last").val() + " is a " + $("input[name=result-gender]:checked").val() + " " + $("#result-race").val()
        if ($("#result-class").val() == "none"){
            text += " with no class. "
        } else if ($("#result-class").val() == "azNar"){
            text += " az-Nar Zag-Him. "
        } else {
            text += " " + $("#result-class").val() + ". "
        }
        if($("#location").val() == ""){
            $("#location").val("unknown")
        }
        text += $("#first").val() + " reigns from " + upper($("#location").val()) + " and is " + $("#age").val() + " years of age, " + $("#height").val() + ", and " + $("#weight").val()
        text += "\n" + "==Statistics==\n" + "{|class=\"wikitable\"\n|--\n"
        text += "|Hometown: || " + upper($("#location").val()) + "\n|--\n"
        text += "|Race: || " + upper($("#result-race").val()) + "\n|--\n"
        text += "|Class: || " + upper($("#result-class").val()) + "\n|--\n"
        text += "|Gender: || " + upper($("input[name=result-gender").val()) + "\n|--\n"
        text += "|Age: || " + $("#age").val() + "\n|--\n"
        text += "|Height: || " + $("#height").val() + "\n|--\n"
        text += "|Weight: || " + $("#weight").val() + "\n|--\n"
        text += "|Strength: || " + $("#str").val() + "\n|--\n"
        text += "|Dexterity: || " + $("#dex").val() + "\n|--\n"
        text += "|Constitution: ||" + $("#con").val() + "\n|--\n"
        text += "|Intelligence: || " + $("#int").val() + "\n|--\n"
        text += "|Wisdom: || " + $("#wis").val() + "\n|--\n"
        text += "|Charisma: || " + $("#cha").val() + "\n|}\n"
        text += "==Notes==\n"
        copyText(text)

        var name = $("#first").val() + "_" + $("#last").val()
        name = name.replace(/\ /g, "_")
        name = encodeURI(name)
        var link = "http://azlan.epizy.com/index.php?title="+ name +"&action=edit&redlink=1"
        $("#wiki-edit").attr("href", link)
    })
    $("#saveShop").click(function(){
        if(rows.length == 0){
            return
        }
        asc = true
        num = false
        sort(0, rows.length - 1, "name")
        var name = $("#shopName").val()
        var owner = $("#shopOwner").val()
        var code = $("#shopId").val()
        var type = code.substring(code.indexOf(" ") + 1, code.indexOf("-")).toLowerCase()
        var def = defSwitch(type)
        var text = "[[Category:Shops]]\n" + name + " " + def + " This shop is owned and operated by [[" + owner + "]] in the city of [[" + code.substring(0, code.indexOf(" ")) + "]].\n==Products==\n"
        text += "{|class=\"wikitable\"\n|--\n! Category !! Item !! Cost !! Max Stock\n"
        for(key in rows){
            var row = rows[key]
            var temp = "|--\n|"
            if(parseInt(row.cost) % 100 == 0 && parseInt(row.cost) / 100 != 0){
                cost = row.cost / 100
                cost = cost.toString() + " gp"
            } else if (parseInt(row.cost) % 10 == 0 && parseInt(row.cost) / 10 != 0){
                cost = row.cost / 10
                cost = cost.toString() + " sp"
            } else {
                cost = row.cost + " cp"
            }
            temp += row.category + " || " + row.name + " || " + cost + " || " + row.max + "\n"
            text += temp
        }
        text += "|}\n==Notes==\n"
        copyText(text)
        var title = name + " (" + code + ")"
        title = encodeURI(title)
        var link = "http://azlan.epizy.com/index.php?title="+ title +"&action=edit&redlink=1" 
        $("#wiki-edit").attr("href", link)

        $.getJSON("shops.json", function(file){
            shops = file[shopId(type)]
            var shop
            for(key in shops){
                if(shops[key].code == code){
                    shop = shops[key]
                    break
                }
            }
            change = false
            if(shop.name != name){
                name.replace(/[^a-zA-Z'"0-9-,: ]/g, "")
                shop.name = name
                change = true
            }
            if(shop.owner != owner){
                owner.replace(/[^a-zA-Z'"0-9-,: ]/g, "")
                shop.owner = owner
                change = true
            }
            if(change){
                shops[shops.indexOf(shop)] = shop
                file[shopId(type)] = shops
                json = JSON.stringify(file)
                $.post("/saveshop.php", {file: json})
            }
        })
    })
})