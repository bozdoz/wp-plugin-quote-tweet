<?php
/*
    Plugin Name: Quote Tweet
    Plugin URI: http://twitter.com/bozdoz/
    Description: A plugin for quickly tweeting a text selection.
    Version: 0.6
    Author: bozdoz
    Author URI: http://twitter.com/bozdoz/
    License: GPL2
*/

$quote_tweet_static_options = array(
    'text' => array('quote_tweet_twitter_name' => 'bozdoz'),
    'checks' => array('quote_tweet_add_mention_to_tweets' => '0')
    //'serialized' => array()
);

$quote_tweet_static_help = array(
    'quote_tweet_twitter_name' => 'Without the @ sign!',
    'quote_tweet_add_mention_to_tweets' => 'If this is checked, tweets will have "via @your-twitter-name" at the end of the suggested tweet.'
    //'quote_tweet_bitly_access_token' => '(Optional) Use bit.ly to generate a shortlink.  Easily trackable. Sign up for bit.ly and get an access token <a href="https://bitly.com/a/oauth_apps" target="_blank">here</a>.',
    //'quote_tweet_bitly_api_endpoint' => 'A url hosted on your site to access the bit.ly API, if an access token is given',
    //'quote_tweet_use_bitly' => 'If this is checked, the URLs will be shortened with your bit.ly account, if given.',
);

add_action('init', 'quote_tweet_init');

function quote_tweet_init () {

    function foreachoption ( $method ) {
        global $quote_tweet_static_options;
        foreach($quote_tweet_static_options as $arrs) {
            foreach($arrs as $k=>$v) {
                $method($k, $v);
            }
        }
    }

    register_activation_hook( __FILE__, 'quote_tweet_activation' );

    function quote_tweet_activation () {
        /* set default values to db */
        foreachoption( add_option );
    }

    register_uninstall_hook( __FILE__, 'quote_tweet_uninstall' );

    function quote_tweet_uninstall () {
        /* remove values from db */
        foreachoption( delete_option );
    }

    add_action( 'wp_enqueue_scripts', 'quote_tweet_enqueue_and_register' );

    function quote_tweet_enqueue_and_register () {
        wp_register_script('quote_tweet_script', plugins_url('quote-tweet.js', __FILE__), Array(), '0.2', true);
        wp_register_style('quote_tweet_style', plugins_url('quote-tweet.css', __FILE__));

        if ( ! is_admin() ) {
            $quote_tweet_twitter_name = get_option('quote_tweet_twitter_name', '');
            $quote_tweet_add_mention_to_tweets = get_option('quote_tweet_add_mention_to_tweets', '');

            echo "<script>var QuoteTweet = {};";

            if ( $quote_tweet_twitter_name &&
                $quote_tweet_add_mention_to_tweets ) {
                echo "QuoteTweet.via = '$quote_tweet_twitter_name';";
            }
            echo "</script>";

            wp_enqueue_script( 'quote_tweet_script' );
            wp_enqueue_style( 'quote_tweet_style' );

        }
    }

    add_action('admin_init', 'quote_tweet_admin_init');

    function quote_tweet_admin_init () {
        wp_register_style('quote_tweet_admin_style', plugins_url('admin/style.css', __FILE__));
    }

    add_action('admin_menu', 'quote_tweet_admin_menu');

    function quote_tweet_admin_menu () {
        add_options_page("Quote Tweet", "Quote Tweet", 'manage_options', 'quote-tweet', 'settings_page');
        function settings_page () {
            wp_enqueue_style( 'quote_tweet_admin_style' );
            include 'admin/admin.php';
        }
    }
}