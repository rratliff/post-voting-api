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
  - date

Action: addvote
Parameters: id
Output:
the modified post object.

== Example ==

For an example of the API in use, see http://bobbyratliff.nfshost.com/postvoting/

== Development environment ==

You can develop the plugin using wordpress inside Docker. To deploy the plugin to the container, re-run the *cp* command.

docker build -t my-wordpress --file Dockerfile .
mkdir -p wordpress/wp-content/plugins/post-voting-api
cp README.txt post-voting-api.php wordpress/wp-content/plugins/post-voting-api
docker-compose up