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
 * @category Reference\Reference_Knb_Posts_Per_Page_Form
 * @package  Reference\Reference_Knb_Posts_Per_Page_Form
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */

if (! defined('ABSPATH') ) {
    return;
}
/**
 * Callback function for 'reference_knb_posts_per_page' setting
 *
 * @return void
 */
function Reference_Knb_Posts_Per_Page_form()
{

    echo '<input
            name="reference_knb_posts_per_page"
            id="reference_knb_posts_per_page"
            type="number"
            class="small-text"
            min="1"
            max="10"
            placeholder="10"
            value="' .
                absint(esc_attr(get_option('reference_knb_posts_per_page'))) .
            '"
        >';
    echo '<p class="description">' .
            esc_html__(
                'This option allows you to change the maximum
            knowledgebase to show in a page.',
                'reference'
            ) .
        ' </p>';

    return;
}
