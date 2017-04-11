<?php
/**
 * This class is used to register Post Type and Taxonomies.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\PostType
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */

namespace DSC\Reference;

if (! defined('ABSPATH')) {
    return;
}
/**
 * This class is used to register Post Type and Taxonomies.
 *
 * @category Reference\PostType
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */
final class PostType
{


    /**
     * The loader that's responsible for maintaining and registering
     * all hooks that power the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string   $loader    Maintains and registers all
     *                               hooks for the plugin.
     */
    protected $loader;

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $name    The ID of this plugin.
     */
    private $name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

     /**
     * This method initialize the class and set its properties.
     * Attach all method below to their respective hooks.
     *
     * @param string  $name    The name of the plugin.
     * @param integer $version The version of this plugin.
     * @param string  $loader   The version of this plugin.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function __construct($name= '', $version = '', $loader = '')
    {

        $this->loader = $loader;

        $this->name = $name;

        $this->version = $version;

        add_action(
            'init',
            array(
                $this,
                'registerPostTypeAndTaxonomies'
            )
        );

        add_action(
            'knb-categories_add_form_fields',
            array(
                $this,
                'addReferenceCategoryImageSetting'
            ),
            10,
            2
        );

        add_action(
            'created_knb-categories',
            array(
                $this,
                'saveReferenceCategoryImage'
            ),
            10,
            2
        );

        add_action(
            'knb-categories_edit_form_fields',
            array(
                $this,
                'updateReferenceCategoryImageSetting'
            ),
            10,
            2
        );

        add_action(
            'edited_knb-categories',
            array(
                $this,
                'updateSanitizedReferenceCategoryImage'
            ),
            10,
            2
        );

        add_action(
            'admin_enqueue_scripts',
            array(
                $this,
                'addWpEnqueueMedia'
            )
        );
    }
    /**
    * This method register Reference Post Type and Taxonomies.
    *
    * @since  1.0.0
    * @access public
    * @return void
    */
    public function registerPostTypeAndTaxonomies()
    {
        $reference_singular_option = Options::getKnbSingular();
        $reference_plural_option = Options::getKnbPlural();
        $reference_slug_option = Options::getKnbSlug();

        $category_singular_option = Options::getCategorySingular();
        $category_plural_option = Options::getCategoryPlural();
        $category_slug_option = Options::getCategorySlug();

        $tag_singular_option = Options::getTagSingular();
        $tag_plural_option = Options::getTagPlural();
        $tag_slug_option = Options::getTagSlug();

        $post_type_labels = array(
            'name' => _x(
                $reference_plural_option,
                'post type general name',
                'reference'
            ),
            'singular_name' => _x(
                $reference_singular_option,
                'post type singular name',
                'reference'
            ),
            'menu_name' => _x(
                'Reference',
                'admin menu',
                'reference'
            ),
            'name_admin_bar' => _x(
                'Article',
                'add new on admin bar',
                'reference'
            ),
            'add_new' => _x(
                'Add New',
                'Article',
                'reference'
            ),
            'add_new_item' => esc_html__(
                'Add New Article',
                'reference'
            ),
            'new_item' => esc_html__(
                'New Article',
                'reference'
            ),
            'edit_item' => esc_html__(
                'Edit Article',
                'reference'
            ),
            'view_item' => esc_html__(
                'View Article',
                'reference'
            ),
            'all_items' => esc_html__(
                'All Articles',
                'reference'
            ),
            'search_items' => esc_html__(
                'Search Article',
                'reference'
            ),
            'parent_item_colon' => esc_html__(
                'Parent Article:',
                'reference'
            ),
            'not_found' => esc_html__(
                'No Articles found.',
                'reference'
            ),
            'not_found_in_trash' => esc_html__(
                'No Articles found in Trash.',
                'reference'
            )
        );

        $post_type_args = array(
            'labels'             => $post_type_labels,
            'description'        => esc_html__(
                'Description.',
                'reference'
            ),
            'public'             => true,
            'publicly_queryable' => true,
            'menu_icon'          => 'dashicons-book-alt',
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array(
                'slug' => $reference_slug_option
            ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array(
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
                'comments'
            )
        );

        register_post_type('dsc-knowledgebase', $post_type_args);

        $category_labels = array(
            'name' => _x(
                $category_plural_option,
                'taxonomy general name',
                'reference'
            ),
            'singular_name' => _x(
                $category_singular_option,
                'taxonomy singular name',
                'reference'
            ),
            'search_items' => esc_html__(
                'Search Topics',
                'reference'
            ),
            'all_items' => esc_html__(
                'All Topics',
                'reference'
            ),
            'parent_item' => esc_html__(
                'Parent Topic',
                'reference'
            ),
            'parent_item_colon' => esc_html__(
                'Parent Topic:',
                'reference'
            ),
            'edit_item' => esc_html__(
                'Edit Topic',
                'reference'
            ),
            'update_item' => esc_html__(
                'Update Topic',
                'reference'
            ),
            'add_new_item' => esc_html__(
                'Add New Topic',
                'reference'
            ),
            'new_item_name' => esc_html__(
                'New Topic Name',
                'reference'
            ),
            'menu_name' => esc_html__(
                'Topics',
                'reference'
            ),
        );

        $category_args = array(
            'hierarchical'      => true,
            'labels'            => $category_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => $category_slug_option),
        );

        register_taxonomy(
            'knb-categories',
            array('dsc-knowledgebase'),
            $category_args
        );

        $tag_labels = array(
            'name' => _x(
                $tag_plural_option,
                'taxonomy general name',
                'reference'
            ),
            'singular_name' => _x(
                $tag_singular_option,
                'taxonomy singular name',
                'reference'
            ),
            'search_items' => esc_html__(
                'Search Tags',
                'reference'
            ),
            'popular_items' => esc_html__(
                'Popular Tags',
                'reference'
            ),
            'all_items' => esc_html__(
                'All Tags',
                'reference'
            ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => esc_html__(
                'Edit Tag',
                'reference'
            ),
            'update_item' => esc_html__(
                'Update Tag',
                'reference'
            ),
            'add_new_item' => esc_html__(
                'Add New Tag',
                'reference'
            ),
            'new_item_name' => esc_html__(
                'New Tag Name',
                'reference'
            ),
            'separate_items_with_commas' => esc_html__(
                'Separate tag with commas',
                'reference'
            ),
            'add_or_remove_items' => esc_html__(
                'Add or remove tags',
                'reference'
            ),
            'choose_from_most_used' => esc_html__(
                'Choose from the most used tags',
                'reference'
            ),
            'not_found' => esc_html__(
                'No tags found.',
                'reference'
            ),
            'menu_name' => esc_html__(
                'Tags',
                'reference'
            ),
        );

        $tag_args = array(
            'hierarchical'          => false,
            'labels'                => $tag_labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array('slug' => $tag_slug_option),
        );

        register_taxonomy(
            'knb-tags',
            array('dsc-knowledgebase'),
            $tag_args
        );
    }
    /**
    * This method displays the category image setting.
    *
    * @param string $taxonomy The name of the taxonomy.
    *
    * @since  1.0.0
    * @access public
    * @return void
    */
    public function addReferenceCategoryImageSetting($taxonomy)
    {
    ?>
        <div class="form-field term-group">
            <label for="categories-image-id">
                <?php esc_html_e('Image', 'reference'); ?>
            </label>
            <input
                type="hidden"
                id="categories-image-id"
                name="categories-image-id"
                class="custom_media_url"
                value=""
            >
            <div id="categories-image-wrapper"></div>

            <p>
                <input
                    type="button"
                    class="button button-secondary reference_tax_media_button"
                    id="reference_tax_media_button"
                    name="reference_tax_media_button"
                    value="<?php esc_attr_e('Add Image', 'reference'); ?>"
                />
                <input
                    type="button"
                    class="button button-secondary reference_tax_media_remove"
                    id="reference_tax_media_remove"
                    name="reference_tax_media_remove"
                    value="<?php esc_attr_e('Remove Image', 'reference'); ?>"
                />
            </p>
        </div>
    <?php }

    /**
    * This method sanitized the date before saving.
    *
    * @param integer $term_id The taxonomy term ID.
    *
    * @since  1.0.0
    * @access public
    * @return void
    */
    public function saveReferenceCategoryImage($term_id)
    {
        $image = filter_input(
            INPUT_POST,
            'categories-image-id',
            FILTER_SANITIZE_NUMBER_INT
        );

        if (!empty($image)) {
            add_term_meta(
                $term_id,
                'categories-image-id',
                $image,
                true
            );
        }
        return;
    }
    /**
    * This method displays the category image update setting.
    *
    * @param object $term     Contains information of the current term.
    * @param string $taxonomy The name of the taxonomy.
    *
    * @since  1.0.0
    * @access public
    * @return void
    */
    public function updateReferenceCategoryImageSetting($term, $taxonomy)
    {
    ?>
        <tr class="form-field term-group-wrap">
            <th scope="row">
                <label for="categories-image-id">
                    <?php esc_html_e('Image', 'reference'); ?>
                </label>
            </th>
            <td>
                <?php $image_id = get_term_meta(
                    $term->term_id,
                    'categories-image-id',
                    true
                ); ?>
                <input
                    type="hidden"
                    id="categories-image-id"
                    name="categories-image-id"
                    value="<?php esc_attr_e($image_id); ?>"
                >
                <div id="categories-image-wrapper">
                    <?php if ($image_id) { ?>
                        <?php echo wp_get_attachment_image(
                            $image_id,
                            'thumbnail'
                        ); ?>
                    <?php } ?>
                </div>
                <p>
                    <input
                        type="button"
                        class="button button-secondary
                               reference_tax_media_button"
                       id="reference_tax_media_button"
                       name="reference_tax_media_button"
                       value="<?php esc_attr_e('Add Image', 'reference'); ?>"
                    />
                    <input
                        type="button"
                        class="button button-secondary
                               reference_tax_media_remove"
                       id="reference_tax_media_remove"
                       name="reference_tax_media_remove"
                       value="<?php esc_attr_e('Remove Image', 'reference'); ?>"
                    />
                </p>
            </td>
        </tr>
    <?php }

    /**
    * This method sanitized the date before updates the current term.
    *
    * @param integer $term_id Contains the ID of the current term.
    *
    * @since  1.0.0
    * @access public
    * @return void
    */
    public function updateSanitizedReferenceCategoryImage($term_id)
    {
        $image = filter_input(
            INPUT_POST,
            'categories-image-id',
            FILTER_SANITIZE_NUMBER_INT
        );

        if (!empty($image)) {
            update_term_meta(
                $term_id,
                'categories-image-id',
                $image
            );
        } else {
            update_term_meta(
                $term_id,
                'categories-image-id',
                ''
            );
        }
        return;
    }
    /**
    * Enqueues the wp_enqueue_media() to the Wordpress Dashboad.
    *
    * @since  1.0.0
    * @access public
    * @return void
    */
    public function addWpEnqueueMedia()
    {
        wp_enqueue_media();

        return;
    }
}
