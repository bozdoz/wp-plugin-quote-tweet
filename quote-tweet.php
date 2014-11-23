<?php
    /*
    Plugin Name: Quote Tweet
    Plugin URI: http://twitter.com/bozdoz/
    Description: A plugin for quickly tweeting a text selection.
    Version: 0.1
    Author: bozdoz
    Author URI: http://twitter.com/bozdoz/
    License: GPL2
    */

    add_action( 'wp_enqueue_scripts', 'quote_tweet_enqueue_and_register' );

    function quote_tweet_enqueue_and_register () {

        wp_register_script('quote_tweet_script', plugins_url('quote-tweet.js', __FILE__));

        wp_register_style('quote_tweet_style', plugins_url('quote-tweet.css', __FILE__));

        if ( ! is_admin() ) {
            /* viewing a theme page */
            
            // output Twitter name
            $quote_tweet_twitter_name = get_option('quote_tweet_twitter_name');
            $quote_tweet_add_mention_to_tweets = get_option('quote_tweet_add_mention_to_tweets');

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

    $quote_tweet_static_options = array (
        'text' => array(
            'quote_tweet_twitter_name' => 'bozdoz',
        ),
        'checks' => array(
            'quote_tweet_add_mention_to_tweets' => '0',
        ),
    );

    $quote_tweet_static_help = array (
        'quote_tweet_twitter_name' => 'Without the @ sign!',
        'quote_tweet_add_mention_to_tweets' => 'If this is checked, tweets will have "via @your-twitter-name" at the end of the suggested tweet.',
    );

    function quote_tweet_activation () {
        /* set default values to db */
        foreach($quote_tweet_static_options as $arrs) {
            foreach($arrs as $k=>$v) {
                add_option($k, $v);
            }
        }
    }
    register_activation_hook( __FILE__, 'quote_tweet_activation' );

    function quote_tweet_uninstall () {
        /* remove values from db */
        foreach ($quote_tweet_static_options as $arrs) {
            foreach($arrs as $k=>$v) {
                delete_option($k);
            }
        }
    }
    register_uninstall_hook( __FILE__, 'quote_tweet_uninstall' );

?>
