=== Post Voting API ===
Contributors: Robert Ratliff
Tags: ajax, post, voting
License: GPLv2 or later

Post voting API that relies on post meta to store vote count.

== Description ==

The plugin provides two AJAX actions at the standard WordPress endpoint URL,
`wp-admin/admin-ajax.php`. (All requests to this URL must use HTTP POST.)

Action: getposts
Parameters: none
Output:
A JSON array of post objects, each with the following properties:
  - id
  - title
  - votes

Action: addvote
Parameters: id
Output:
`true` on success, `false` on failure. (Note: both these responses will have
HTTP 200 status code.)
