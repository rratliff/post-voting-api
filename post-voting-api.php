<?php
/**
 * @package Post Voting API
 * @version 0.1
 */
/*
Plugin Name: Post Voting API
Plugin URI: http://bobbyratliff.nfshost.com/postvoting/
Description: Post rating API that relies on post meta to store vote count.
Version: 0.1
Author: Robert Ratliff
Author URI: http://bobbyratliff.nfshost.com/
*/
if(!class_exists('Post_Voting_API'))
{
    class Post_Voting_API
    {
        private $post_meta_key = 'pva_votes';

        public function __construct()
        {
            // register actions
            add_action('wp_ajax_nopriv_pva_getposts',
                array(&$this, 'getposts'));
            add_action('wp_ajax_pva_getposts',
                array(&$this, 'getposts'));
            add_action('wp_ajax_nopriv_pva_addvote',
                array(&$this, 'addvote'));
            add_action('wp_ajax_pva_addvote',
                array(&$this, 'addvote'));
        }

        public static function activate()
        {
        }

        public static function deactivate()
        {
            delete_metadata('post', 0, $this->post_meta_key, '',
                $delete_all = true);
        }

        private function get_meta_key($id)
        {
            return get_post_meta($id, $this->post_meta_key, TRUE);
        }

        private function get_post_votes($id)
        {
            $vote_count = $this->get_meta_key($id);
            if (empty($vote_count))
                return 0;
            return (int) $vote_count;
        }

        public function getposts()
        {
            header("Content-Type: application/json");
            $postslist = array();
            foreach (get_posts(array('posts_per_page'=>-1)) as $post) {
                $post_new = array();
                $post_new["id"] = $post->ID;
                $post_new["title"] = $post->post_title;
                $post_new["votes"] = $this->get_post_votes($post->ID);
                $post_new["date"] = $post->post_date_gmt;
                array_push($postslist, $post_new);
            }
            echo json_encode($postslist);
            exit;
        }

        public function addvote()
        {
            if (!isset($_POST['id']))
            {
                echo 'false';
                exit;
            }
            $id = (int) $_POST['id'];
            if (null == get_post($id)) {
                echo 'false';
                exit;
            }
            $vote_count = $this->get_meta_key($id);
            if (empty($vote_count)) {
                add_post_meta($id, $this->post_meta_key, 1, TRUE);
            }
            update_post_meta($id, $this->post_meta_key, $vote_count + 1);

            echo 'true';
            exit;
        }
    }
}

if (class_exists('Post_Voting_API'))
{
    register_activation_hook(__FILE__,
        array('Post_Voting_API','activate'));
    register_deactivation_hook(__FILE__,
        array('Post_Voting_API','deactivate'));

    $post_voting_api = new Post_Voting_API();
}


?>
