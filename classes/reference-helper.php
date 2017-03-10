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
final class Helper
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
    public static function get_categories_image ( $term, $taxonomy )
    {
        global $term;

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

        $get_current_term_id = get_term($get_current_term, 'categories');

        $get_current_term_parent = ($get_current_term_id->parent == 0) ? $get_current_term_id : get_term($get_current_term_id->parent, 'categories');

		$categories = array();

		if ( ! $taxonomies ) {

			return;

		}

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {

            $args = array( 'hide_empty' => 0 );

            $terms = get_terms( 'categories', $args );

			if ( $terms ) {

                $categories[] = '<div class="categoriy-listings">';

                foreach ( $terms as $term ) {

                    $term = array_shift( $terms );

                    if($get_current_term === $term->parent || $term->parent === $get_current_term_parent) {
                        $image_id = get_term_meta( $term->term_id, 'categories-image-id', true );
                        $thumbnail = wp_get_attachment_image ( $image_id, 'reference-knowledgebase-thumbnail' );
                        $thumbnail_letter = self::fallback_thumbnail($term->name);
                        $displayed_thumbnail = $thumbnail;

                        if ( empty($thumbnail)) {
                            $displayed_thumbnail = '<div class="letter-thumbnail">' . $thumbnail_letter . '</div>';
                        }

    					$categories[] = sprintf(
    						'<div class="categoriy-listing %1$s"><div class="reference-cat-image">%2$s</div><div class="reference-cat-info"><h5><a href="%3$s">%4$s</a></h5><p class="description">%5$s</p></div></div>',
                            esc_attr( strtolower( str_replace(" ", "-", $term->name ) ) ),
                            $displayed_thumbnail,
    						esc_url( get_term_link( $term->slug, $taxonomy_slug ) ),
    						esc_html( $term->name ),
    						esc_html( self::string_trailing($term->description, 15) )
    					);


	                }
				}
                $categories[] = '</div>';
			}

			return implode( '', $categories );

		}
	}
    public static function fallback_thumbnail($title)
    {
        return substr($title, 0, 1);
    }

    public static function string_trailing($text, $lenght)
    {

        if( strlen( $text ) > $lenght ) {
            $text = substr( $text, 0, $lenght ) . '...';
        }
        return $text;
    }

    public static function get_nav_menu()
    {

        $menu = get_terms( 'nav_menu', array( 'hide_empty' => true ) );

        return $menu;
    }

    public static function table_of_content()
    {
        $reference_menu = self::get_table_of_content_setting();

        $menu = wp_nav_menu(
            array(
                'menu' => $reference_menu,
                'menu_id' => 'reference-menu',
                'container_class' => 'reference-menu-wrap',
                'echo' => false,
                'fallback_cb' => ''
            )
        );

        $ordered_list = str_replace("<ul", "<ol", $menu);

        if (!empty($menu) && !empty($reference_menu)) {
            echo self::handle_empty_var( $ordered_list );
        }
    }
    public static function get_table_of_content_setting()
    {
        $table_of_content_setting = get_post_meta(get_the_ID(), '_knowledgebase_toc_menu_meta_key', true);

        return $table_of_content_setting;
    }


    public static function get_nav_menu_array($current_menu)
    {

        $queried_menu = wp_get_nav_menu_items($current_menu);

        $processed_menu = array();
        $submenu = array();

        foreach ($queried_menu as $menu) {
            if (empty($menu->menu_item_parent)) {
                $processed_menu[$menu->ID]                =   array();
                $processed_menu[$menu->ID]['ID']          =   $menu->ID;
                $processed_menu[$menu->ID]['title']       =   $menu->title;
                $processed_menu[$menu->ID]['url']         =   $menu->url;
                $processed_menu[$menu->ID]['children']    =   array();
            }
        }


        foreach ($queried_menu as $menu) {
            if ($menu->menu_item_parent) {
                $submenu[$menu->ID]             = array();
                $submenu[$menu->ID]['ID']       =   $menu->ID;
                $submenu[$menu->ID]['title']    =   $menu->title;
                $submenu[$menu->ID]['url']      =   $menu->url;
                $processed_menu[$menu->menu_item_parent]['children'][$menu->ID] = $submenu[$menu->ID];
            }
        }

        return $processed_menu;
    }

    public static function handle_empty_var( $var = '' )
    {

    	$output = '';

    	if ( !empty( $var ) ) {

    		return $var;

    	}

    	return $output;

    }
}
