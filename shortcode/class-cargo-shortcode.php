<?php

class Cargo_Shortcode
{
    static $add_script;
    static $full;

    static function init()
    {
        add_shortcode('cargo-calc-samara', array(__CLASS__, 'calculator_func'));
        add_action('init', array(__CLASS__, 'register_script'));
        add_action('wp_footer', array(__CLASS__, 'js_variables'));
        add_action('wp_footer', array(__CLASS__, 'print_script'));
    }

    static function calculator_func($atts)
    {
        self::$add_script = true;
        $atts = shortcode_atts(array(
            'full' => '0'
        ), $atts);

        $html = "
        <div id=\"cargo-calc\"><demo></demo></div>
        ";

        self::$full = sanitize_text_field($atts['full']);

        return $html;
    }

    static function register_script()
    {
        $url = plugin_dir_url(__FILE__);
        wp_register_style('cargo-module', plugin_dir_url(__FILE__) . 'dist/cargo.css', null, time(), 'all');
        wp_register_script('vue', plugin_dir_url(__FILE__) . 'js/vue.min.js', array(), null, true);
        wp_register_script('cargo-module-lib', plugin_dir_url(__FILE__) . 'dist/cargo.umd.min.js', array('vue'), time(), true);
        wp_register_script('main', plugin_dir_url(__FILE__) . 'js/main.js', array('cargo-module-lib'), time(), true);
    }

    static function print_script()
    {
        if (!self::$add_script) {
            return;
        }
        wp_enqueue_style('cargo-module');
        wp_print_scripts('vue');
        wp_print_scripts('cargo-module-lib');
        wp_print_scripts('main');
    }

    static function js_variables()
    {
        if (!self::$add_script) {
            return;
        }

        $variables = array(
            'plugin_dir_url' => plugin_dir_url(__FILE__),
            'url_ajax' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('myajax-nonce123'),
            'is_full' => self::$full
        );
        echo('<script type="text/javascript">window.wp_data=' . json_encode($variables) . ';</script>');
    }
}
