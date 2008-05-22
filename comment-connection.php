<?php
/*
Plugin Name: Comment Connection
Plugin URI: http://www.wesg.ca/2008/04/wordpress-plugin-comment-connection/
Description: Link comments referencing one another automatically.
Version: 1.5
Author: Wes Goodhoofd
Author URI: http://www.wesg.ca/

This program is free software; you can redistribute it and/or
modify it under the terms of version 2 of the GNU General Public
License as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details, available at
http://www.gnu.org/copyleft/gpl.html
or by writing to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

//plugin function
function comment_connection($comment) {
global $wpdb;

//replace new lines \n with line breaks <br /> in order to detect comment reference
$comment = nl2br($comment);

//replace extra spaces after @
$r = "@";
$s = "@ ";
$i = 1;
$blank = substr_count($comment, $s);
if ($blank > 0) 
	$comment = str_replace($s, $r, $comment, $i);

	//determine if someone is referencing a comment
	$count = substr_count($comment, "@");

	if ($count > 0) {

	//find the post ID without printing to screen
	$pid = get_the_ID();

	//find the comment ID without printing to screen
	$cid = get_comment_ID();
	
	//this is the big change
	//determine all occurances of @ and their following authors
	//then loads into array
	preg_match_all("/@(.*)(:|\<br \/\>|,)/", $comment, $out);

	for ($x=0; $x < count($out[1]); $x++) {
		//solves little problem with colon usage
		if (substr_count($out[1][$x], ':') > 0) 
			$out[1][$x] = substr($out[1][$x], 0, strpos($out[1][$x], ':'));
		//solves other little problem with extra spaces
		if (substr_count($out[1][$x], ' ') <= 2)
			$array[$x] = $out[1][$x];

		//retrieve comment info from database
		$d = db_query($pid, $cid, $array[$x]);

		//replace the authors with their comment IDs
		if ($d != NULL)
			$comment = str_ireplace('@' . $array[$x], '@<a href=#comment-' . $d . '>' . $array[$x] . '</a>', $comment);
	}
}

return $comment; //print the modified comments
}

function db_query($pid, $cid, $string) {
	global $wpdb;
	$result = $wpdb->get_var("SELECT comment_ID FROM $wpdb->comments WHERE comment_author = '$string' AND comment_post_ID = '$pid' AND comment_ID < '$cid' ORDER BY comment_date DESC LIMIT 1");

	return $result;
}

add_filter('comment_text', 'comment_connection'); //apply before printing comments