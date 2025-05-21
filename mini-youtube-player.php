<?php
/**
 * Plugin Name: Mini YouTube Audio Player
 * Description: A minimalist audio player using YouTube videos
 * Version: 1.3
 * Author: José Lobos Sanhueza
 * Author URI: https://beraka.cl
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Tested up to: 6.5
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Mini_YouTube_Player {
    
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('mini_youtube_player', array($this, 'render_player_shortcode'));
    }
    
    public function enqueue_scripts() {
        wp_enqueue_script('youtube-api', 'https://www.youtube.com/iframe_api', array(), null, true);
        wp_enqueue_script('mini-youtube-player', plugin_dir_url(__FILE__) . 'js/mini-youtube-player.js', array('jquery', 'youtube-api'), '1.0', true);
        wp_enqueue_style('mini-youtube-player', plugin_dir_url(__FILE__) . 'css/mini-youtube-player.css', array(), '1.0');
    }
    
    public function render_player_shortcode($atts) {
        $atts = shortcode_atts(array(
            'video_id' => 'TiZ3gvoO5_I',  // Default video ID
            'color' => '#287083',         // Default color
            'width' => '300',             // Default width
        ), $atts, 'mini_youtube_player');
        
        // Generate a unique ID for each player instance
        $player_id = 'mini-yt-player-' . uniqid();
        
        // Passing data to JavaScript
        wp_localize_script('mini-youtube-player', 'miniYouTubePlayerData', array(
            'players' => array(
                $player_id => array(
                    'video_id' => esc_attr($atts['video_id']),
                    'color' => esc_attr($atts['color'])
                )
            )
        ), true);
        
        // Generate HTML for the player
        ob_start(); ?>
        <div class="mini-youtube-player" id="<?php echo esc_attr($player_id); ?>" 
             data-video-id="<?php echo esc_attr($atts['video_id']); ?>"
             data-color="<?php echo esc_attr($atts['color']); ?>"
             style="max-width: <?php echo esc_attr($atts['width']); ?>px;">
            <div class="player-card">
                <div class="progress-container">
                    <div class="progress"></div>
                </div>
                <div class="time-display">0:00</div>
                <button class="play-btn" style="background-color: <?php echo esc_attr($atts['color']); ?>">
                    <svg class="player-icon" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </button>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Initialize the plugin
$mini_youtube_player = new Mini_YouTube_Player();