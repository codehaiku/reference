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
 * @category Reference\reference_knb_syntax_highlighting_style_form
 * @package  Reference\reference_knb_syntax_highlighting_style_form
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
 * Callback function for 'reference_knb_syntax_highlighting_style' setting
 *
 * @return void
 */
function reference_knb_syntax_highlighting_style_form()
{
    $styles = reference_get_syntax_highlighting_style();
    $option = new DSC\Reference\Options();
    $syntax_highlighting_style = $option->getSyntaxHighlightingStyle();
    ?>

    <select name="reference_knb_syntax_highlighting_style" class="reference_select" id="reference_knb_syntax_highlighting_style">
        <?php foreach ($styles as $style) { ?>
            <option value="<?php esc_attr_e($style); ?>" <?php selected(esc_attr($syntax_highlighting_style), $style); ?>>
                <?php esc_html_e(ucfirst($style)); ?>
            </option>
        <?php } ?>
    </select>

    <?php esc_html_e(' Select the highlightning style for displayed codes.', 'reference'); ?>

    <p class="description">
        <?php esc_html_e('This option allows you to change the style for displaying your codes your [reference_highlighter] shortcode.', 'reference'); ?>
    </p>

    <?php
    return;
}
