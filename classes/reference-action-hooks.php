<?php
/**
 * This class is executes during plugin activation.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\ActionHooks
 * @package  Reference WordPress Knowledgebase
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference-wordpress-knowledgebase
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 * @since    1.0
 */

namespace DSC\Reference;

 if ( ! defined( 'ABSPATH' ) ) {
     return;
 }

final class ActionHooks
{
    public function __construct()
    {
        add_action('reference_has_table_of_content_before', array( $this, 'reference_has_table_of_content_before_callback'), 10, 2);
        add_action('reference_has_table_of_content_after', array( $this, 'reference_has_table_of_content_after_callback'), 10, 2);

        add_action('reference_single_content_before', array( $this, 'reference_single_content_before_callback'), 10, 2);
        add_action('reference_single_content_after', array( $this, 'reference_single_content_after_callback'), 10, 2);

    }
    public function reference_has_table_of_content_before_callback() {

        $table_of_content_setting = Helper::get_table_of_content_setting();
        if (!empty($table_of_content_setting) && (bool)get_option('reference_knb_toc') === true) {

            echo '<div class="reference-has-table-of-content">';
                echo '<div class="reference-menu-container">';
                \DSC\Reference\Helper::table_of_content();
                echo '</div>';
        }

    }
    public function reference_has_table_of_content_after_callback() {

        $table_of_content_setting = Helper::get_table_of_content_setting();
        if (!empty($table_of_content_setting) && (bool)get_option('reference_knb_toc') === true) {
            echo '</div>';
        }

    }
    public function reference_single_content_before_callback() {

        $table_of_content_setting = Helper::get_table_of_content_setting();
        if (!empty($table_of_content_setting) && (bool)get_option('reference_knb_toc') === true) {

            echo '<div class="reference-single-content">';
        }

    }
    public function reference_single_content_after_callback() {

        $table_of_content_setting = Helper::get_table_of_content_setting();
        if (!empty($table_of_content_setting) && (bool)get_option('reference_knb_toc') === true) {

            echo '</div>';
        }

    }
}
