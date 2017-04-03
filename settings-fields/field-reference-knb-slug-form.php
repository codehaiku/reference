<?php
/**
 * This function handles the Knowledgebase Slug Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Reference_Knb_Slug_Form
 * @package  Reference\Reference_Knb_Slug_Form
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
 * Callback function for 'reference_knb_slug' setting
 *
 * @return void
 */
function Reference_Knb_Slug_form()
{

    echo '<input
            name="reference_knb_slug"
            id="reference_knb_slug"
            type="text"
            class="regular-text code"
            maxlength="80"
            value="' .
                esc_attr(trim(get_option('reference_knb_slug'))) .
            '"
        >';
    echo '<p class="description">' .
            esc_html__(
                'This option allows you to change the slug of your post
            archive page.',
                'reference'
            ) .
        ' </p>';

    return;
}
