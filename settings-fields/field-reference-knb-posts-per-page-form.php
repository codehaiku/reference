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
function reference_knb_posts_per_page_form() {

    echo '<input name="reference_knb_posts_per_page" id="reference_knb_posts_per_page" type="number" class="small-text" min="1" max="10" placeholder="10" value="' . absint(esc_attr(get_option('reference_knb_posts_per_page'))) . '">';
    echo '<p class="description">' . esc_html__('This option allows you to change the maximum knowledgebase to show in a page.', 'reference') . ' </p>';

	return;
}
