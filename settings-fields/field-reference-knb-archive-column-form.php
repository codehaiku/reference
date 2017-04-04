<?php
/**
 * This function handles the Archive Column Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\reference_knb_archive_column_form
 * @package  Reference\reference_knb_archive_column_form
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
 * Callback function for 'reference_knb_archive_column' setting
 *
 * @return void
 */
function reference_knb_archive_column_form()
{
    echo '<select
            name="reference_knb_archive_column"
            class="reference_select"
            id="reference_knb_archive_column"
        >';
        echo '<option
                value="1" ' .
                selected(
                    absint(
                        esc_attr(
                            get_option('reference_knb_archive_column')
                        )
                    ),
                    1
                ) .
            '>1</option>';
        echo '<option
                value="2" ' .
                selected(
                    absint(
                        esc_attr(
                            get_option('reference_knb_archive_column')
                        )
                    ),
                    2
                ) .
                '>2</option>';
        echo '<option
                value="3" ' .
                selected(
                    absint(
                        esc_attr(
                            get_option('reference_knb_archive_column')
                        )
                    ),
                    3
                ) .
                '>3</option>';
    echo '</select>';

    esc_html_e(' Select number of columns.', 'reference');

    echo '<p class="description">' .
            esc_html__(
                'This option allows you to change the columns for
                your articles in knowledgebase archive page.',
                'reference'
            ) .
        '</p>';
    return;
}
