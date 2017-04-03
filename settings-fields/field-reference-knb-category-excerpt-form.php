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
 * @category Reference\Reference_Knb_Category_Excerpt_Form
 * @package  Reference\Reference_Knb_Category_Excerpt_Form
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
 * Callback function for 'reference_knb_category_excerpt' setting
 *
 * @return void
 */
function Reference_Knb_Category_Excerpt_form() 
{

    echo '<input
            name="reference_knb_category_excerpt"
            id="reference_knb_category_excerpt"
            type="number"
            class="small-text"
            min="15"
            placeholder="15"
            value="' .
                esc_attr(
                    absint(
                        get_option('reference_knb_category_excerpt')
                    )
                ) .
            '"
        >';
    echo '<p class="description">' .
            esc_html__(
                'This option allows you to change the maximum characters
            for the category description.',
                'reference'
            ) .
        ' </p>';

    return;
}
