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
        add_action('reference_has_table_of_content_before', array( $this, 'tableOfContentBeforeCallback'), 10, 2);
        add_action('reference_has_table_of_content_after', array( $this, 'tableOfContentAfterCallback'), 10, 2);

        add_action('reference_single_content_before', array( $this, 'singleContentBeforeCallback'), 10, 2);
        add_action('reference_single_content_after', array( $this, 'singleContentAfterCallback'), 10, 2);

    }
    public function tableOfContentBeforeCallback()
    {

        $table_of_content_setting = Helper::get_table_of_content_setting();
        $table_of_content_option = Options::getTableOfContent();

        if (!empty($table_of_content_setting) && (bool) $table_of_content_option === true && is_nav_menu($table_of_content_setting)) {

            echo '<div class="reference-has-table-of-content">';
                echo '<div class="reference-menu-container">';
                Helper::table_of_content();
                echo '</div>';
        }

    }
    public function tableOfContentAfterCallback()
    {

        $table_of_content_setting = Helper::get_table_of_content_setting();
        $table_of_content_option = Options::getTableOfContent();

        if (!empty($table_of_content_setting) && (bool) $table_of_content_option === true && is_nav_menu($table_of_content_setting)) {
            echo '</div>';
        }

    }
    public function singleContentBeforeCallback()
    {

        $table_of_content_setting = Helper::get_table_of_content_setting();
        $table_of_content_option = Options::getTableOfContent();

        if (!empty($table_of_content_setting) && (bool) $table_of_content_option === true && is_nav_menu($table_of_content_setting)) {

            echo '<div class="reference-single-content">';
        }

    }
    public function singleContentAfterCallback()
    {

        $table_of_content_setting = Helper::get_table_of_content_setting();
        $table_of_content_option = Options::getTableOfContent();

        if (!empty($table_of_content_setting) && (bool) $table_of_content_option === true && is_nav_menu($table_of_content_setting)) {

            echo '</div>';
        }

    }
}
