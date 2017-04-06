<?php
/**
 * This function handles the Archive Column Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\reference_knb_archive_column_form
 * @package  Reference\reference_knb_archive_column_form
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
 * Callback function for 'reference_knb_archive_column' setting
 *
 * @return void
 */
function reference_knb_archive_column_form()
{
    $option = new DSC\Reference\Options();
    $column = $option->getArchiveColumn();
    ?>
    
    <select name="reference_knb_archive_column" class="reference_select" id="reference_knb_archive_column">
        <option value="1" <?php selected(esc_attr($column), 1); ?>>1</option>
        <option value="2" <?php selected(esc_attr($column), 2); ?>>2</option>
        <option value="3" <?php selected(esc_attr($column), 3); ?>>3</option>
    </select>

    <?php esc_html_e(' Select number of columns.', 'reference'); ?>

    <p class="description">
        <?php esc_html_e('This option allows you to change the columns for your articles in knowledgebase archive page.', 'reference');?>
    </p>
    <?php
    return;
}
