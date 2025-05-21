## MYAP - Mini YouTube Audio Player
A WordPress plugin that creates a minimalistic audio player using YouTube videos.

## Features
- Minimalist audio player with simple design
- Uses YouTube API to play audio from videos
- Customizable: color, width and layout configurable
- Multiple players can coexist on the same page
- One-click play/pause control
- Interactive progress bar with drag-and-drop functionality
- Playback time display
- Two layout options: standard and reverse
- Background options: custom color or transparent

## Installation
- Download the plugin ZIP file
- Go to your WordPress admin panel
- Navigate to "Plugins" > "Add New" > "Upload Plugin".
- Select the downloaded ZIP file and click "Install Now".
- Activate the plugin

## Usage
Use the shortcode `[mini_youtube_player]` to insert the player into any page or post.

## Shortcode parameters
- **video_id**: ID of the YouTube video (required)
- **color**: Custom color for play button and progress bar (optional, by default: #129859)
- **width**: Maximum width in pixels (optional, default: auto)
- **layout**: Player design ('default' o 'reversed') (optional, by default: 'default')
- **bg_color**: Player background color (optional, by default: #959595)
- **transparent**: Transparent background ('true' o 'false') (optional, by default: 'false')

## Examples
- Basic player:
`[myap video_id="TiZ3gvoO5_I"]`

- Custom player:
`[myap video_id="TiZ3gvoO5_I" layout="reversed" bg_color="#FF0000" transparent="false" color="#262624"]`

- Custom background player:
`[myap video_id="TiZ3gvoO5_I" bg_color="#333333"]`

## Available designs
1. **Default design**
   - Progress bar → Time counter → Play button
2. **Reversed design**
   - Play button → Progress bar → Time counter

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
- Modern browser compatible with YouTube API
- Internet connection to load YouTube resources

## License
This plugin is distributed under the terms of the GPL v2 or later.
