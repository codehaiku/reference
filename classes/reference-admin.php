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
 * @category Reference\ReferenceAdmin
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
 * This class handles the WordPress dashboard funtionality.
 *
 * @category Reference\ReferenceAdmin
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 * @since    1.0
 */
class ReferenceAdmin
{
    /**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public $loader;

	public function __construct( $name, $version, $loader )
    {

		$this->name = $name;
		$this->version = $version;
		$this->loader = $loader;
		$this->notices = '';

        add_action( 'admin_menu', array( $this, 'reference_settings_menu' ) );
	}

    public function enqueue_scripts()
    {
		wp_enqueue_script( $this->name, plugin_dir_url( dirname(__FILE__) ) . 'assets/js/reference-admin.js', array( 'jquery' ), $this->version, FALSE );
	}

    public function reference_settings_menu()
    {
        add_options_page(
            esc_html__( 'Reference Settings', 'reference' ),
            esc_html__( 'Reference', 'reference' ),
			'manage_options',
			'reference_settings',
			array(
				$this,
				'reference_settings_page'
			)
		);
    }
	public function reference_settings_page()
    { ?>

        <div id="howto-metaboxes-general" class="wrap">

			<?php screen_icon('options-general'); ?>
			<h1><?php esc_html_e('Reference Settings', 'reference');?></h1>

            <form action="<?php esc_attr_e( str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) ); ?>" method="post">

				<?php wp_nonce_field('reference-settings-page'); ?>

				<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>

				<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>

				<input type="hidden" name="reference_action" value="save_reference_settings_page" />

                <table class="form-table reference-settings-list">
                	<tbody>
                        <tr>
                    		<th>
                                <label><?php esc_html_e('Knowledgebase Slug', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="knowledgebase_slug" id="knowledgebase_slug" type="text" class="regular-text code">
                            </td>
                        </tr>
                        <tr>
                    		<th>
                                <label><?php esc_html_e('Knowledgebase Category Slug', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="knowledgebase_category_slug" id="knowledgebase_category_slug" type="text" class="regular-text code">
                            </td>
                        </tr>
                        <tr>
                    		<th>
                                <label><?php esc_html_e('Knowledgebase Tag Slug', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="knowledgebase_tag_slug" id="knowledgebase_tag_slug" type="text" class="regular-text code">
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="form-table reference-settings-list">
                	<tbody>
                        <tr>
                    		<th>
                                <label><?php esc_html_e('Knowledgebase Slug', 'reference'); ?></label>
                            </th>
                    		<td>
                                <select name="reference[orderby]" class="reference_select widefat"> 
                                    <option value="1"><?php esc_html_e('1', 'reference');?></option>
                                    <option value="2"><?php esc_html_e('2', 'reference');?></option>
                                    <option value="3"><?php esc_html_e('3', 'reference');?></option>
                                </select>
                            </td>
                        </tr>

                    </tbody>
                </table>

			</form>
        </div>


	<?php }
}
