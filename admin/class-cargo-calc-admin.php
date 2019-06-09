<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://portfolio.infoblog72.ru
 * @since      1.0.0
 *
 * @package    Cargo_Calc
 * @subpackage Cargo_Calc/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cargo_Calc
 * @subpackage Cargo_Calc/admin
 * @author     Oleg Grebenev <admin@infoblog72.ru>
 */
class Cargo_Calc_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action('admin_menu', array($this, 'add_plugin_page'));
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'css/cargo-calc-admin.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . '-pure', plugin_dir_url(__FILE__) . 'css/pure-min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . '-datepicker', plugin_dir_url(__FILE__) . 'css/datepicker.min.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name . '-datepicker', plugin_dir_url(__FILE__) . 'js/datepicker.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . '-datepicker-ru', plugin_dir_url(__FILE__) . 'js/datepicker.ru-RU.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . '-validate', plugin_dir_url(__FILE__) . 'js/jquery.validate.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . '-messages', plugin_dir_url(__FILE__) . 'js/messages_ru.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . '-cargo', plugin_dir_url(__FILE__) . 'js/cargo-calc-admin.js', array('jquery'), $this->version, false);

    }

    public function add_plugin_page()
    {
        add_submenu_page(
            'edit.php?post_type=order_cargo',
            'Cargo export', // page_title
            'Экспорт в CSV', // menu_title
            'manage_options', // capability
            'cargo-calc-export', // menu_slug
            array($this, 'create_admin_page') // function
        );
    }

    public function create_admin_page()
    {
        ?>
        <div class="wrap">
            <h2>Экспорт в CSV заказов грузового такси</h2><br/>
            <form class="pure-form pure-form-aligned" id="form-export">
                <fieldset>
                    <div class="pure-control-group">
                        <label for="name">Начальная дата</label>
                        <input id="date_from" type="text" data-toggle="datepicker" autocomplete="off" name="date_from"
                               required>
                    </div>

                    <div class="pure-control-group">
                        <label for="password">Конечная дата</label>
                        <input id="date_to" type="text" data-toggle="datepicker" autocomplete="off" name="date_to"
                               required>
                    </div>
                    <div class="pure-controls form-horizontal">
                        <button class="pure-button pure-button-primary" id="btn-submit" type="submit">Экспорт</button>
                        <div class="animate-spin" id="spinner">
                            <img src="<?php echo plugin_dir_url(__FILE__) ?>/img/sync-solid.svg" class="spin">
                        </div>
                    </div>
                    <div id="form-note"></div>
                </fieldset>

            </form>
        </div>
    <?php }
}
