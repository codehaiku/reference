<?php
/**
 * This function handles the BreadCrumbs Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\reference_knb_breadcrumbs_form
 * @package  Reference\reference_knb_breadcrumbs_form
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
include_once plugin_dir_path(dirname(__FILE__)) .
             'classes/reference-options.php';
/**
 * Callback function for 'reference_knb_breadcrumbs' setting
 *
 * @return void
 */
function reference_knb_breadcrumbs_form()
{
    $option = new DSC\Reference\Options();
    $breadcrumbs = $option->getBreadcrumbs();
    ?>
    
    <label for="reference_knb_breadcrumbs">
        <input name="reference_knb_breadcrumbs" id="reference_knb_breadcrumbs" type="checkbox" class="regular-text code" value="1" <?php echo checked( 1, esc_attr($breadcrumbs), false ); ?>>
        <?php esc_html_e('Enable Breadcrumbs', 'reference'); ?>
    </label>

    <p class="description">
        <?php esc_html_e('This option allows you to enable the BreadCrumbs for your knowledgebase pages.', 'reference'); ?>
    </p>
    <?php
    return;
}
