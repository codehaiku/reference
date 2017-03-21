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
 * @category Reference\Admin
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
class Admin
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

    /**
     * Reference settings class constructor
     */
	public function __construct( $name, $version, $loader )
    {
		$this->name = $name;
		$this->version = $version;
		$this->loader = $loader;

        add_action('admin_menu', array( $this, 'referenceSettingsMenu' ));

        add_action('admin_init', array( $this, 'referenceRegisterSettings' ));
	}

    public function enqueue_scripts()
    {
		wp_enqueue_script( $this->name, plugin_dir_url( dirname(__FILE__) ) . 'assets/js/reference-admin.js', array( 'jquery' ), $this->version, FALSE );
	}

    /**
     * Display 'Reference' link under 'Settings'
     *
     * @return void
     */
    public function referenceSettingsMenu()
    {

        add_options_page(
            esc_html__( 'Reference Settings', 'reference' ),
            esc_html__( 'Reference', 'reference' ),
			'manage_options', 'reference_settings',
			array($this, 'referenceSettingsPage')
		);

        return;
    }

    /**
     * Registers all settings related to Reference.
     *
     * @return void
     */
    public function referenceRegisterSettings()
    {

        // Register archive slug section.
        add_settings_section(
            'reference-archive-slug-section', esc_html__('Knowledgebase Archive Slug', 'reference'),
            array( $this, 'archiveSlugCallback' ), 'reference-settings-section'
        );

        // Register archive name section.
        add_settings_section(
            'reference-archive-name-section', esc_html__('Knowledgebase Archive Name', 'reference'),
            array( $this, 'archiveNameCallback' ), 'reference-settings-section'
        );

        // Register content option section.
        add_settings_section(
            'reference-content-option-section', esc_html__('Knowledgebase Content Option', 'reference'),
            array( $this, 'contentOptiontCallback' ), 'reference-settings-section'
        );


        // Register the fields.
        $fields = array(
            array(
                'id' => 'reference_knb_slug',
                'label' => esc_html__('Slug', 'reference'),
                'callback' => 'reference_knb_slug_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-slug-section',
            ),
            array(
                'id' => 'reference_knb_category_slug',
                'label' => esc_html__('Category Slug', 'reference'),
                'callback' => 'reference_knb_category_slug_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-slug-section',
            ),
            array(
                'id' => 'reference_knb_tag_slug',
                'label' => esc_html__('Tag Slug', 'reference'),
                'callback' => 'reference_knb_tag_slug_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-slug-section',
            ),

            array(
                'id' => 'reference_knb_singular',
                'label' => esc_html__('Singular', 'reference'),
                'callback' => 'reference_knb_singular_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),
            array(
                'id' => 'reference_knb_plural',
                'label' => esc_html__('Plural', 'reference'),
                'callback' => 'reference_knb_plural_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),
            array(
                'id' => 'reference_knb_category_singular',
                'label' => esc_html__('Category Singular', 'reference'),
                'callback' => 'reference_knb_category_singular_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),
            array(
                'id' => 'reference_knb_category_plural',
                'label' => esc_html__('Category Plural', 'reference'),
                'callback' => 'reference_knb_category_plural_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),
            array(
                'id' => 'reference_knb_tag_singular',
                'label' => esc_html__('Tag Singular', 'reference'),
                'callback' => 'reference_knb_tag_singular_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),
            array(
                'id' => 'reference_knb_tag_plural',
                'label' => esc_html__('Tag Plural', 'reference'),
                'callback' => 'reference_knb_tag_plural_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),

            array(
                'id' => 'reference_knb_archive_column',
                'label' => esc_html__('Columns', 'reference'),
                'callback' => 'reference_knb_archive_column_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_syntax_highlighting',
                'label' => esc_html__('Syntax Highlighting', 'reference'),
                'callback' => 'reference_knb_syntax_highlighting_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_syntax_highlighting_style',
                'label' => esc_html__('Syntax Highlighting Style', 'reference'),
                'callback' => 'reference_knb_syntax_highlighting_style_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_comment_feedback',
                'label' => esc_html__('Comment Feedback', 'reference'),
                'callback' => 'reference_knb_comment_feedback_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_toc',
                'label' => esc_html__('Table of Contents', 'reference'),
                'callback' => 'reference_knb_toc_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_sticky_kit',
                'label' => esc_html__('Sticky Table of Contents', 'reference'),
                'callback' => 'reference_knb_sticky_kit_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_breadcrumbs',
                'label' => esc_html__('BreadCrumbs', 'reference'),
                'callback' => 'reference_knb_breadcrumbs_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_breadcrumbs_separator',
                'label' => esc_html__('BreadCrumbs Separator', 'reference'),
                'callback' => 'reference_knb_breadcrumbs_separator_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_category_excerpt',
                'label' => esc_html__('Category Excerpt', 'reference'),
                'callback' => 'reference_knb_category_excerpt_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),

        );

        foreach ( $fields as $field ) {

            add_settings_field(
                $field['id'], $field['label'],
                $field['callback'], $field['section'],
                $field['group']
            );

            register_setting('reference-settings-group', $field['id']);

            $file = str_replace('_', '-', $field['callback']);

            include_once trailingslashit(REFERENCE_DIR_PATH) .
            'settings-fields/field-' . sanitize_title($file) . '.php';

        }

        return;
    }

    /**
     * Callback function for the first Section.
     *
     * @return void
     */
    public function archiveSlugCallback()
    {
        echo esc_html_e(
            'All settings related to the
        	slug of the knowledgebase archive pages.', 'reference'
        );
        return;
    }

    /**
     * Callback function for the second Section.
     *
     * @return void
     */
    public function archiveNameCallback()
    {
        echo esc_html_e(
            'All settings related to the
        	name of the knowledgebase archive pages.', 'reference'
        );
        return;
    }

    /**
     * Callback function for the third Section.
     *
     * @return void
     */
    public function contentOptiontCallback()
    {
        echo esc_html_e(
            'All settings related to the
        	content of knowledgebase pages.', 'reference'
        );
        return;
    }

    /**
     * Renders the 'wrapper' for our options pages.
     *
     * @return void
     */
    public function referenceSettingsPage()
    {
        ?>

        <div class="wrap">
            <h2>
                <?php esc_html_e('Reference Settings', 'reference'); ?>
             </h2>
             <form id="reference-settings-form" action="options.php" method="POST">
                <?php settings_fields('reference-settings-group'); ?>
                <?php do_settings_sections('reference-settings-section'); ?>
                <?php submit_button(); ?>
             </form>
        </div>

        <?php
    }
}
