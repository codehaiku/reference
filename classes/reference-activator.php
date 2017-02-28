<?php
/**
 * This class is executes during plugin activation.
 *
 * (c) Joseph Gabito <joseph@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Activator
 * @package  Reference WordPress Knowledgebase
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference-wordpress-knowledgebase
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 */

namespace DSC\Reference;

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

/**
 * Registers all the admin settings inside Settings > Subway
 *
 * @category Reference\Activator
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 * @since    1.0
 */

class Activator
{

    public static function activate()
    {
        $get_opts = get_option('dsc_knb_settings');

        $options = array(
            'dsc_knb_slug'	                =>	'dsc-knowledgebase',
            'dsc_knb_category_slug'         =>	'dsc-knb-categories',
            'dsc_knb_tag_slug'              =>	'dsc-knb-tags',

            'dsc_knb_singular'              =>	'Knowledgebase',
            'dsc_knb_plural'                =>	'Knowledgebase',
            'dsc_knb_category_singular'     =>	'Knowledgebase Category',
            'dsc_knb_category_plural'       =>	'Knowledgebase Categories',
            'dsc_knb_tag_singular'          =>	'Knowledgebase Tag',
            'dsc_knb_tag_plural'            =>	'Knowledgebase Tags',

            'dsc_knb_archive_column'        =>	'3',
            'dsc_knb_syntax_highlighting'   =>	true,
            'dsc_knb_comment_feedback'      =>	true,
            'dsc_knb_toc'                   =>	true,
            'dsc_knb_breadcrumbs'           =>	true,
        );

        if(empty($get_opts)){
            add_option('dsc_knb_settings', serialize($options));
        }
        // delete_option( 'dsc_knb_settings' );
    }

}
