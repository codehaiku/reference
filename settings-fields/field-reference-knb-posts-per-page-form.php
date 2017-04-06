<?php
/**
 * This function handles the Posts Per Page Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\reference_knb_posts_per_page_form
 * @package  Reference\reference_knb_posts_per_page_form
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
 * Callback function for 'reference_knb_posts_per_page' setting
 *
 * @return void
 */
function reference_knb_posts_per_page_form()
{
    $option = new DSC\Reference\Options();
    $posts_per_page = $option->getPostsPerPage();
    ?>

    <input name="reference_knb_posts_per_page" id="reference_knb_posts_per_page" type="number" class="small-text" placeholder="<?php esc_attr_e($posts_per_page); ?>" value="<?php esc_attr_e($posts_per_page); ?>">

    <p class="description">
        <?php esc_html_e('This option allows you to change the maximum knowledgebase to show in a page.', 'reference'); ?>
    </p>
    <p class="description">
        <?php esc_html_e('If this setting is set to 0 it would get the "Blog pages show at most" value in the "Settings" > "Readings" page.', 'reference'); ?>
    </p>

    <?php
    return;
}
