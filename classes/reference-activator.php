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
        add_image_size('reference-knowledgebase-thumbnail', 550, 550, true);

        $options = array(
            'reference_knb_slug' => 'dsc-knowledgebase',
            'reference_knb_category_slug' => 'dsc-knb-categories',
            'reference_knb_tag_slug' => 'dsc-knb-tags',
            'reference_knb_singular' => 'Knowledgebase',
            'reference_knb_plural' => 'Knowledgebase',
            'reference_knb_category_singular' => 'Knowledgebase Category',
            'reference_knb_category_plural' => 'Knowledgebase Categories',
            'reference_knb_tag_singular' => 'Knowledgebase Tag',
            'reference_knb_tag_plural' => 'Knowledgebase Tags',
            'reference_knb_archive_column' => '3',
            'reference_knb_syntax_highlighting' => true,
            'reference_knb_syntax_highlighting_style' => 'dark',
            'reference_knb_comment_feedback' => true,
            'reference_knb_toc' => true,
            'reference_knb_breadcrumbs' => true,
            'reference_knb_sticky_kit' => true,
            'reference_knb_breadcrumbs_separator' => '/',
            'reference_knb_category_excerpt' => '55',
            'reference_knb_posts_per_page' => '10',
        );
        foreach ($options as $key => $value) {
            if (get_option($key) == false) {
                update_option($key, $value);
            }
        }
        flush_rewrite_rules();
        return;
    }
}
