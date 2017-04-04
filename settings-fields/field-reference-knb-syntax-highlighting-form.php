<?php
/**
 * This function handles the Syntax Highlighting Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\reference_knb_syntax_highlighting_form
 * @package  Reference\reference_knb_syntax_highlighting_form
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
 * Callback function for 'reference_knb_syntax_highlighting' setting
 *
 * @return void
 */
function reference_knb_syntax_highlighting_form()
{

    echo '<label for="reference_knb_syntax_highlighting">';
        echo '<input
                name="reference_knb_syntax_highlighting"
                id="reference_knb_syntax_highlighting"
                type="checkbox"
                class="regular-text code"
                value="1" ' .
                checked(
                    1,
                    absint(
                        esc_attr(
                            get_option(
                                'reference_knb_syntax_highlighting'
                            )
                        )
                    ),
                    false
                ) .
            '>';
        esc_html_e('Enable Syntax Highlighting', 'reference');
    echo '</label>';

    echo '<p class="description">' .
            esc_html__(
                'This option allows you to enable the syntax
            highlightning for your displayed code snippets.',
                'reference'
            ) .
        ' </p>';

    return;
}
