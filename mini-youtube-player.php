<?php
/**
 * Plugin Name: MYAP - Mini YouTube Audio Player
 * Description: Un reproductor minimalista de audio que utiliza videos de YouTube
 * Version: 1.5
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

class MYAP_Player {
    
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('myap', array($this, 'render_player_shortcode')); // Shortcode cambiado a 'myap'
    }
    
    public function enqueue_scripts() {
        wp_enqueue_script('youtube-api', 'https://www.youtube.com/iframe_api', array(), null, true);
        wp_enqueue_script('myap-player', plugin_dir_url(__FILE__) . 'js/mini-youtube-player.js', array('jquery', 'youtube-api'), '1.5', true);
        wp_enqueue_style('myap-player', plugin_dir_url(__FILE__) . 'css/mini-youtube-player.css', array(), '1.5');
    }
    
    public function render_player_shortcode($atts) {
        $atts = shortcode_atts(array(
            'video_id' => 'TiZ3gvoO5_I',  // Default video ID
            'color' => '#287083',         // Default color
            'width' => '300',             // Default width
            'layout' => 'default',        // Layout: 'default' or 'reversed'
            'bg_color' => '#959595',      // Background color
            'transparent' => 'false'      // Transparent background: 'true' or 'false'
        ), $atts, 'myap'); // Shortcode cambiado a 'myap'
        
        // Generar un ID único para cada instancia del reproductor
        $player_id = 'mini-yt-player-' . uniqid();
        
        // Pasar datos a JavaScript
        wp_localize_script('myap-player', 'miniYouTubePlayerData', array(
            'players' => array(
                $player_id => array(
                    'video_id' => esc_attr($atts['video_id']),
                    'color' => esc_attr($atts['color'])
                )
            )
        ), true);
        
        // Determinar el estilo del fondo
        $bg_style = '';
        if (strtolower($atts['transparent']) === 'true') {
            $bg_style = 'background-color: transparent;';
        } else {
            $bg_style = 'background-color: ' . esc_attr($atts['bg_color']) . ';';
        }
        
        // Determinar la clase de layout
        $layout_class = '';
        if (strtolower($atts['layout']) === 'reversed') {
            $layout_class = 'layout-reversed';
        }
        
        // Generar HTML para el reproductor
        ob_start(); ?>
        <div class="mini-youtube-player" id="<?php echo esc_attr($player_id); ?>" 
             data-video-id="<?php echo esc_attr($atts['video_id']); ?>"
             data-color="<?php echo esc_attr($atts['color']); ?>"
             style="max-width: <?php echo esc_attr($atts['width']); ?>px;">
            <div class="player-card <?php echo esc_attr($layout_class); ?>" style="<?php echo $bg_style; ?>">
                <div class="progress-container">
                    <div class="progress"></div>
                    <div class="progress-handle" style="background-color: <?php echo esc_attr($atts['color']); ?>"></div>
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

// Inicializar el plugin
$myap_player = new MYAP_Player();