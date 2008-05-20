=== Comment Connection ===
Contributors: wesg
Tags: comments,link,reply
Requires at least: 2.0
Tested up to: 2.5
Stable tag: 1.4

Comment Connection is a Wordpress plugin that automatically links comments as authors reply to each other.

== Description ==

Comment Connection is a plugin that turns an element of comment text to a link for a previous comment. Whenever an author uses @*commenter*, the text after @ is automatically linked to the previous comment it refers to.

The plugin works by searching each comment for an occurance of @. Where it finds one, the plugin searches the comment database for a comment on the same post written by the person being referenced. By doing it this way, the plugin only adds one database query for each referencing comment. 

If the type after the @ symbol does not correspond to a comment, no changes are made.

Currently tested successfully with WP 2.5. If you have trouble with earlier versions, or even have it work properly on earlier versions, please let me know.

= USAGE =

Inside a comment, write @*commenter* where *commenter* is the name of the author you are replying to. This can happen anywhere in the comment, so long as there is a new line or : after the reference.

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

In addition to the @ symbol, the reference must be followed by either a new line or semicolon. This means that neither email addresses nor regular names are turned into a link unless it has the @ symbol.