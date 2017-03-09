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

    public function enqueueScripts()
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
            __( 'Reference Settings', 'reference' ),
            __( 'Reference', 'reference' ),
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
            'reference-archive-slug-section', __('Archive Slug', 'reference'),
            array( $this, 'archiveSlugCallback' ), 'reference-settings-section'
        );

        // Register archive name section.
        add_settings_section(
            'reference-archive-name-section', __('Archive Name', 'reference'),
            array( $this, 'archiveNameCallback' ), 'reference-settings-section'
        );

        // Register content option section.
        add_settings_section(
            'reference-content-option-section', __('Content Option', 'reference'),
            array( $this, 'contentOptiontCallback' ), 'reference-settings-section'
        );


        // Register the fields.
        $fields = array(
            array(
                'id' => 'reference_knb_slug',
                'label' => __('Knowledgebase Slug', 'reference'),
                'callback' => 'reference_knb_slug_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-slug-section',
            ),
            array(
                'id' => 'reference_knb_category_slug',
                'label' => __('Knowledgebase Category Slug', 'reference'),
                'callback' => 'reference_knb_category_slug_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-slug-section',
            ),
            array(
                'id' => 'reference_knb_tag_slug',
                'label' => __('Knowledgebase Tag Slug', 'reference'),
                'callback' => 'reference_knb_tag_slug_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-slug-section',
            ),

            array(
                'id' => 'reference_knb_singular',
                'label' => __('Knowledgebase Singular', 'reference'),
                'callback' => 'reference_knb_singular_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),
            array(
                'id' => 'reference_knb_plural',
                'label' => __('Knowledgebase Plural', 'reference'),
                'callback' => 'reference_knb_plural_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),
            array(
                'id' => 'reference_knb_category_singular',
                'label' => __('Knowledgebase Category Singular', 'reference'),
                'callback' => 'reference_knb_category_singular_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),
            array(
                'id' => 'reference_knb_category_plural',
                'label' => __('Knowledgebase Category Plural', 'reference'),
                'callback' => 'reference_knb_category_plural_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),
            array(
                'id' => 'reference_knb_tag_singular',
                'label' => __('Knowledgebase Tag Singular', 'reference'),
                'callback' => 'reference_knb_tag_singular_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),
            array(
                'id' => 'reference_knb_tag_plural',
                'label' => __('Knowledgebase Tag Plural', 'reference'),
                'callback' => 'reference_knb_tag_plural_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-archive-name-section',
            ),

            array(
                'id' => 'reference_knb_archive_column',
                'label' => __('Knowledgebase Columns', 'reference'),
                'callback' => 'reference_knb_archive_column_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_syntax_highlighting',
                'label' => __('Knowledgebase Syntax Highlighting', 'reference'),
                'callback' => 'reference_knb_syntax_highlighting_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_comment_feedback',
                'label' => __('Knowledgebase Comment Feedback', 'reference'),
                'callback' => 'reference_knb_comment_feedback_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_toc',
                'label' => __('Knowledgebase Table of Contents', 'reference'),
                'callback' => 'reference_knb_toc_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),
            array(
                'id' => 'reference_knb_breadcrumbs',
                'label' => __('Knowledgebase BreadCrumbs', 'reference'),
                'callback' => 'reference_knb_breadcrumbs_form',
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
