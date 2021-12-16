( function($) {
    function getPanel($element){
        return $element.closest('.podcasts-block');
    }

    function setCurrent($episode){
        const $panel = getPanel($episode);
        const $playingEpisode = getPlayingEpisode($panel);
        const episodeData = getEpisodeData($episode);
        $playingEpisode.data('episode', episodeData);
        $playingEpisode.find('.video-wrapper img').attr('src', episodeData.image);
        $playingEpisode.find('.title .episode-number').text(episodeData.title);
        $playingEpisode.find('.podcast-player audio').attr('src', episodeData.audio);
        $playingEpisode.find('.podcast-player audio')[0].setCurrentTime(0);
        $playingEpisode.find('.podcast-player audio')[0].play();
        // $playingEpisode.find('.podcast-player audio').setSrc(episodeData.audio);
        $panel.find('.podcast-playlist .podcast-preview.current').removeClass('current');
        $episode.addClass('current');
    }

    function getEpisodeData($episode){
        return $episode.data('episode');
    }

    function getPlayingEpisode($panel){
        return $panel.find('.first-podcast');
    }

    function isCurrentEpisode($episode){
        const $panel = getPanel($episode);
        const $playingEpisode = getPlayingEpisode($panel);
        const playingEpisodeData = getEpisodeData($playingEpisode);
        const episodeData = getEpisodeData($episode);
        return episodeData.guid == playingEpisodeData.guid;
    }

    $(document).on('click', '.podcast-playlist .podcast-preview', function(){
        if( isCurrentEpisode($(this)) )
            return;

        setCurrent($(this));
    })

    $(document).ready( function(){
        $('.podcasts-block audio').mediaelementplayer({
            features: ['playpause', 'progress', 'current', 'tracks', 'fullscreen']
        });
    } );


} )(jQuery)
