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
 * Callback function for 'reference_knb_breadcrumbs' setting
 *
 * @return void
 */
function reference_knb_breadcrumbs_form() {

    echo '<label for="reference_knb_breadcrumbs">';
        echo '<input name="reference_knb_breadcrumbs" id="reference_knb_breadcrumbs" type="checkbox" class="regular-text code" value="1" ' . checked( 1, intval( esc_attr( get_option( 'reference_knb_breadcrumbs' ) ) ), false ) . '>';
        esc_html_e('Enable Breadcrumbs', 'reference');
    echo '</label>';

    echo '<p class="description">' . esc_html__('This option allows you to enable the BreadCrumbs for your knowledgebase pages.', 'reference') . ' </p>';

	return;
}
