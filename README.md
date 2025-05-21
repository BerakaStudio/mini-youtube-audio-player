## Mini YouTube Audio Player
A WordPress plugin that creates a minimalistic audio player using YouTube videos.

## Features
- Minimalist audio player with elegant design
- Uses YouTube API to play audio from videos
- Customizable: configurable color and width
- Multiple players can coexist on the same page
- One-click play/pause control
- Interactive progress bar for track navigation
- Playback time display

## Installation
- Download the plugin ZIP file
- Go to your WordPress admin panel
- Navigate to "Plugins" > "Add New" > "Upload Plugin".
- Select the downloaded ZIP file and click "Install Now".
- Activate the plugin

## Usage
Use the shortcode `[mini_youtube_player]` to insert the player into any page or post.

### Shortcode parameters
- **video_id**: ID of the YouTube video (required)
- **color**: Custom color for play button and progress bar (optional, by default: #129859)
- **width**: Maximum width in pixels (optional, default: auto)

## Examples
- Basic player:
`[mini_youtube_player video_id="TiZ3gvoO5_I"]`

- Custom player:
`[mini_youtube_player video_id="TiZ3gvoO5_I" color="#287083" width="400"]`

## Troubleshooting
If you experience any problems with the plugin:

- Make sure jQuery is loaded on your site.
- Verify that there are no conflicts with other plugins that use the YouTube API
- Check that the YouTube video ID is valid and available for playback
- Confirm that your browser allows autoplay of media content

## Limitations
- Requires Internet connection to access the YouTube API
- Some videos may have playback restrictions based on region or owner's settings
- The plugin plays only the audio of the video, it does not display the visual content

## Requirements
- WordPress 5.0 or greater
- PHP 7.0 or greater
- Navegador moderno compatible con la API de YouTube
- Conexión a Internet para cargar los recursos de YouTube

## License
This plugin is distributed under the terms of the GPL v2 or later.
