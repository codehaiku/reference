<?php
/**
 * This function handles the BreadCrumbs Separator Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\reference_knb_breadcrumbs_separator_form
 * @package  Reference\reference_knb_breadcrumbs_separator_form
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
 * Callback function for 'reference_knb_breadcrumbs_separator' setting
 *
 * @return void
 */
function reference_knb_breadcrumbs_separator_form()
{
    $option = new DSC\Reference\Options();
    $breadcrumbs_separator = $option->getBreadcrumbsSeparator();
    ?>

    <input name="reference_knb_breadcrumbs_separator" id="reference_knb_breadcrumbs_separator" type="text" class="regular-text code" maxlength="80" value="<?php esc_attr_e($breadcrumbs_separator); ?>">
    <p class="description">
        <?php esc_html_e('This option allows you to change the separator for your knowledgebase category and single knowledgebase page.', 'reference'); ?>
    </p>
    <?php
    return;
}
