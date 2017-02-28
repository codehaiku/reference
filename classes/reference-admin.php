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
        global $dsc_knb;

		$this->name = $name;
		$this->version = $version;
		$this->loader = $loader;
        $this->opts = $dsc_knb;
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

        $options = array(
            'dsc_knb_slug'	                =>	'dsc-knowledgebasessssss',
            'dsc_knb_category_slug'         =>	'dsc-knb-categoriesss',
            'dsc_knb_tag_slug'              =>	'dsc-knb-tagssss',

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
        update_option('dsc_knb_settings', serialize($options));
    }

    public function reference_on_load_settings()
    {
        if(isset($_POST['reference_action']) && $_POST['reference_action'] == 'save_reference_settings_page'){
			$postdata = serialize($_POST['dsc_knb']);
			// $formdata = unserialize($formdata);
			update_option('dsc_knb_settings', $postdata);
			$this->opts = unserialize(get_option('dsc_knb_settings'));
		}
    }
	public function reference_settings_page()
    {
        $dsc_knb_settings = array('dsc_knb_slug', 'dsc_knb_category_slug', 'dsc_knb_tag_slug', 'dsc_knb_singular', 'dsc_knb_plural', 'dsc_knb_category_singular', 'dsc_knb_category_plural', 'dsc_knb_tag_singular', 'dsc_knb_tag_plural', 'dsc_knb_archive_column', 'dsc_knb_syntax_highlighting', 'dsc_knb_comment_feedback', 'dsc_knb_toc', 'dsc_knb_breadcrumbs');

        foreach ($dsc_knb_settings as $value) {
            if(isset($this->opts[$value]) && !empty($this->opts[$value])){
                $$value = $this->opts[$value];
            }
        } ?>


        <div id="howto-metaboxes-general" class="wrap">

			<h1><?php esc_html_e('Reference Settings', 'reference');?></h1>

            <form action="<?php esc_attr_e( str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) ); ?>" method="post">

				<?php wp_nonce_field('reference-settings-page'); ?>

				<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>

				<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>

				<input type="hidden" name="reference_action" value="save_reference_settings_page" />

                <h2 class="title"><?php esc_html_e('Archive Slugs', 'reference');?></h2>

                <table class="form-table reference-settings-list">
                	<tbody>
                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_knowledgebase_slug"><?php esc_html_e('Knowledgebase Slug:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="reference_knowledgebase_slug" id="reference_knowledgebase_slug" type="text" class="regular-text code" maxlength="80" value="<?php echo $dsc_knb_slug; ?>">
                                <p class="description"><?php esc_html_e('This option allows you to change the slug of your knowledgebase archive page.', 'reference'); ?></p>
                                <p class="description"><?php esc_html_e('If you change this option, you might have to update or save the "permalink" settings again.', 'reference'); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_knowledgebase_category_slug"><?php esc_html_e('Knowledgebase Category Slug:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="reference_knowledgebase_category_slug" id="reference_knowledgebase_category_slug" type="text" class="regular-text code" maxlength="80" value="<?php echo $dsc_knb_category_slug; ?>">
                                <p class="description"><?php esc_html_e('This option allows you to change the slug of your knowledgebase category archive page.', 'reference'); ?></p>
                                <p class="description"><?php esc_html_e('If you change this option, you might have to update or save the "permalink" settings again.', 'reference'); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_knowledgebase_tag_slug"><?php esc_html_e('Knowledgebase Tag Slug:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="reference_knowledgebase_tag_slug" id="reference_knowledgebase_tag_slug" type="text" class="regular-text code" maxlength="80" value="<?php echo $dsc_knb_tag_slug; ?>">
                                <p class="description"><?php esc_html_e('This option allows you to change the slug of your knowledgebase category archive page.', 'reference'); ?></p>
                                <p class="description"><?php esc_html_e('If you change this option, you might have to update or save the "permalink" settings again.', 'reference'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h2 class="title"><?php esc_html_e('Archive Titles', 'reference');?></h2>

                <table class="form-table reference-settings-list">
                	<tbody>
                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_knowledgebase_singular"><?php esc_html_e('Singular Name:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="reference_knowledgebase_singular" id="reference_knowledgebase_singular" type="text" class="regular-text code" maxlength="80" value="<?php echo $dsc_knb_singular; ?>">
                                <p class="description"><?php esc_html_e('This option allows you to change the singular name of your knowledgebase archive page.', 'reference'); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_knowledgebase_plural"><?php esc_html_e('Plural  Name:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="reference_knowledgebase_plural" id="reference_knowledgebase_plural" type="text" class="regular-text code" maxlength="80" value="<?php echo $dsc_knb_plural; ?>">
                                <p class="description"><?php esc_html_e('This option allows you to change the plural name of your knowledgebase archive page.', 'reference'); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_knowledgebase_category_singular"><?php esc_html_e('Category Singular Name:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="reference_knowledgebase_category_singular" id="reference_knowledgebase_category_singular" type="text" class="regular-text code" maxlength="80" value="<?php echo $dsc_knb_category_singular; ?>">
                                <p class="description"><?php esc_html_e('This option allows you to change the singular name of your knowledgebase category archive page.', 'reference'); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_knowledgebase_category_plural"><?php esc_html_e('Category Plural  Name:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="reference_knowledgebase_category_plural" id="reference_knowledgebase_category_plural" type="text" class="regular-text code" maxlength="80" value="<?php echo $dsc_knb_category_plural; ?>">
                                <p class="description"><?php esc_html_e('This option allows you to change the plural name of your knowledgebase category archive page.', 'reference'); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_knowledgebase_tag_singular"><?php esc_html_e('Tag Singular Name:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="reference_knowledgebase_tag_singular" id="reference_knowledgebase_tag_singular" type="text" class="regular-text code" maxlength="80" value="<?php echo $dsc_knb_tag_singular; ?>">
                                <p class="description"><?php esc_html_e('This option allows you to change the singular name of your knowledgebase tag archive page.', 'reference'); ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_knowledgebase_tag_plural"><?php esc_html_e('Tag Plural  Name:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <input name="reference_knowledgebase_tag_plural" id="reference_knowledgebase_tag_plural" type="text" class="regular-text code" maxlength="80" value="<?php echo $dsc_knb_tag_plural; ?>">
                                <p class="description"><?php esc_html_e('This option allows you to change the plural name of your knowledgebase tag archive page.', 'reference'); ?></p>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <h2 class="title"><?php esc_html_e('Content Settings', 'reference');?></h2>

                <table class="form-table reference-settings-list">
                	<tbody>
                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_knowledgebase_columns"><?php esc_html_e('Knowledgebase Columns:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <label for="reference_column_select">
                                    <select name="reference[orderby]" class="reference_select" id="reference_knowledgebase_columns">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <?php esc_html_e('Select number of columns.', 'reference');?>
                                </label>
                                <p class="description"><?php esc_html_e('This option allows you to change the columns for your articles in knowledgebase archive page.', 'reference'); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_syntax_highlighting"><?php esc_html_e('Syntax Highlighting:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <label for="reference_syntax_highlighting">
                                    <input name="reference_syntax_highlighting" id="reference_syntax_highlighting" type="checkbox" class="regular-text code" value="<?php echo $dsc_knb_syntax_highlighting; ?>" checked="checked">
                                    <?php esc_html_e('Enable Syntax Highlighting', 'reference');?>
                                </label>
                                <p class="description"><?php esc_html_e('This option allows you to enable the syntax highlighter for your displayed code snippets.', 'reference'); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_enable_comments_feedback"><?php esc_html_e('Enable Comments Feedback:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <label for="reference_enable_comments_feedback">
                                    <input name="reference_enable_comments_feedback" id="reference_enable_comments_feedback" type="checkbox" class="regular-text code" value="<?php echo $dsc_knb_comment_feedback; ?>" checked="checked">
                                    <?php esc_html_e('Enable comments feedback', 'reference');?>
                                </label>
                                <p class="description"><?php esc_html_e('This option allows you to enable the comment feedback for your knowledgebase pages.', 'reference'); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_enable_toc"><?php esc_html_e('Enable Table of Contents:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <label for="reference_enable_toc">
                                    <input name="reference_enable_toc" id="reference_enable_toc" type="checkbox" class="regular-text code" value="<?php echo $dsc_knb_toc; ?>" checked="checked">
                                    <?php esc_html_e('Enable table of contents', 'reference');?>
                                </label>
                                <p class="description"><?php esc_html_e('This option allows you to enable the Table of Contents for your knowledgebase pages.', 'reference'); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
        					<th scope="row">
                                <label for="reference_enable_breadcrumbs"><?php esc_html_e('Enable BreadCrumbs:', 'reference'); ?></label>
                            </th>
                    		<td>
                                <label for="reference_enable_breadcrumbs">
                                    <input name="reference_enable_breadcrumbs" id="reference_enable_breadcrumbs" type="checkbox" class="regular-text code" value="<?php echo $dsc_knb_breadcrumbs; ?>" checked="checked">
                                    <?php esc_html_e('Enable BreadCrumbs', 'reference');?>
                                </label>
                                <p class="description"><?php esc_html_e('This option allows you to enable the BreadCrumbs for your knowledgebase pages.', 'reference'); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
        					<th scope="row">
                                <input type="submit" value="<?php esc_attr_e('Save Changes', 'reference'); ?>" class="button-primary btn" name="Submit">
                            </th>
        				</tr>
                    </tbody>
                </table>

			</form>
        </div>

	<?php }
}
