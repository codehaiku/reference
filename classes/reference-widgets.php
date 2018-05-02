<?php
/**
 * This class is executes the reference Widgets.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\KnowledgebaseWidgets
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference
 * @link     github.com/codehaiku/reference
 */

namespace DSC\Reference;

if (! defined('ABSPATH')) {
    return;
}

/**
 * This class handles the shortcode funtionality of the plugin.
 *
 * @category Reference\KnowledgebaseWidgets
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 * @since    1.0.1
 */
final class KnowledgebaseWidgets
{
    /**
     * Attach all Reference action hooks to the following
     * class methods listed in __construct to register the plugins shortcodes.
     *
     * @since  1.0.1
     * @access public
     * @return object $this Returns the current object.
     */
    public function __construct()
    {
        $widgets = array(
        		'recent-articles',
        		'most-upvoted-articles',
        		'related-articles',
        	);

        foreach ( $widgets as $widget ) {
        	require_once plugin_dir_path(dirname(__FILE__)) . '/widgets/' . $widget . '.php';
        }

    }


}
