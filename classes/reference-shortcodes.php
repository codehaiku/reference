<?php
/**
 * This class is executes the reference shortcode.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Reference\KnowledgebaseShortcodes
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
 * This class handles the frontend funtionality.
 *
 * @category Reference\Public\KnowledgebaseShortcodes
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 * @since    1.0
 */
class KnowledgebaseShortcodes
{
    public function __construct()
    {

        add_shortcode( 'reference_loop', array( $this, 'register_reference_loop' ) );
        add_shortcode( 'reference_highlighter', array( $this, 'register_reference_highlighter' ) );

        return $this;
    }

    public function register_reference_loop($atts)
    {

		$atts = shortcode_atts(
			array(
                'categories' => '',
                'posts_per_page' => 10,
				'columns' => 3,
				'enable_search' => 'yes',
				'show_category' => 'yes',
			), $atts, 'reference_loop'
		);

		return $this->display( $atts );

	}
    public function register_reference_highlighter($atts, $content = null)
    {

		$atts = shortcode_atts(
			array(
                'categories' => '',
                'posts_per_page' => 10,
				'columns' => 3,
				'enable_search' => 'yes',
				'show_category' => 'yes',
			), $atts, 'reference_highlighter'
		);

		return '<pre class="reference-highlighter"><code>' . $content . '</code></pre>';

	}

    public function display($atts)
    {

		ob_start();

		$template = REFERENCE_DIR_PATH . 'shortcodes/reference.php';

		if ( $theme_template = locate_template( array( 'knowledgebase/shortcodes/reference.php' ) ) ) {

			   $template = $theme_template;

		}

		include $template;

		return ob_get_clean();

    }

    public static function reference_shortcode_display_knowledgebase_category_list($categories, $columns)
    {
        $post = Helper::global_post();

        $columns = intval($columns);
        $terms = '';
        $term = '';
        $taxonomy = 'knb-categories';
        $image_id = '';
        $thumbnail = '';
        $thumbnail_letter = '';
        $displayed_thumbnail = '';
        $excerpt = intval(get_option('reference_knb_category_excerpt'));
        $count_categories = 0;

        $categories_list = array();

        $get_term_categories = get_terms( $taxonomy, array(
            'orderby'    => 'count',
            'hide_empty' => 0,
            'name' => $categories
        ) );

        if (empty($excerpt)) {
            $excerpt = 15;
        }

        $args = array( 'hide_empty' => 0 );

        $terms = get_terms( $taxonomy, $args );

        $child_categories = array();
        $listed_categories = array();

        if (empty($columns)) {
            $columns = 3;
        }

        foreach ( $get_term_categories as $get_term_category ) {
            foreach ( $terms as $term ) {
                if($get_term_category->term_id === $term->parent) {
                    $child_categories[] = $term->name;
                }
            }
        }

        $get_child_term_categories = get_terms( $taxonomy, array(
            'hide_empty' => 0,
            'name' => $child_categories
        ) );

        foreach ($categories as $category ) {
            $term_name = get_term_by( 'name',  $category,  'knb-categories'  );
            if ($term_name != null) {
                $listed_categories[] = $term_name->term_id;
            }
        }

        if (!empty($child_categories)) {

            $categories_list[] = '<div class="category-listings columns-'.$columns.' shortcode">';

            foreach ( $get_child_term_categories as $term ) {

                $term = array_shift( $get_child_term_categories );

                if(in_array($term->parent, $listed_categories) && $term->parent !== 0) {

                    if (3 === $columns) {
                        if ($count_categories % 3 === 0) {
                            $categories_list[] = '<div class="category-column">';
                        }
                    }
                    if (2 === $columns) {
                        if ($count_categories % 2 === 0) {
                            $categories_list[] = '<div class="category-column">';
                        }
                    }

                    if( $term->parent) {
                        $image_id = get_term_meta( $term->term_id, 'categories-image-id', true );
                        $thumbnail = wp_get_attachment_image ( $image_id, 'reference-knowledgebase-thumbnail' );
                        $thumbnail_letter = Helper::fallback_thumbnail($term->name);
                        $displayed_thumbnail = $thumbnail;

                        if ( empty($thumbnail)) {
                            $displayed_thumbnail = '<span class="letter-thumbnail">' . $thumbnail_letter . '</span>';
                        }

            			$categories_list[] = sprintf(
                            '<div class="category-listing %1$s">
                                <div class="reference-cat-image">
                                    <a href="%3$s">%2$s</a>
                                </div>
                                <div class="reference-cat-info">
                                    <h5>
                                        <a href="%3$s">%4$s</a>
                                        <span class="count">%6$s</span>
                                    </h5>
                                    <p class="description">%5$s</p>
                                </div>
                            </div>',
                            esc_attr(strtolower(str_replace(" ", "-", $term->name))),
                            $displayed_thumbnail,
                            esc_url(get_term_link( $term->slug, $taxonomy)),
                            esc_html($term->name),
                            esc_html(Helper::string_trailing($term->description, $excerpt)),
                            esc_html('(' . Helper::get_post_count($term->term_id) . ')')
                        );
                    }

                    $count_categories++;

                    if (3 === $columns) {
                        if ($count_categories % 3 === 0) {
                            $categories_list[] = '<div class="category-listing allowance"></div></div>' ;
                        }
                    }
                    if (2 === $columns) {
                        if ($count_categories % 2 === 0) {
                            $categories_list[] = '<div class="category-listing allowance"></div></div>';
                        }
                    }
                }
            }
            $categories_list[] = '<div class="category-listing allowance"></div><div class="category-listing allowance"></div></div>';
        }

        if ($count_categories % $columns) {
            $categories[] = '</div>';
        }

		return implode( '', $categories_list );
	}
}
