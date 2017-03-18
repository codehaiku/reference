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
 * Callback function for 'reference_knb_comment_feedback' setting
 *
 * @return void
 */
function reference_knb_comment_feedback_form() {

    echo '<label for="reference_knb_comment_feedback">';
        echo '<input name="reference_knb_comment_feedback" id="reference_knb_comment_feedback" type="checkbox" class="regular-text code" value="1" ' . checked( 1, intval( esc_attr( get_option( 'reference_knb_comment_feedback' ) ) ), false ) . '>';
        esc_html_e('Enable Comment Feedback', 'reference');
    echo '</label>';

    echo '<p class="description">' . esc_html__('This option allows you to enable the comment feedbacks for your post pages.', 'reference') . ' </p>';

	return;
}
