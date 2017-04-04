<?php
/**
 * This function handles the Category Singular Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\reference_knb_category_singular_form
 * @package  Reference\reference_knb_category_singular_form
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
/**
 * Callback function for 'reference_knb_category_singular' setting
 *
 * @return void
 */
function reference_knb_category_singular_form()
{

    echo '<input
            name="reference_knb_category_singular"
            id="reference_knb_category_singular"
            type="text"
            class="regular-text code"
            maxlength="80"
            value="' .
                esc_attr(get_option('reference_knb_category_singular')) .
            '"
        >';
    echo '<p class="description">' .
            esc_html__(
                'This option allows you to change the singular name of
            your knowledgebase category archive page.',
                'reference'
            ) .
        ' </p>';

    return;
}
