<?php
/**
 * This function handles the Syntax Highlighting Style Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Reference_Knb_Syntax_Highlighting_Style_Form
 * @package  Reference\Reference_Knb_Syntax_Highlighting_Style_Form
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
 * Callback function for 'reference_knb_syntax_highlighting_style' setting
 *
 * @return void
 */
function Reference_Knb_Syntax_Highlighting_Style_form()
{

    $styles = Reference_Highlighting_style();

    echo '<select
            name="reference_knb_syntax_highlighting_style"
            class="reference_select"
            id="reference_knb_syntax_highlighting_style"
        >';
    foreach ($styles as $style) {
        echo '<option
                    value="' . $style . '" ' .
            selected(
                esc_attr(get_option('reference_knb_syntax_highlighting_style')),
                $style
            ) .
        '>' .
            ucfirst($style) .
        '</option>';
    }
    echo '</select>';

    esc_html_e(
        ' Select the highlightning style for displayed codes.',
        'reference'
    );

    echo '<p class="description">' .
            esc_html__(
                'This option allows you to change the style for
            displaying your codes your [reference_highlighter] shortcode.',
                'reference'
            ) .
        ' </p>';

    return;
}
