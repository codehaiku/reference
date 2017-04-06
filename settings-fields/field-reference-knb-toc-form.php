<?php
/**
 * This function handles the Knowledgebase Table of Contents Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\reference_knb_toc_form
 * @package  Reference\reference_knb_toc_form
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
 * Callback function for 'reference_knb_toc' setting
 *
 * @return void
 */
function reference_knb_toc_form()
{
    $option = new DSC\Reference\Options();
    $toc = $option->getTableOfContent();
    ?>

    <label for="reference_knb_toc">
        <input name="reference_knb_toc" id="reference_knb_toc" type="checkbox" class="regular-text code" value="1" <?php echo checked(1, esc_attr($toc), false); ?>>
        <?php esc_html_e('Enable Table of Contents', 'reference'); ?>
    </label>

    <p class="description">
        <?php esc_html_e('This option allows you to enable the Table of Contents for your knowledgebase pages.', 'reference'); ?>
    </p>

    <?php
    return;
}
