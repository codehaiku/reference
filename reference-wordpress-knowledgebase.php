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

// Require the plugin activation class.
require_once plugin_dir_path(__FILE__) . 'classes/reference-activator.php';

// Require the helper class.
require_once plugin_dir_path(__FILE__) . 'classes/reference-helper.php';

// Require the loader class.
require_once plugin_dir_path(__FILE__) . 'classes/reference-loader.php';

// The template tags.
require_once plugin_dir_path(__FILE__) . 'template-tags/template-tags.php';

// Register the activation hook.
register_activation_hook(__FILE__, 'reference_activate');

/**
 * Clear permalink on plugin activate.
 * 
 * @return void
 */
function reference_activate()
{
    $plugin = new \DSC\Reference\Activator();
    $plugin->activate();
    return;
}

// Bootstrap the plugin.
$plugin = new \DSC\Reference\Loader();
$plugin->runner();
