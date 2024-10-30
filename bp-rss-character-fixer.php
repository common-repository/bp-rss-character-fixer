<?php
/*
 Plugin Name: BuddyPress RSS Character Fixer
 Plugin URI: http://alierkurt.net/plugins/bp-rss-fixer.zip
 Description: Fixes Buddypress's RSS feed titles' corrupted characters for all languages.
 Author: Ali Erkurt
 Author URI: http://alierkurt.net
 License: GNU GENERAL PUBLIC LICENSE 3.0 http://www.gnu.org/licenses/gpl.txt
 Version: 1.0
 Site Wide Only: true
*/

	function rsscharfixer() {
		global $activities_template;

		if ( !empty( $activities_template->activity->action ) )
			$content = $activities_template->activity->action;
		else
			$content = $activities_template->activity->content;

		$content = explode( '<span', $content );
		$title = trim( strip_tags( html_entity_decode( $content[0] ) ) );

		if ( ':' == substr( $title, -1 ) )
			$title = substr( $title, 0, -1 );

		if ( 'activity_update' == $activities_template->activity->type )
			$title .= ': ' . strip_tags( bp_create_excerpt( $activities_template->activity->content, 15 ) );

		return apply_filters( 'rsscharfixer', $title );
	}
add_filter('bp_get_activity_feed_item_title', 'rsscharfixer');
?>