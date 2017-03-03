<?php
/**
 * This file is part of the Reference WordPress Knowledgebase Plugin Package.
 *
 * (c) Joseph Gabito <joseph@useissuestabinstead.com>
 * (c) Jasper Jardin <jasper@useissuestabinstead.com>
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
 * Callback function for 'reference_knb_singular' setting
 *
 * @return void
 */
function reference_knb_singular_form() {

    echo '<input name="reference_knb_singular" id="reference_knb_singular" type="text" class="regular-text code" maxlength="80" value="' . esc_attr( get_option( 'reference_knb_singular' ) ) . '">';
    echo '<p class="description">' . esc_html__('This option allows you to change the singular name of your knowledgebase archive page.', 'reference') . ' </p>';

	return;
}
