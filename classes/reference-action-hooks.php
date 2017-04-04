<?php
/**
 * This class is executes during single knowledgebase pages
 * to contain if the content has table of contents
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\ActionHooks
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */

namespace DSC\Reference;

if (! defined('ABSPATH')) {
    return;
}
/**
 * Attach all Reference action hooks to the following
 * class methods listed in __construct.
 *
 * @category Reference\ActionHooks
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 */
final class ActionHooks
{
    /**
     * Attach all Reference action hooks to the following
     * class methods listed in __construct.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function __construct()
    {
        add_action(
            'reference_has_table_of_content_before',
            array( $this, 'tableOfContentBeforeCallback' ),
            10,
            2
        );
        add_action(
            'reference_has_table_of_content_after',
            array( $this, 'tableOfContentAfterCallback' ),
            10,
            2
        );

        add_action(
            'reference_single_content_before',
            array( $this, 'singleContentBeforeCallback' ),
            10,
            2
        );
        add_action(
            'reference_single_content_after',
            array( $this, 'singleContentAfterCallback' ),
            10,
            2
        );
    }
    /**
     * Returns the opening tag for main container for the Table of Contents
     * and the Knowledgebase content
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function tableOfContentBeforeCallback()
    {
        if (true === self::isTocEnabled()) {
            echo '<div class="reference-has-table-of-content">';
            echo '<div class="reference-menu-container">';
                Helper::getTableOfContentMenu();
            echo '</div>';
        }
        return;
    }
    /**
     * Returns the closing tag for main container for the Table of Contents
     * and the Knowledgebase content
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function tableOfContentAfterCallback()
    {
        if (true === self::isTocEnabled()) {
            echo '</div>';
        }
        return;
    }
    /**
     * Returns the opening tag for single content with Table of Contents
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function singleContentBeforeCallback()
    {
        if (true === self::isTocEnabled()) {
            echo '<div class="reference-single-content">';
        }
        return;
    }
    /**
     * Returns the closing tag for single content with Table of Contents
     *
     * @since  1.0.0
     * @access public
     * @return string|null Closing tag for single content with Table of Contents
     */
    public function singleContentAfterCallback()
    {
        if (true === self::isTocEnabled()) {
            echo '</div>';
        }
        return;
    }
    /**
     * Check if the Table of Contents setting is enable
     * or the Knowledgebase has menu
     *
     * @since  1.0.0
     * @access public
     * @return boolean|true if setting is enabled
     */
    public function isTocEnabled()
    {
        $table_of_content_setting = Helper::getTableOfContentSetting();
        $table_of_content_option = Options::getTableOfContent();
        $setting = false;

        if (! empty($table_of_content_setting)
            && true === (bool) $table_of_content_option
            && is_nav_menu($table_of_content_setting)
        ) {
            $setting = true;
        }
        return $setting;
    }
}
