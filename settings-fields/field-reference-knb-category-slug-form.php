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
 * Callback function for 'reference_knb_category_slug' setting
 *
 * @return void
 */
function reference_knb_category_slug_form() {

    echo '<input name="reference_knb_category_slug" id="reference_knb_category_slug" type="text" class="regular-text code" maxlength="80" value="' . esc_attr( trim( get_option( 'reference_knb_category_slug' ) ) )  . '">';
    echo '<p class="description">' . esc_html__('This option allows you to change the slug of your taxonomy category archive page.', 'reference') . ' </p>';

	return;
}
