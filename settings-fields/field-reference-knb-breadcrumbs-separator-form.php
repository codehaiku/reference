<?php
/**
 * This file is part of the Reference WordPress Knowledgebase Plugin Package.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Reference
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
/**
 * Callback function for 'reference_knb_category_singular' setting
 *
 * @return void
 */
function reference_knb_breadcrumbs_separator_form() {

    echo '<input name="reference_knb_breadcrumbs_separator" id="reference_knb_breadcrumbs_separator" type="text" class="regular-text code" maxlength="80" value="' . esc_attr( get_option( 'reference_knb_breadcrumbs_separator' ) ) . '">';
    echo '<p class="description">' . esc_html__('This option allows you to change the separator for your knowledgebase category and single knowledgebase page.', 'reference') . ' </p>';

	return;
}
