<?php
/*
Plugin Name: Comment connection
Plugin URI: http://www.wesg.ca/2008/04/wordpress-plugin-comment-connection/
Description: Link comments referencing one another automatically.
Version: 1.1
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
function bold_comment($comment) {
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
	ob_start();
	the_ID();
	$pid = ob_get_contents();
	ob_end_clean();

	//find the comment ID without printing to screen
	ob_start();
	comment_ID();
	$cid = ob_get_contents();
	ob_end_clean();


	//find the author of the comment to reference
	$string = get_string_between($comment, '@', '<br />', 0);
	$colon = get_string_between($comment, '@', ':', 0);

	//by comparing the length of the two elements, only one query is required
	$string_length = strlen($string);
	$colon_length = strlen($colon);

	if ($string_length < $colon_length)
		$author = $string;
	else if ($string_length > $colon_length)
		$author = $colon;

	//find the comment id of comment being referenced
	//query finds last comment submitted by author on this specific post
	//as well as those that occur before this comment
	
	if  (($string_length > 0) && ($colon_length > 0)) {
		$d = db_query($pid, $cid, $author);
		
		//replace the comment with the modified link, but only if a suitable comment is found
		if ($d != NULL)
		$comment = str_ireplace($author, '<a href="#comment-' . $d . '">' . $author . '</a>', $comment);
		}
	}

     return $comment; //print the modified comments
}

//find the comment author to reference
//obtained from http://php.oregonstate.edu/manual/en/ref.strings.php
function get_string_between($string, $start, $end, $num){
    $string = " ".$string;
     $ini = strpos($string,$start);
     if ($ini == 0) return "";
     $ini += strlen($start);     
     $len = strpos($string,$end,$ini) - $ini+$num;
     return substr($string,$ini,$len);
}

function db_query($pid, $cid, $string) {
	global $wpdb;
	$result = $wpdb->get_var("SELECT comment_ID FROM $wpdb->comments WHERE comment_author = '$string' AND comment_post_ID = '$pid' AND comment_ID < '$cid' ORDER BY comment_date DESC LIMIT 1");

	return $result;
}

add_filter('comment_text', 'bold_comment'); //apply before printing comments