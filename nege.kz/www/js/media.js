var playlist = {};
var tmpPlaylist = {};
var played = false;
var player;
var first_id = 0;
var last_id = 0;
var muted = false;
var setSource = function(item){
    if (!item) return;
    var source = item.src;
    played = false;
    player.currentTime = 0;
    stop();
    loadedAudio = item;
    player.src = source;
    $('#playpause_main').attr('data-date', item.date);
    $('#playpause_main').attr('data-title', item.title);
    $('#playpause_main').attr('data-duration', item.duration);
    $('#playpause_main').attr('data-src', item.src);
    $('#playpause_main').attr('data-id', item.id);

    $('.player>.wrap>.name>marquee').html(item.date+' '+item.title );
}

var mute = function(){
    muted = !muted;
    player.muted = muted;
    if (muted){
        $('.right-buttons>.sound>img').attr('src', '/img/mute.png');
    }
    else{
        $('.right-buttons>.sound>img').attr('src', '/img/sound.png');
    };
};

var play = function(){
    player.play();
    played = true;
    $('.main_play_pause').attr('src', '/img/play.png');
    $('#main_play_button').attr('src', '/img/pause.png');
    $('.playpause[data-id="'+loadedAudio.id+'"]>img').attr('src', '/img/pause.png');
};

var pause = function(){
    played = false;
    player.pause();
    $('.main_play_pause').attr('src', '/img/play.png');
    $('.playpause>img').attr('src', '/img/play.png');
};

var stop = function(){
    played = false;
    player.currentTime = 0;
    player.pause();
    $('.main_play_pause').attr('src', '/img/play.png');
    $('.playpause>img').attr('src', '/img/play.png');
};

var next = function(){
    $('.playpause').each(function(){
        $(this).parent().parent().removeClass("current");
    });
    stop();
    var next_source = _.find(playlist, function(i){
        return i.position ==  loadedAudio.position-0+1;
    });

    if (!next_source){
        return false;
    };
    $('.playpause[data-id="'+next_source.id+'"]').parent().parent().addClass("current")
    setSource(next_source);
    play();
};
var prev = function(){
    $('.playpause').each(function(){
        $(this).parent().parent().removeClass("current");
    });
    stop();
    var prev_source = _.find(playlist, function(i){
        return i.position == loadedAudio.position-1;
    });
    if (!prev_source){
        return false;
    };
    $('.playpause[data-id="'+prev_source.id+'"]').parent().parent().addClass("current")
    setSource(prev_source);
    play();
};
var loadedAudio = null;
function with_zero(value){
    return value>9?value:'0'+value;
}

$(function() {
    $('.play-list>.item>.button>.playpause').each(function(){
        if (!first_id){
            first_id = $(this).attr('data-id')
        };
        last_id = $(this).attr('data-id');
        playlist[$(this).attr('data-id')] =
        {
            id:$(this).attr('data-id'),
            src:$(this).attr('data-src'),
            title:$(this).attr('data-title'),
            duration:$(this).attr('data-duration')?$(this).attr('data-duration'):'100',
            date:$(this).attr('data-date'),
            position:$(this).attr('data-pos')
        };
    });

    player = new Audio();
    player.duration = parseInt($('#playpause_main').attr('data-duration'));
    console.log(player.duration);
    player.onended = function() {
        next();
    };

    player.addEventListener("timeupdate", function() {
        var duration = $('.player>.wrap>.time');
        var s = parseInt(player.currentTime % 60);
        var m = parseInt((player.currentTime / 60) % 60);
        var s_full = parseInt(player.duration % 60);
        var m_full = parseInt((player.duration / 60) % 60);

        if ( isNaN(m_full) || isNaN(with_zero(s_full)) ) {
            duration.html(m + ':' + with_zero(s) +'/0:00');
        }
        else {
            duration.html(m + ':' + with_zero(s) +'/'+ m_full + ':' + with_zero(s_full));
        }

        var perc = player.currentTime / (player.duration/100);
        $('.player>.wrap>.scale>.played').css('width', perc+"%");
    }, false);
    $('.main-news-right-items .last-news').customScroll();


    $('.player>.wrap>.scale').click(function(e){
        if (!loadedAudio){
            return false;
        };
        pause();
        var x = e.pageX - this.offsetLeft;
        player.currentTime = x/(e.currentTarget.clientWidth/100) * (player.duration/100);
        play();
    })

    $('.play-list>.item>.song-name').click(function(){
        $(this).parent().find('.button').find('.playpause').click();
    })

    $('.playpause').click(function(){
        $('.playpause').each(function(){
            $(this).parent().parent().removeClass("current");
        });
        var audio_index = $(this).attr('data-id')?$(this).attr('data-id'):first_id;
        $('.playpause[data-id="'+audio_index+'"]').parent().parent().addClass("current")
        if (played && loadedAudio && audio_index == loadedAudio.id){
            pause();
            return;
        }
        else if(!played && loadedAudio && audio_index == loadedAudio.id){
            play();
            return;
        }
        setSource(playlist[audio_index]);
        play();
    });
    $('.prev').click(function(){
        prev();
    });
    $('.next').click(function(){
        next();
    });
    $('.right-buttons>.sound').click(function(){
        mute();
    });

    setSource(playlist[first_id]);
    tmpPlaylist = playlist;
});