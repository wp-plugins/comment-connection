=== Comment Connection ===
Contributors: wesg
Tags: comments,link,reply
Requires at least: 2.0
Tested up to: 2.7
Stable tag: 1.6

Comment Connection is a Wordpress plugin that automatically links comments as authors reply to each other.

== Description ==

Comment Connection is a plugin that turns an element of comment text to a link for a previous comment. Whenever an author uses @*commenter*, the text after @ is automatically linked to the previous comment it refers to.

The plugin works by searching each comment for an occurance of @. Where it finds one, the plugin searches the comment database for a comment on the same post written by the person being referenced. By doing it this way, the plugin only adds one database query for each referencing comment. 

If the type after the @ symbol does not correspond to a comment, no changes are made.

Currently tested successfully with the most current version of WP, 2.7. If you have trouble with earlier versions, or even have it work properly on earlier versions, please let me know.

For a complete list of the changes from each version, please visit <a href="http://www.wesg.ca/2008/04/wordpress-plugin-comment-connection/#changelog">the plugin homepage</a>.

Be sure to check out my other plugins at <a href="http://wordpress.org/extend/plugins/profile/wesg">my Wordpress profile</a>.

= USAGE =

Inside a comment, write @*commenter* where *commenter* is the name of the author you are replying to. The plugin will successfully find a link when the commenter text is followed by a new line, colon (:), comma (,) or a dash (-).

= LIMITATIONS =

1. *Commenter* must be an exact match of the original author's name.
1. Many database queries can occur for a post with many referencing comments.
1. Only links to the last comment made by commenter (ie. if the commenter writes many comments before the @, the most recent one is linked to).

== Installation ==

1. Copy the folder comment-connection into your WordPress plugins directory (wp-content/plugins).
1. Log in to WordPress Admin. Go to the Plugins page and click Activate for Comment Connection.


== Frequently Asked Questions ==

= What is the purpose of this plugin? =

Comment Connection allows readers to follow conversations by automatically linking to comments that are replied to. This becomes especially important with longer conversations.

= What symbol triggers the response? =

The @ symbol currently modifies comments, though more options may become available later.

= How does the plugin know when not to add a link? =

In addition to the @ symbol, the reference must be followed by either a new line, colon or comma. This means that neither email addresses nor regular names are turned into a link unless it has the @ symbol.

= Will the plugin work if I use a different case? =

Yes. Comment Connection will still find the reference if the case is different. Ex. *@john smith*: will reference the comment by *John Smith*.