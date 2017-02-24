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

class ReferenceActivator
{

	public static function activate()
    {
		$options = array(
				'title'				=>	'Knowledgebase',
				'all_text'			=>	'View all %s articles',
				'singular'			=>	'Knowledgebase',
				'plural'			=>	'Knowledgebase',
				'category'			=>	'Category',
				'category_plural'	=>	'Categories',
				'slug'				=>	'knowledgebase',
				'cat_slug'			=>	'dsc-knb-categories',
				'override_category'	=>	'1',
				'override_single'	=>	'1',
				'override_search'	=>	'1',
			);
	}

}
