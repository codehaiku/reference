<?php
/**
 * This class executes during plugin activation to set the default value for the
 * Reference Settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Activator
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
 * Set the default value for the Reference Settings inside
 * Settings > Reference
 *
 * @category Reference\Activator
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */

class Activator
{
    /**
     * Set default value for the Reference Settings
     * during the plugin activation if the options
     * are empty
     *
     * @return void
     */
    public function activate()
    {
        $post_type = new \DSC\Reference\PostType();
        add_image_size('reference-knowledgebase-thumbnail', 550, 550, true);

        $post_type->registerPostTypeAndTaxonomies();
        flush_rewrite_rules();
        return;
    }
}
