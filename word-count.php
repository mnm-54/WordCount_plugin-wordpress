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

function wordcount_functionality($content)
{
    if (is_home()) {
        return $content;
    }
    // count words and time
    $word_n = wordcount_count_word($content);
    $time = wordcount_time($word_n);

    $labelw = __('Total number of words', 'word-count');
    $labelt = __('Average reading time', 'word-count');

    // for word count
    $labelw = apply_filters('wordcount_label', $labelw);
    $wordcount_visibility = apply_filters('wordcount_display_wordcount', 1);
    // for reading time
    $labelt = apply_filters('wordcount_label_time', $labelt);
    $wordcount_time_visibility = apply_filters('wordcount_display_time', 1);

    $tag = apply_filters('wordcount_tag', 'h4');
    if ($wordcount_visibility) {
        $content .= sprintf("<%s>%s: %s</%s>", $tag, $labelw, $word_n, $tag);
    }
    if ($wordcount_time_visibility) {
        $content .= sprintf("<%s>%s: %s minutes</%s>", $tag, $labelt, $time, $tag);
    }
    return $content;
}
function wordcount_count_word($content)
{
    // first remove all html tags
    $stripped_content = strip_tags($content);
    // count words
    $word_n = str_word_count($stripped_content);
    return $word_n;
}
function wordcount_time($wn)
{
    return ceil($wn / 200);
}
add_filter('the_content', 'wordcount_functionality');
