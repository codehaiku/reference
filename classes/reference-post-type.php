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
 * @category Reference\Metabox
 * @package  Reference WordPress Knowledgebase
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference-wordpress-knowledgebase
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 * @since    1.0
 */

namespace DSC\Reference;

if (! defined('ABSPATH')) {
    return;
}

final class PostType
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string   $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

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
     * @var      string    $name       The name of the plugin.
     * @var      string    $version    The version of this plugin.
     */
    public function __construct($name, $version, $loader)
    {

        $this->loader = $loader;

        $this->name = $name;

        $this->version = $version;

        add_action('init', array($this, 'register_post_type_and_taxonomies'));

        add_action('knb-categories_add_form_fields', array($this, 'add_knb_categories_image'), 10, 2);

        add_action('created_knb-categories', array($this, 'save_knb_categories_image'), 10, 2);

        add_action('knb-categories_edit_form_fields', array($this, 'update_knb_categories_image'), 10, 2);

        add_action('edited_knb-categories', array($this, 'updated_knb_categories_image'), 10, 2);

        add_action('admin_enqueue_scripts', array($this, 'add_wp_enqueue_media'));

        // add_filter('manage_edit-categories_columns', array( $this, 'add_post_tag_columns'));

        // add_filter('manage_categories_custom_column', array( $this, 'add_post_tag_column_content'));
    }

    public function register_post_type_and_taxonomies()
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
            'name'               => _x($reference_plural_option, 'post type general name', 'reference'),
            'singular_name'      => _x($reference_singular_option, 'post type singular name', 'reference'),
            'menu_name'          => _x('Reference', 'admin menu', 'reference'),
            'name_admin_bar'     => _x('Article', 'add new on admin bar', 'reference'),
            'add_new'            => _x('Add New', 'Article', 'reference'),
            'add_new_item'       => esc_html__('Add New Article', 'reference'),
            'new_item'           => esc_html__('New Article', 'reference'),
            'edit_item'          => esc_html__('Edit Article', 'reference'),
            'view_item'          => esc_html__('View Article', 'reference'),
            'all_items'          => esc_html__('All Articles', 'reference'),
            'search_items'       => esc_html__('Search Article', 'reference'),
            'parent_item_colon'  => esc_html__('Parent Article:', 'reference'),
            'not_found'          => esc_html__('No Articles found.', 'reference'),
            'not_found_in_trash' => esc_html__('No Articles found in Trash.', 'reference')
        );

        $post_type_args = array(
            'labels'             => $post_type_labels,
            'description'        => esc_html__('Description.', 'reference'),
            'public'             => true,
            'publicly_queryable' => true,
            'menu_icon'          => 'dashicons-book-alt',
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => $reference_slug_option),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
        );

        register_post_type('knowledgebase', $post_type_args);

        $category_labels = array(
            'name'              => _x($category_plural_option, 'taxonomy general name', 'reference'),
            'singular_name'     => _x($category_singular_option, 'taxonomy singular name', 'reference'),
            'search_items'      => esc_html__('Search Topics', 'reference'),
            'all_items'         => esc_html__('All Topics', 'reference'),
            'parent_item'       => esc_html__('Parent Topic', 'reference'),
            'parent_item_colon' => esc_html__('Parent Topic:', 'reference'),
            'edit_item'         => esc_html__('Edit Topic', 'reference'),
            'update_item'       => esc_html__('Update Topic', 'reference'),
            'add_new_item'      => esc_html__('Add New Topic', 'reference'),
            'new_item_name'     => esc_html__('New Topic Name', 'reference'),
            'menu_name'         => esc_html__('Topics', 'reference'),
        );

        $category_args = array(
            'hierarchical'      => true,
            'labels'            => $category_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => $category_slug_option),
        );

        register_taxonomy('knb-categories', array('knowledgebase'), $category_args);

        $tag_labels = array(
            'name'                       => _x($tag_plural_option, 'taxonomy general name', 'reference'),
            'singular_name'              => _x($tag_singular_option, 'taxonomy singular name', 'reference'),
            'search_items'               => esc_html__('Search Tags', 'reference'),
            'popular_items'              => esc_html__('Popular Tags', 'reference'),
            'all_items'                  => esc_html__('All Tags', 'reference'),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => esc_html__('Edit Tag', 'reference'),
            'update_item'                => esc_html__('Update Tag', 'reference'),
            'add_new_item'               => esc_html__('Add New Tag', 'reference'),
            'new_item_name'              => esc_html__('New Tag Name', 'reference'),
            'separate_items_with_commas' => esc_html__('Separate tag with commas', 'reference'),
            'add_or_remove_items'        => esc_html__('Add or remove tags', 'reference'),
            'choose_from_most_used'      => esc_html__('Choose from the most used tags', 'reference'),
            'not_found'                  => esc_html__('No tags found.', 'reference'),
            'menu_name'                  => esc_html__('Tags', 'reference'),
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

        register_taxonomy('knb-tags', 'knowledgebase', $tag_args);
    }

    public function add_knb_categories_image ($taxonomy)
    { ?>
        <div class="form-field term-group">
            <label for="categories-image-id"><?php esc_html_e('Image', 'reference'); ?></label>
            <input type="hidden" id="categories-image-id" name="categories-image-id" class="custom_media_url" value="">
            <div id="categories-image-wrapper"></div>

            <p>
                <input type="button" class="button button-secondary reference_tax_media_button" id="reference_tax_media_button" name="reference_tax_media_button" value="<?php esc_attr_e('Add Image', 'reference'); ?>" />
                <input type="button" class="button button-secondary reference_tax_media_remove" id="reference_tax_media_remove" name="reference_tax_media_remove" value="<?php esc_attr_e('Remove Image', 'reference'); ?>" />
            </p>
        </div>
    <?php }

    public function save_knb_categories_image($term_id, $tt_id)
    {
        $image = filter_input(INPUT_POST, 'categories-image-id', FILTER_SANITIZE_NUMBER_INT);

        if (!empty($image)) {
            add_term_meta($term_id, 'categories-image-id', $image, true);
        }
    }

    public function update_knb_categories_image ($term, $taxonomy)
    { ?>
        <tr class="form-field term-group-wrap">
            <th scope="row">
                <label for="categories-image-id"><?php esc_html_e('Image', 'reference'); ?></label>
            </th>
            <td>
                <?php $image_id = get_term_meta ($term->term_id, 'categories-image-id', true); ?>
                <input type="hidden" id="categories-image-id" name="categories-image-id" value="<?php echo $image_id; ?>">
                <div id="categories-image-wrapper">
                    <?php if ($image_id) { ?>
                        <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                    <?php } ?>
                </div>
                <p>
                    <input type="button" class="button button-secondary reference_tax_media_button" id="reference_tax_media_button" name="reference_tax_media_button" value="<?php esc_attr_e('Add Image', 'reference'); ?>" />
                    <input type="button" class="button button-secondary reference_tax_media_remove" id="reference_tax_media_remove" name="reference_tax_media_remove" value="<?php esc_attr_e('Remove Image', 'reference'); ?>" />
                </p>
            </td>
        </tr>
    <?php }

    public function updated_knb_categories_image($term_id, $tt_id)
    {

        $image = filter_input(INPUT_POST, 'categories-image-id', FILTER_SANITIZE_NUMBER_INT);

        if (!empty($image)) {
            update_term_meta($term_id, 'categories-image-id', $image);
        } else {
            update_term_meta($term_id, 'categories-image-id', '');
        }
    }

    public function add_wp_enqueue_media()
    {
        wp_enqueue_media();
    }


    public function add_post_tag_columns($columns)
    {
        $columns['categories-image-id'] = esc_html__('categories', 'reference');
        // return $columns;
    }


    public function add_post_tag_column_content($content,$term,$taxonomy)
    {
        $content .= "Bar";

        // return $content;
    }


}
