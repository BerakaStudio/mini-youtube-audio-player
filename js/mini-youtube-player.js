(function($) {
    'use strict';
    
    // Object to store all instances of players
    window.miniYTPlayers = {};
    
    // Initialization when YouTube API is ready
    window.onYouTubeIframeAPIReady = function() {
        $('.mini-youtube-player').each(function() {
            initPlayer($(this));
        });
    };
    
    // Initializes an individual player
    function initPlayer($container) {
        const playerId = $container.attr('id');
        const videoId = $container.data('video-id');
        const color = $container.data('color');
        
        // Create a hidden container for YouTube iframe
        const iframeId = playerId + '-iframe';
        $('<div>', {
            id: iframeId,
            style: 'display:none;'
        }).appendTo($container);
        
        // Configure the player for this instance
        const $progressBar = $container.find('.progress');
        const $playBtn = $container.find('.play-btn');
        const $playIcon = $container.find('.player-icon');
        const $timeDisplay = $container.find('.time-display');
        const $progressContainer = $container.find('.progress-container');
        
        // Apply custom color
        $progressBar.css('background-color', color);
        
        // Create YouTube player
        const player = new YT.Player(iframeId, {
            height: '0',
            width: '0',
            videoId: videoId,
            events: {
                'onStateChange': function(event) {
                    onPlayerStateChange(event, playerId);
                },
                'onReady': function(event) {
                    // The player is ready
                    miniYTPlayers[playerId].player = event.target;
                }
            }
        });
        
        // Store the player instance and its elements
        miniYTPlayers[playerId] = {
            player: null,
            isPlaying: false,
            progressBar: $progressBar,
            playBtn: $playBtn,
            playIcon: $playIcon,
            timeDisplay: $timeDisplay,
            progressContainer: $progressContainer,
            animationFrame: null
        };
        
        // Operating the play/pause button
        $playBtn.on('click', function() {
            const playerData = miniYTPlayers[playerId];
            if (!playerData.player) return;
            
            if (playerData.isPlaying) {
                playerData.player.pauseVideo();
            } else {
                playerData.player.playVideo();
                
                // Pause other players if they are playing
                for (let id in miniYTPlayers) {
                    if (id !== playerId && miniYTPlayers[id].isPlaying) {
                        miniYTPlayers[id].player.pauseVideo();
                    }
                }
            }
        });
        
        // Manage clicks on the progress bar
        $progressContainer.on('click', function(e) {
            const playerData = miniYTPlayers[playerId];
            if (!playerData.player) return;
            
            const container = $(this);
            const clickPosition = e.pageX - container.offset().left;
            const containerWidth = container.width();
            const percentage = clickPosition / containerWidth;
            
            const duration = playerData.player.getDuration();
            playerData.player.seekTo(duration * percentage, true);
            
            // If it is not playing, start playback
            if (!playerData.isPlaying) {
                playerData.player.playVideo();
            }
        });
    }
    
    // Player status change handler
    function onPlayerStateChange(event, playerId) {
        const playerData = miniYTPlayers[playerId];
        
        if (event.data === YT.PlayerState.PLAYING) {
            playerData.isPlaying = true;
            switchIcon(playerId);
            updateProgress(playerId);
        } else {
            playerData.isPlaying = false;
            switchIcon(playerId);
            
            // Cancel the animation if it exists
            if (playerData.animationFrame) {
                cancelAnimationFrame(playerData.animationFrame);
                playerData.animationFrame = null;
            }
        }
    }
    
    // Change play/pause icon
    function switchIcon(playerId) {
        const playerData = miniYTPlayers[playerId];
        
        if (playerData.isPlaying) {
            playerData.playIcon.html('<path d="M6 19h4V5H6zm8-14v14h4V5z"/>');
        } else {
            playerData.playIcon.html('<path d="M8 5v14l11-7z" />');
        }
    }
    
    // Update the progress bar
    function updateProgress(playerId) {
        const playerData = miniYTPlayers[playerId];
        const player = playerData.player;
        
        function formatTime(seconds) {
            seconds = Math.floor(seconds);
            const minutes = Math.floor(seconds / 60);
            seconds = seconds % 60;
            return minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        }
        
        function frame() {
            if (playerData.isPlaying) {
                const current = player.getCurrentTime();
                const duration = player.getDuration();
                const percent = (current / duration) * 100;
                
                playerData.progressBar.css('width', percent + '%');
                playerData.timeDisplay.text(formatTime(current));
                
                playerData.animationFrame = requestAnimationFrame(frame);
            }
        }
        
        if (playerData.animationFrame) {
            cancelAnimationFrame(playerData.animationFrame);
        }
        
        playerData.animationFrame = requestAnimationFrame(frame);
    }
    
})(jQuery);