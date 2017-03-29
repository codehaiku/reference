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
function reference_knb_category_excerpt_form() {

    echo '<input name="reference_knb_category_excerpt" id="reference_knb_category_excerpt" type="number" class="small-text" min="15" placeholder="15" value="' . esc_attr(absint(get_option('reference_knb_category_excerpt'))) . '">';
    echo '<p class="description">' . esc_html__('This option allows you to change the maximum characters for the category description.', 'reference') . ' </p>';

	return;
}
