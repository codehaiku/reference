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

function knb_category_thumbnail()
{
     $archive_thumbnail = new \DSC\Reference\Helper;

     echo $archive_thumbnail->the_category_thumbnail();
}
function knb_search_form()
{
    require_once plugin_dir_path( __FILE__ ) . '../templates/search-form.php';
}
function knb_child_categories()
{
    $child_category = new \DSC\Reference\Helper;

    echo $child_category->reference_display_knowledgebase_category_list();
}
