var played = false;
var player;

var setSource = function(item){
    if (!item) return;
    var source = item.src;
    played = false;
    player.currentTime = 0;
    stop();
    loadedAudio = item;
    player.src = source;
    $('#playpause_main').attr('data-duration', item.duration);
    $('#playpause_main').attr('data-src', item.src);
    $('#playpause_main').attr('data-id', item.id);

    $('.player>.wrap>.name>marquee').html(item.date+' '+item.title );
}


var play = function(){
    player.play();
    played = true;
    $('.pause.playpause>img').attr('src', '/img/pause.png');
};

var pause = function(){
    played = false;
    player.pause();
    $('.pause.playpause>img').attr('src', '/img/play.png');
};

var stop = function(){
    played = false;
    player.currentTime = 0;
    player.pause();
    $('.pause.playpause>img').attr('src', '/img/play.png');
};

var loadedAudio = null;
function with_zero(value){
    return value>9?value:'0'+value;
}

$(function() {

    player = new Audio();
    player.onended = function() {
        stop();
    };

    player.addEventListener("timeupdate", function() {
        var duration = $('.news-player>.time');
        var s = parseInt(player.currentTime % 60);
        var m = parseInt((player.currentTime / 60) % 60);
        var s_full = parseInt(player.duration % 60);
        var m_full = parseInt((player.duration / 60) % 60);
        duration.html(m + ':' + with_zero(s) +'/'+ m_full + ':' + with_zero(s_full));
        var perc = player.currentTime / (player.duration/100);
        $('.news-player>.scale>.played').css('width', perc+"%");
    }, false);


    $('.news-player>.scale').click(function(e){
        if (!media){
            return false;
        };
        pause();
        var x = e.pageX - this.offsetLeft;
        player.currentTime = x/(e.currentTarget.clientWidth/100) * (player.duration/100);
        play();
        return false;
    })

    $('.playpause').click(function(){
        if (played){
            pause();
            return false;
        }
        play();
        return false;
    });

    setSource(media);
});