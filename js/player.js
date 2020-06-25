"use strict"
var width
var videos = []
var player;
var cur;
var interval;
var videoIndex;
var tag = document.createElement('script');
var reset = false;
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);   

function getVideo(index){
    if(videos[index].endSeconds != -1){
        player.loadVideoById({
            'videoId': videos[index].ytVideoID,
            'startSeconds': videos[index].startSeconds,
            'endSeconds': videos[index].endSeconds
        })
    } else {
        player.loadVideoById({
            'videoId': videos[index].ytVideoID,
            'startSeconds': videos[index].startSeconds,
        })
    }  
}

function videoArray(){
    videos = []
    $.post('refresh.php', {listId: id}, function(data) {
        videos = JSON.parse(data)
    })
}

function changeOverlay(cur){
    $('#overTitle').text(videos[cur].videoTitle)
    $('#overChannel').text(videos[cur].videoChannel)
    width = $('#overlay').width() + 40
    $('#overlay').css("left", -width)
}

function animateOverlay(){
    $('#overlay').animate({"left": 0});
    window.setTimeout(function() {
        $('#overlay').animate({left: -width});
    }, 10000)      
}
function onYouTubeIframeAPIReady(){
    videoArray()
    player = new YT.Player('player', {events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange,
        'onError': onPlayerError
    }})
    
    reset = false
    //setInterval(videoArray(), 3600000)
    
}
function onPlayerError(event){
    console.log(event.data)
    $.post('error.php', {code: event.data, id: videos[cur].ytVideoID}, function(){
        cur = (cur + 1) % videos.length
        window.clearInterval(interval)
        getVideo(cur)
        changeOverlay(cur);
        animateOverlay()
        interval = setInterval(animateOverlay, 90000)
    })
}
/*
function onPlayerStateChange(event){
    if (event.data == 0){
        videoIndex = player.getPlaylistIndex();
        window.clearInterval(interval)
        cur = player.getPlaylistIndex()
        changeOverlay(cur);
        animateOverlay()
        interval = window.setInterval(animateOverlay, 90000)
        if (videoIndex == videoIds.length - 1){
            videoArray();
        } else if (videoIndex == 0 /*&& reset){
            player.loadPlaylist(videoIds)
            player.setLoop(true)
            cur = 0
            changeOverlay(cur)
            animateOverlay()
            reset = false
        }
    }
}
*/
function onPlayerStateChange(event){
    if(event.data == 0){
        cur = (cur + 1) % videos.length
        window.clearInterval(interval)
        getVideo(cur)
        changeOverlay(cur);
        animateOverlay()
        interval = setInterval(animateOverlay, 90000)
    }
}

function onPlayerReady(){
    getVideo(0);
    cur = 0
    changeOverlay(cur)
    animateOverlay();
    interval = window.setInterval(animateOverlay, 90000)
}
