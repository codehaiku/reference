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

 if ( ! defined( 'ABSPATH' ) ) {
     return;
 }

final class PostType {

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
	public function __construct( $name, $version, $loader )
    {

		$this->loader = $loader;

		$this->name = $name;

		$this->version = $version;

		add_action('init', array( $this, "register_post_type_and_taxonomies" ));

        add_action( 'knb-categories_add_form_fields', array( $this, 'add_knb_categories_image' ), 10, 2 );

        add_action( 'created_knb-categories', array( $this, 'save_knb_categories_image' ), 10, 2 );

        add_action( 'knb-categories_edit_form_fields', array( $this, 'update_knb_categories_image' ), 10, 2 );

        add_action( 'edited_knb-categories', array( $this, 'updated_knb_categories_image' ), 10, 2 );

        add_action( 'admin_enqueue_scripts', array( $this, 'add_wp_enqueue_media' ));

        // add_filter('manage_edit-categories_columns', array( $this, 'add_post_tag_columns'));

        // add_filter('manage_categories_custom_column', array( $this, 'add_post_tag_column_content'));
	}

    public function register_post_type_and_taxonomies()
    {

        $post_type_labels = array(
    		'name'               => _x( 'Knowledgebase', 'post type general name', 'reference' ),
    		'singular_name'      => _x( 'Knowledgebase', 'post type singular name', 'reference' ),
    		'menu_name'          => _x( 'Knowledgebase', 'admin menu', 'reference' ),
    		'name_admin_bar'     => _x( 'Knowledgebase', 'add new on admin bar', 'reference' ),
    		'add_new'            => _x( 'Add New', 'Knowledgebase', 'reference' ),
    		'add_new_item'       => __( 'Add New Knowledgebase', 'reference' ),
    		'new_item'           => __( 'New Knowledgebase', 'reference' ),
    		'edit_item'          => __( 'Edit Knowledgebase', 'reference' ),
    		'view_item'          => __( 'View Knowledgebase', 'reference' ),
    		'all_items'          => __( 'All Knowledgebase', 'reference' ),
    		'search_items'       => __( 'Search Knowledgebase', 'reference' ),
    		'parent_item_colon'  => __( 'Parent Knowledgebase:', 'reference' ),
    		'not_found'          => __( 'No Knowledgebase found.', 'reference' ),
    		'not_found_in_trash' => __( 'No Knowledgebase found in Trash.', 'reference' )
    	);

        $post_type_args = array(
    		'labels'             => $post_type_labels,
            'description'        => __( 'Description.', 'reference' ),
    		'public'             => true,
    		'publicly_queryable' => true,
            'menu_icon'          => 'dashicons-book-alt',
    		'show_ui'            => true,
    		'show_in_menu'       => true,
    		'query_var'          => true,
    		'rewrite'            => array( 'slug' => 'Knowledgebase' ),
    		'capability_type'    => 'post',
    		'has_archive'        => true,
    		'hierarchical'       => false,
    		'menu_position'      => null,
    		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    	);

    	register_post_type( 'knowledgebase', $post_type_args );

        $category_labels = array(
    		'name'              => _x( 'Categories', 'taxonomy general name', 'reference' ),
    		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'reference' ),
    		'search_items'      => __( 'Search Categories', 'reference' ),
    		'all_items'         => __( 'All Categories', 'reference' ),
    		'parent_item'       => __( 'Parent Category', 'reference' ),
    		'parent_item_colon' => __( 'Parent Category:', 'reference' ),
    		'edit_item'         => __( 'Edit Category', 'reference' ),
    		'update_item'       => __( 'Update Category', 'reference' ),
    		'add_new_item'      => __( 'Add New Category', 'reference' ),
    		'new_item_name'     => __( 'New Category Name', 'reference' ),
    		'menu_name'         => __( 'Categories', 'reference' ),
    	);

    	$category_args = array(
    		'hierarchical'      => true,
    		'labels'            => $category_labels,
    		'show_ui'           => true,
    		'show_admin_column' => true,
    		'query_var'         => true,
    		'rewrite'           => array( 'slug' => 'knb-categories' ),
    	);

    	register_taxonomy( 'knb-categories', array( 'knowledgebase' ), $category_args );

        $tag_labels = array(
    		'name'                       => _x( 'Tags', 'taxonomy general name', 'reference' ),
    		'singular_name'              => _x( 'Tag', 'taxonomy singular name', 'reference' ),
    		'search_items'               => __( 'Search Tags', 'reference' ),
    		'popular_items'              => __( 'Popular Tags', 'reference' ),
    		'all_items'                  => __( 'All Tags', 'reference' ),
    		'parent_item'                => null,
    		'parent_item_colon'          => null,
    		'edit_item'                  => __( 'Edit Tag', 'reference' ),
    		'update_item'                => __( 'Update Tag', 'reference' ),
    		'add_new_item'               => __( 'Add New Tag', 'reference' ),
    		'new_item_name'              => __( 'New Tag Name', 'reference' ),
    		'separate_items_with_commas' => __( 'Separate tag with commas', 'reference' ),
    		'add_or_remove_items'        => __( 'Add or remove tags', 'reference' ),
    		'choose_from_most_used'      => __( 'Choose from the most used tags', 'reference' ),
    		'not_found'                  => __( 'No tags found.', 'reference' ),
    		'menu_name'                  => __( 'Tags', 'reference' ),
    	);

    	$tag_args = array(
    		'hierarchical'          => false,
    		'labels'                => $tag_labels,
    		'show_ui'               => true,
    		'show_admin_column'     => true,
    		'update_count_callback' => '_update_post_term_count',
    		'query_var'             => true,
    		'rewrite'               => array( 'slug' => 'tag' ),
    	);

    	register_taxonomy( 'knb-tags', 'knowledgebase', $tag_args );
    }

    public function add_knb_categories_image ( $taxonomy )
    { ?>
        <div class="form-field term-group">
            <label for="categories-image-id"><?php esc_html_e('Image', 'reference'); ?></label>
            <input type="hidden" id="categories-image-id" name="categories-image-id" class="custom_media_url" value="">
            <div id="categories-image-wrapper"></div>

            <p>
                <input type="button" class="button button-secondary reference_tax_media_button" id="reference_tax_media_button" name="reference_tax_media_button" value="<?php esc_attr_e( 'Add Image', 'reference' ); ?>" />
                <input type="button" class="button button-secondary reference_tax_media_remove" id="reference_tax_media_remove" name="reference_tax_media_remove" value="<?php esc_attr_e( 'Remove Image', 'reference' ); ?>" />
            </p>
        </div>
    <?php }

    public function save_knb_categories_image($term_id, $tt_id)
    {
        $image = filter_input(INPUT_POST, 'categories-image-id', FILTER_SANITIZE_NUMBER_INT);

        if( !empty($image) ) {
            add_term_meta( $term_id, 'categories-image-id', $image, true );
        }
    }

    public function update_knb_categories_image ( $term, $taxonomy )
    { ?>
        <tr class="form-field term-group-wrap">
            <th scope="row">
                <label for="categories-image-id"><?php esc_html_e( 'Image', 'reference' ); ?></label>
            </th>
            <td>
                <?php $image_id = get_term_meta ( $term->term_id, 'categories-image-id', true ); ?>
                <input type="hidden" id="categories-image-id" name="categories-image-id" value="<?php echo $image_id; ?>">
                <div id="categories-image-wrapper">
                    <?php if ( $image_id ) { ?>
                        <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
                    <?php } ?>
                </div>
                <p>
                    <input type="button" class="button button-secondary reference_tax_media_button" id="reference_tax_media_button" name="reference_tax_media_button" value="<?php esc_attr_e( 'Add Image', 'reference' ); ?>" />
                    <input type="button" class="button button-secondary reference_tax_media_remove" id="reference_tax_media_remove" name="reference_tax_media_remove" value="<?php esc_attr_e( 'Remove Image', 'reference' ); ?>" />
                </p>
            </td>
        </tr>
    <?php }

    public function updated_knb_categories_image($term_id, $tt_id)
    {

        $image = filter_input(INPUT_POST, 'categories-image-id', FILTER_SANITIZE_NUMBER_INT);

        if( !empty($image) ) {
            update_term_meta ( $term_id, 'categories-image-id', $image );
        } else {
            update_term_meta ( $term_id, 'categories-image-id', '' );
        }
    }

    public function add_wp_enqueue_media()
    {
        wp_enqueue_media();
    }


    public function add_post_tag_columns($columns)
    {
        $columns['categories-image-id'] = esc_html__( 'categories', 'reference' );
        // return $columns;
    }


    public function add_post_tag_column_content($content,$term,$taxonomy)
    {
        $content .= "Bar";

        // return $content;
    }


}
