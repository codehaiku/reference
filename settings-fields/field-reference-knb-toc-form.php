<?php
/**
 * This function handles the Knowledgebase Table of Contents Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\reference_knb_toc_form
 * @package  Reference\reference_knb_toc_form
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
 * Callback function for 'reference_knb_toc' setting
 *
 * @return void
 */
function reference_knb_toc_form()
{

    echo '<label for="reference_knb_toc">';
        echo '<input
                name="reference_knb_toc"
                id="reference_knb_toc"
                type="checkbox"
                class="regular-text code"
                value="1" ' .
                checked(
                    1,
                    absint(esc_attr(get_option('reference_knb_toc'))),
                    false
                ) .
            '>';
        esc_html_e('Enable Table of Contents', 'reference');
    echo '</label>';

    echo '<p class="description">' .
            esc_html__(
                'This option allows you to enable the Table of Contents
            for your knowledgebase pages.',
                'reference'
            ) .
        ' </p>';

    return;
}
