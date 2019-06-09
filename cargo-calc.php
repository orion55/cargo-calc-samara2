<?php

/**
 *
 * @link              http://portfolio.infoblog72.ru
 * @since             1.1.0
 * @package           Cargo_Calc
 *
 * @wordpress-plugin
 * Plugin Name:       Сargo сalc Samara
 * Plugin URI:        cargo-calc-samara
 * Description:       Калькулятор по расчету стоимости услуг грузового такси (Самара)
 * Version:           1.1.0
 * Author:            Oleg Grebenev
 * Author URI:        http://portfolio.infoblog72.ru
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cargo-calc
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('PLUGIN_NAME_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cargo-calc-activator.php
 */
function activate_cargo_calc()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-cargo-calc-activator.php';
    Cargo_Calc_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cargo-calc-deactivator.php
 */
function deactivate_cargo_calc()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-cargo-calc-deactivator.php';
    Cargo_Calc_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_cargo_calc');
register_deactivation_hook(__FILE__, 'deactivate_cargo_calc');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-cargo-calc.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cargo_calc()
{

    $plugin = new Cargo_Calc();
    $plugin->run();

}

run_cargo_calc();

require plugin_dir_path(__FILE__) . 'shortcode/class-cargo-shortcode.php';
require plugin_dir_path(__FILE__) . 'includes/admin-panel.php';

function run_cargo_shortcode()
{
    $shortcode = new Cargo_Shortcode();
    $shortcode->init();
}

run_cargo_shortcode();
