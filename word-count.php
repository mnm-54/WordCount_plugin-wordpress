<?php
/*
Plugin Name: Word Count
Plugin URI: 
Description: Count Words from any WordPress Post
Version: 1.0
Author: munem
Author URI: https://github.com/mnm-54
License: GPLv2 or later
Text Domain: word-count
Domain Path: /languages/
*/

// activation ans deactivation hook
// function wordcount_activation_hook(){}
// register_activation_hook(__FILE__, 'wordcount_activation_hook');

// function wordcount_deactivation_hook(){}
// register_deactivation_hook(__FILE__, 'wordcount_deactivation_hook');

function wordcount_load_textdomain()
{
    load_plugin_textdomain('word-count', false, dirname(__FILE__) . '/languages');
}
add_action('plugins_loaded', 'wordcount_load_textdomain');

function wordcount_count_word($content)
{
    // first remove all html tags
    $stripped_content = strip_tags($content);
    // count words
    $word_n = str_word_count($stripped_content);
    $label = __('Total number of words', 'word-count');
    $content .= sprintf("<h4>%s: %s</h4>", $label, $word_n);
    return $content;
}
add_filter('the_content', 'wordcount_count_word');
