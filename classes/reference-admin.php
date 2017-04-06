<?php
/**
 * This class executes in the Loader class to enqueue scripts and initialize
 * the Reference settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Admin
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
 * This class handles the WordPress dashboard funtionality.
 *
 * @category Reference\Admin
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */
class Admin
{
    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $reference_name    The ID of this plugin.
     */
    private $reference_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $reference_version    The current version of this plugin.
     */
    private $reference_version;

    /**
     * Initialize the class and set its properties.
     *
     * @since  1.0.0
     * @access public
     * @var    string    $name       The name of this plugin.
     * @var    string    $version    The version of this plugin.
     */
    public $loader;

    /**
     * Attach the Reference Settings to the Settings API of WordPress.
     * Initialize the value for the class properties.
     *
     * @param string $reference_name    The ID of this plugin.
     * @param int    $reference_version The version of this plugin.
     * @param string $loader             Initialize the class and set its properties.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function __construct($reference_name, $reference_version, $loader)
    {
        $this->name = $reference_name;
        $this->version = $reference_version;
        $this->loader = $loader;

        add_action(
            'admin_menu',
            array(
                $this,
                'referenceSettingsMenu'
            )
        );

        add_action(
            'admin_init',
            array(
                $this,
                'referenceRegisterSettings'
            )
        );
        return;
    }
    /**
     * Enqueue the reference-admin.js file to the WordPress Admin
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function enqueueScripts()
    {
        wp_enqueue_script(
            $this->name,
            plugin_dir_url(dirname(__FILE__)) . 'assets/js/reference-admin.js',
            array( 'jquery' ),
            $this->version,
            false
        );
        return;
    }
    /**
     * Display 'Reference' link under 'Settings'
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function referenceSettingsMenu()
    {
        add_options_page(
            esc_html__(
                'Reference Settings',
                'reference'
            ),
            esc_html__(
                'Reference',
                'reference'
            ),
            'manage_options',
            'reference_settings',
            array(
                $this,
                'referenceSettingsPage'
            )
        );
        return;
    }
    /**
     * Registers all settings related to Reference.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function referenceRegisterSettings()
    {
        // Register archive slug section.
        add_settings_section(
            'reference-archive-slug-section',
            esc_html__(
                'Knowledgebase Archive Slug',
                'reference'
            ),
            array(
                $this,
                'archiveSlugCallback'
            ),
            'reference-settings-section'
        );

        // Register archive name section.
        add_settings_section(
            'reference-archive-name-section',
            esc_html__(
                'Knowledgebase Archive Name',
                'reference'
            ),
            array(
                $this,
                'archiveNameCallback'
            ),
            'reference-settings-section'
        );

        // Register content option section.
        add_settings_section(
            'reference-content-option-section',
            esc_html__(
                'Knowledgebase Content Option',
                'reference'
            ),
            array(
                $this,
                'contentOptiontCallback'
            ),
            'reference-settings-section'
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
            array(
                'id' => 'reference_knb_posts_per_page',
                'label' => esc_html__('Posts per Page', 'reference'),
                'callback' => 'reference_knb_posts_per_page_form',
                'section' => 'reference-settings-section',
                'group' => 'reference-content-option-section',
            ),

        );

        foreach ($fields as $field) {
            add_settings_field(
                $field['id'],
                $field['label'],
                $field['callback'],
                $field['section'],
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
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function archiveSlugCallback()
    { ?>
        <p>
            <?php
            esc_html_e(
                'All settings related to the slug of the knowledgebase
                archive pages.',
                'reference'
            );
            ?>
        </p>
        <p>
            <?php
            esc_html_e(
                'You need to update or save the “permalink” settings if you
                had change this option.',
                'reference'
            );
            ?>
        </p>

        <?php
        return;
    }
    /**
     * Callback function for the second Section.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function archiveNameCallback()
    { ?>
        <p>
            <?php
            esc_html_e(
                'All settings related to the name of the knowledgebase archive
                pages.',
                'reference'
            );
            ?>
        </p>

        <?php
        return;
    }
    /**
     * Callback function for the third Section.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function contentOptiontCallback()
    { ?>
        <p>
            <?php
            esc_html_e(
                'All settings related to the content of knowledgebase pages.',
                'reference'
            );
            ?>
        </p>

        <?php
        return;
    }
    /**
     * Renders the 'wrapper' for our options pages.
     *
     * @since  1.0.0
     * @access public
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
        return;
    }
}
