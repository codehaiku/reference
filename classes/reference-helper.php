<?php
/**
 * This class is executes the reference shortcode.
 *
 * (c) Joseph Gabito <joseph@useissuestabinstead.com>
 * (c) Jasper jardin <jasper@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Reference\Helper
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
 * @category Reference\Public\ReferencePublic
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 * @since    1.0
 */
FInal class Helper
{

    public static function reference_get_knowledgebase_category()
    {
        global $post;

		if ( ! empty( $post->ID ) ) {

			$post = get_post( $post->ID );

			// Get post type by post.
			$post_type = $post->post_type;

			// Get post type taxonomies.
			$taxonomies = get_object_taxonomies( $post_type, 'objects' );

			return $taxonomies;
		}

		return false;

	}
    public function get_categories_image ( $term, $taxonomy )
    {
        global $term;
// echo get_term_meta($term->ID, 'game_name', true);
        $image_id = get_term_meta ( $term->term_id, 'categories-image-id', true );

        return  $term->term_id;
    }

    public static function reference_display_knowledgebase_category_list()
    {
        global $post;

        $terms = '';
        $term = '';
        $image_id = '';
        $thumbnail = '';
        $thumbnail_letter = '';
        $displayed_thumbnail = '';

		$taxonomies = self::reference_get_knowledgebase_category();
        $get_current_term = get_queried_object()->term_id;

        // echo '<pre>';
        // var_dump($taxonomies);
        // echo '</pre>';

        $args = array( 'hide_empty' => 0 );

        $terms = get_terms( 'categories', $args );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {

            $terms_sibling = array();
            foreach ($terms as &$term ) {

                if($get_current_term === $term->parent && 0 !== $term->parent) {
                    echo 'yes' . $get_current_term . ' ';
                    $terms_sibling[$term->name]['term_id'] = $term->term_id;
                    $terms_sibling[$term->name]['name'] = $term->name;
                    $terms_sibling[$term->name]['parent'] = $term->parent;
                    $terms_sibling[$term->name]['slug'] = $term->slug;
                    $terms_sibling[$term->name]['term_group'] = $term->term_group;
                    $terms_sibling[$term->name]['term_taxonomy_id'] = $term->term_taxonomy_id;
                    $terms_sibling[$term->name]['taxonomy'] = $term->taxonomy;
                    $terms_sibling[$term->name]['description'] = $term->description;
                    $terms_sibling[$term->name]['count'] = $term->count;
                    $terms_sibling[$term->name]['filter'] = $term->filter;
                }
                echo '[name:' . $term->name . ']'.'[parent:' . $term->parent . '] [term_id:' .$term->term_id.']<br>';
            }

            $object = (object) $terms_sibling;
            foreach ($terms_sibling as $key => $value)
            {
                $object->$key = $value;
            }

            foreach ($terms as $term ) {
                if(0 !== $term->parent) {
                echo $terms_sibling[$term->name]['name'] . '<br>....<br>';
                }
            }
        }

        echo '<pre style="background: red; color: #fff;">';
        var_dump($object);
        echo '</pre>';

		$categories = array();

		if ( ! $taxonomies ) {

			return;

		}

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {

			// Get the terms related to post.
			$terms = get_the_terms( $post->ID, $taxonomy_slug );

			if ( $terms ) {

				foreach ( $terms as $term ) {

                    $term = array_shift( $terms );

                    $image_id = get_term_meta( $term->term_id, 'categories-image-id', true );
                    $thumbnail = wp_get_attachment_image ( $image_id, 'thumbnail' );
                    $thumbnail_letter = self::reference_thumbnail_letter($term->name);
                    $displayed_thumbnail = $thumbnail;

                    if ( empty($thumbnail)) {
                        $displayed_thumbnail = $thumbnail_letter;
                    }



					$categories[] = sprintf(
						'<article class="hentry %1$s"><div class="reference-cat-image">%2$s</div><a href="%3$s">%4$s</a><div class="description">%5$s</div></article>',
                        esc_attr( strtolower( $term->name ) ),
                        $displayed_thumbnail,
						esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
						esc_html( $term->name ),
						esc_html( self::reference_excerpt_description($term->description, 55) )
					);

				}
			}

			return implode( '', $categories );

		}
	}
    public static function reference_thumbnail_letter($title)
    {
        return substr($title, 0, 1);
    }

    public static function reference_excerpt_description($text, $lenght) {

        if( strlen( $text ) > $lenght ) {
            $text = substr( $text, 0, $lenght ) . '...';
        }
        return $text;
    }
}
