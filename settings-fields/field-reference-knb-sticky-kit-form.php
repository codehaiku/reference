<?php
/**
 * This function handles the Sticky Kit Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\reference_knb_sticky_kit_form
 * @package  Reference\reference_knb_sticky_kit_form
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
 * Callback function for 'reference_knb_sticky_kit' setting
 *
 * @return void
 */
function reference_knb_sticky_kit_form()
{

    echo '<label for="reference_knb_sticky_kit">';
        echo '<input
                name="reference_knb_sticky_kit"
                id="reference_knb_sticky_kit"
                type="checkbox"
                class="regular-text code"
                value="1" ' .
                checked(
                    1,
                    absint(esc_attr(get_option('reference_knb_sticky_kit'))),
                    false
                ) .
            '>';
        esc_html_e('Enable Sticky Table of Contents', 'reference');
    echo '</label>';

    echo '<p class="description">' .
            esc_html__(
                'This option allows you to enable sticky Table of
            Contents for your single knowledgebase pages.',
                'reference'
            ) .
        ' </p>';

    return;
}
