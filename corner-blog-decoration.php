<?php
/*
Plugin Name: Corner Blog Decoration
Plugin URI: http://www.noeonline.info/
Description: This plugin will create an decoration on your blog at the corner of user browser like a blogspot blog. You can customize these decoration. Let's check the screenshot for an example. The decoration menu can be found on <a href="tools.php?page=corner-blog-decoration.php">Tools > Blog Decoration</a>.
Author: Imanuel Novian (nick: noe, wp: noeprivacy)
Version: 1.1
Author URI: http://www.noeonline.info/
*/

function cbd_admin() {
	add_submenu_page( 'tools.php', 'Corner Blog Decoration', 'Blog Decoration', 10, __FILE__, 'cbd_admin_menu' );
}

function cbd_first() {
	if ( get_option( 'cbd_str' ) == false ) {
		add_option( 'cbd_str', '<a href="http://www.google.com/"><img src="http://www.google.com/intl/en_com/images/srpr/logo1w.png" alt="cbd" /></a>' );
	}
	if ( get_option( 'cbd_left_right' ) == false ) {
		add_option( 'cbd_left_right', 'right' );
	}
	if ( get_option( 'cbd_top_bottom' ) == false ) {
		add_option( 'cbd_top_bottom', 'bottom' );
	}
	if ( get_option( 'cbd_left_right_px' ) == false ) {
		add_option( 'cbd_left_right_px', '5' );
	}
	if ( get_option( 'cbd_top_bottom_px' ) == false ) {
		add_option( 'cbd_top_bottom_px', '5' );
	}
}

function cbd_admin_menu() {
	if ( ( get_option( 'cbd_str' ) && get_option( 'cbd_left_right' ) && get_option( 'cbd_top_bottom' ) && get_option( 'cbd_left_right_px' ) && get_option( 'cbd_top_bottom_px' ) ) == false ) {
		cbd_first();
	}

	echo('
		<div class="wrap">
		<h2>Corner Blog Decoration Options</h2><address style="font-size: 8pt; font-weight: 700;">Version 1.1 (<a href="http://www.noeonline.info/" target="_blank">Corner Blog Decoration</a>)</address>
	');
	if ( isset( $_POST['submit'] ) ) {
		$str = strtr( $_POST['cbd_str'], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$cbd = update_option( 'cbd_str', $str );
		$cbd .= update_option( 'cbd_left_right', $_POST['cbd_left_right'] );
		$cbd .= update_option( 'cbd_top_bottom', $_POST['cbd_top_bottom'] );
		$cbd .= update_option( 'cbd_left_right_px', $_POST['cbd_left_right_px'] );
		$cbd .= update_option( 'cbd_top_bottom_px', $_POST['cbd_top_bottom_px'] );
		if ( $cbd )
			echo('<div class="updated"><p><strong>Your setting has been save.</strong></p></div>');
		else
			echo('<div class="error"><p><strong>Your setting not save.</strong></p></div>');
	}

	echo('
		<form action="" method="post">
		<table class="form-table">
		<tr><td>HTML to insert<br/><span class="cbd_admin_hint">(Insert "&lt;a&gt;" tag, "&lt;img&gt;" tag, or javascript)<br/></span></td><td><textarea name="cbd_str" rows="5" cols="80">' . get_option( 'cbd_str' ) . '</textarea></td></tr>
		<tr><td>Horizontal Position<br/><span class="cbd_admin_hint">("Left" or "Right")</span></td><td><table><tr><td><select name="cbd_left_right">
	');
	switch( get_option( 'cbd_left_right' ) ) {
		case 'left' :
			echo( '
				<option value="left" selected="true">Left</option>
				<option value="right">Right</option>
			' );
		break;
		case 'right' :
			echo( '
				<option value="left">Left</option>
				<option value="right" selected="true">Right</option>
			' );
		break;
	}
	echo( '
		</select></td><td><input type="text" name="cbd_left_right_px" value="' . get_option( 'cbd_left_right_px' ) . '" size="4" maxlength="4" />&nbsp;px</td></tr></table></td></tr>
		<tr><td>Vertical Position<br/><span class="cbd_admin_hint">("Top" or "Bottom")</span></td><td><table><tr><td><select name="cbd_top_bottom">
	' );
	switch( get_option( 'cbd_top_bottom' ) ) {
		case 'top' :
			echo( '
				<option value="top" selected="true">Top</option>
				<option value="bottom">Bottom</option>
			' );
		break;
		case 'bottom' :
		echo( '
			<option value="top">Top</option>
			<option value="bottom" selected="true">Bottom</option>
		' );
		break;
	}
	echo( '
		</select></td><td><input type="text" name="cbd_top_bottom_px" value="' . get_option( 'cbd_top_bottom_px' ) . '" size="4" maxlength="4" />&nbsp;px</td></tr></table></td></tr>
		<hr />
		<tr><td colspan="2"><hr /></td></tr>
		<tr><td><input class="button-primary" type="submit" name="submit" value="Save Changes" /></td><td>&nbsp;</td></tr>
		</table>
		</form>
		</div>
	' );
}

add_action( 'admin_menu', 'cbd_admin' );
add_action( 'admin_head', 'cbd_admin_css' );

function cbd_admin_css() {
	echo( '
		<style type="text/css">
		.cbd_admin_hint {
		font-size: 7pt;
		font-style: italic;
		color: #080;
		}
		</style>
	' );
}

function cbd_loader() {
	$cbd_str = get_option( 'cbd_str' );
	$cbd_str_rep = strtr( $cbd_str, array( '&#34;' => '"', '\\' => '', '&#39;' => '' ) );
	echo( '
		<div class="cbd">' . $cbd_str_rep . '</div>
	' );
}

add_action( 'get_footer', 'cbd_loader' );

function cbd_loader_css() {
	$cbd_left_right = get_option( 'cbd_left_right' );
	$cbd_top_bottom = get_option( 'cbd_top_bottom' );
	$cbd_left_right_px = get_option( 'cbd_left_right_px' );
	$cbd_top_bottom_px = get_option( 'cbd_top_bottom_px' );

	echo( '
		<style type="text/css">
			.cbd {
				position: fixed;
				' . $cbd_left_right . ': ' . $cbd_left_right_px . 'px;
				' . $cbd_top_bottom . ': ' . $cbd_top_bottom_px . 'px;
			}
			.cbd a img {
				border: 0;
			}
		</style>
	' );
}

add_action( 'wp_head', 'cbd_loader_css' );

?>