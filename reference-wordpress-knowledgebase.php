<?php
/**
 * Plugin Name: Reference Knowledgebase and Docs
 * Plugin URI:  https://wordpress.org/plugins/reference-wordpress-knowledgebase/
 * Description: A lightweight knowledgebase plugin for your WordPress
 *              website. Works with any theme.
 * Version:     1.0.0
 * Author:      Dunhakdis
 * Author URI:  https://profiles.wordpress.org/dunhakdis/
 * Text Domain: reference
 * Domain Path: /languages
 * License:     GPL2
 *
 * PHP Version 5.4
 *
 * @category Reference
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */

if (! defined('ABSPATH')) {
    return;
}
define('REFERENCE_DIR_PATH', trailingslashit(plugin_dir_path(__FILE__)));

define('REFERENCE_PATH', plugin_dir_path(__FILE__));

register_activation_hook(__FILE__, 'Run_activator');

/**
 * This functions runs the Activator class.
 *
 * @since  1.0.0
 * @return void
 */
function Run_activator()
{
    $plugin = new \DSC\Reference\Activator();
    $plugin->activate();
}
/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path(__FILE__) . 'classes/reference-activator.php';

/**
 * The helper class.
 */
require_once plugin_dir_path(__FILE__) . 'classes/reference-helper.php';


require_once plugin_dir_path(__FILE__) . 'classes/reference-loader.php';


require_once plugin_dir_path(__FILE__) . 'template-tags/template-tags.php';

/**
 * This functions executes the plugin
 */
$plugin = new \DSC\Reference\Loader();
$plugin->runner();
