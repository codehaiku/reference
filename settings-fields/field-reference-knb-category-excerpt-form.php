<?php
/**
 * This function handles the Category Excerpt Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\reference_knb_category_excerpt_form
 * @package  Reference\reference_knb_category_excerpt_form
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
 * Callback function for 'reference_knb_category_excerpt' setting
 *
 * @return void
 */
function reference_knb_category_excerpt_form()
{
    $option = new DSC\Reference\Options();
    $category_excerpt = $option->getCategoryExcerpt();
    ?>

    <input name="reference_knb_category_excerpt" id="reference_knb_category_excerpt" type="number" class="small-text" min="15" placeholder="<?php esc_attr_e($category_excerpt); ?>" value="<?php esc_attr_e($category_excerpt); ?>">
    <p class="description">
        <?php esc_html_e('This option allows you to change the maximum characters for the category description.', 'reference'); ?>
    </p>
    <?php
    return;
}
