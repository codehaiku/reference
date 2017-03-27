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
 * @category Reference\Reference\Helper
 * @package  Reference WordPress Knowledgebase
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference-wordpress-knowledgebase
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 */

namespace DSC\Reference;

use \WP_Query;

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
    public static function global_post()
    {
        global $post;

        return $post;
    }
    public static function global_term()
    {
        global $term;

        return $term;
    }

    public static function reference_get_knowledgebase_category()
    {
        $post = self::global_post();

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
        $term = self::global_term();

        $image_id = get_term_meta ( $term->term_id, 'categories-image-id', true );

        return  $term->term_id;
    }

    public static function reference_display_knowledgebase_category_list()
    {
        $post = self::global_post();

        $term = '';
        $image_id = '';
        $thumbnail = '';
        $thumbnail_letter = '';
        $displayed_thumbnail = '';
        $columns = intval(get_option('reference_knb_archive_column'));
        $excerpt = intval(get_option('reference_knb_category_excerpt'));
        $count_categories = 0;
        $taxonomy = 'knb-categories';

        $categories_list = array();

        $terms = get_terms( $taxonomy, array(
            'hide_empty' => 0,
            'include' => 0
        ) );

        if (empty($excerpt)) {
            $excerpt = 15;
        }
        if (!empty($terms)) {

            $categories_list[] = '<div class="category-listings columns-'.$columns.'">';

            foreach ( $terms as $term ) {

                $term = array_shift($terms);

                if(0 === $term->parent) {
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
                    $image_id = get_term_meta( $term->term_id, 'categories-image-id', true );
                    $thumbnail = wp_get_attachment_image ( $image_id, 'reference-knowledgebase-thumbnail' );
                    $thumbnail_letter = self::fallback_thumbnail($term->name);
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
                        esc_html(self::string_trailing($term->description, $excerpt)),
                        esc_html('(' . self::get_post_count($term->term_id) . ')')
                    );

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
    public static function reference_display_child_category_list()
    {
        $post = self::global_post();

        $terms = '';
        $term = '';
        $image_id = '';
        $thumbnail = '';
        $thumbnail_letter = '';
        $displayed_thumbnail = '';
        $columns = intval(get_option('reference_knb_archive_column'));
        $excerpt = intval(get_option('reference_knb_category_excerpt'));
        $count_categories = 0;
        $taxonomies = self::reference_get_knowledgebase_category();

        if (empty($excerpt)) {
            $excerpt = 15;
        }

        $get_current_term = get_queried_object()->term_id;

        $get_current_term_id = get_term($get_current_term, 'knb-categories');

        $get_current_term_parent = ($get_current_term_id->parent == 0) ? $get_current_term_id : get_term($get_current_term_id->parent, 'knb-categories');

		$categories = array();

		if ( ! $taxonomies ) {

			return;

		}

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {

            $args = array(
                'hide_empty' => 0,
                'parent' => $get_current_term_id->term_id,
            );

            $terms = get_terms( 'knb-categories', $args );

			if (!empty($terms)) {

                $categories[] = '<div class="category-listings columns-'.$columns.'">';

                foreach ( $terms as $term ) {

                    $term = array_shift( $terms );

                    if ($get_current_term === $term->parent || $term->parent === $get_current_term_parent) {

                        if (3 === $columns) {
                            if ($count_categories % 3 === 0) {
                                $categories[] = '<div class="category-column">';
                            }
                        }
                        if (2 === $columns) {
                            if ($count_categories % 2 === 0) {
                                $categories[] = '<div class="category-column">';
                            }
                        }

                        $image_id = get_term_meta( $term->term_id, 'categories-image-id', true );
                        $thumbnail = wp_get_attachment_image ( $image_id, 'reference-knowledgebase-thumbnail' );
                        $thumbnail_letter = self::fallback_thumbnail($term->name);
                        $displayed_thumbnail = $thumbnail;

                        if ( empty($thumbnail)) {
                            $displayed_thumbnail = '<span class="letter-thumbnail">' . $thumbnail_letter . '</span>';
                        }

    					$categories[] = sprintf(
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
    						esc_url(get_term_link($term->slug, $taxonomy_slug)),
    						esc_html($term->name),
    						esc_html(self::string_trailing($term->description, $excerpt)),
                            esc_html('(' . self::get_post_count($term->term_id) . ')')
    					);

                        $count_categories++;

                        if (3 === $columns) {
                            if ($count_categories % 3 === 0) {
                                $categories[] = '<div class="category-listing allowance"></div></div>';
                            }
                        }
                        if (2 === $columns) {
                            if ($count_categories % 2 === 0) {
                                $categories[] = '<div class="category-listing allowance"></div></div>';
                            }
                        }
	                }
				}
                $categories[] = '<div class="category-listing allowance"></div><div class="category-listing allowance"></div></div>';
			}

            if ($count_categories % $columns) {
                $categories[] = '</div>';
            }

			return implode( '', $categories );

		}
	}
    public static function get_post_count ($id = '')
    {
        $tax_query = '';

        if (is_tax( 'knb-categories' )) {

            if (empty($id)) {
                $id = self::current_term_id();
            }

            $tax_query = array(
            'relation' => 'AND',
                array(
                    'taxonomy' => 'knb-categories',  //taxonomy name  here, I used 'product_cat'
                    'field' => 'id',
                    'terms' => array( $id )
                )
            );
        }

        $args = array(
            'post_type'     => 'knowledgebase', //post type, I used 'product'
            'post_status'   => 'publish', // just tried to find all published post
            'posts_per_page' => -1,  //show all
            'tax_query' => $tax_query
        );

        $query = new WP_Query($args);

        return (int)$query->post_count;

    }

    public static function the_category_thumbnail()
    {
        $get_current_term_id = self::current_term_id();
        $term_title = single_term_title("", false);
        $term_link = get_term_link( $get_current_term_id );
        $image_id = get_term_meta( $get_current_term_id, 'categories-image-id', true );
        $thumbnail = wp_get_attachment_image ( $image_id, 'reference-knowledgebase-thumbnail' );
        $thumbnail_letter = self::fallback_thumbnail($term_title);
        $displayed_thumbnail = '<a href="' . esc_url($term_link) .'" title="' . esc_attr($term_title) . '">'. $thumbnail . '</a>';;

        if ( empty($thumbnail)) {
            $displayed_thumbnail = '<a href="' . esc_url($term_link) .'" title="' . esc_attr($term_title) . '"><span class="letter-thumbnail">'. $thumbnail_letter . '</span></a>';
        }

        return $displayed_thumbnail;
    }
    public static function current_term_id()
    {
        $term_id = '';
        $taxonomy = 'knb-categories';
        $get_current_term = get_queried_object()->term_id;

        $get_current_term_id = get_term($get_current_term, $taxonomy);

        foreach ($get_current_term_id as $key => $value) {
            $$key = $value;
        }

        return $term_id;
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
        $nav_menu = self::get_nav_menu();

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

        if (!empty($menu) && !empty($reference_menu) && is_nav_menu($reference_menu)) {
            echo $ordered_list;
        }

    }
    public static function get_table_of_content_setting()
    {
        $table_of_content_setting = get_post_meta(get_the_ID(), '_knowledgebase_toc_menu_meta_key', true);

        return $table_of_content_setting;
    }

    public static function get_ip()
    {
        $ip = $_SERVER['SERVER_ADDR'];

        if ('WINNT' == PHP_OS) {
            $ip = getHostByName(getHostName());
        }

        if ('Linux' == PHP_OS) {
            $ip = array();
            $command = "/sbin/ifconfig";
            $pattern = '/inet addr:?([^ ]+)/';

            exec($command, $output);

            foreach ($output as $key => $subject) {
                $result = preg_match_all($pattern, $subject, $subpattern);
                if ($result == 1) {
                    if ($subpattern[1][0] != "127.0.0.1")
                    $ip = $subpattern[1][0];
                }
            }
        }
        return $ip;
    }

    public static function get_highlighting_style()
    {
        $styles_library = array(
            'agate',
            'androidstudio',
            'atom one dark',
            'darcula',
            'dark',
            'gruvbox dark',
            'hybrid',
            'monokai sublime',
            'obsidian',
            'ocean'
        );

        return $styles_library;
    }
    public static function get_highlighting_style_file()
    {
        $formated_styles = '';
        $style = get_option( 'reference_knb_syntax_highlighting_style' );

        $formated_styles = str_replace(' ', '-', $style);

        return $formated_styles;
    }
    public static function isOptionTrue($option = '')
    {
        if ((bool)$option == true) {
            $option = 'enable';
        } elseif ((bool)$option == false) {
            $option = 'disable';
        }

        return $option;
    }
    /**
     * For Menu (Unfinished)
     */
    public static function get_nav_menu_array($current_menu = '')
    {
        if (empty($current_menu)) {
            $current_menu = self::get_table_of_content_setting();
        }

        $queried_menu = wp_get_nav_menu_items($current_menu);

        $processed_menu = array();
        $submenu = array();

        foreach ($queried_menu as $menu) {
                $processed_menu[$menu->ID]                      =   array();
                $processed_menu[$menu->ID]['object_id']         =   intval($menu->object_id);
                $processed_menu[$menu->ID]['ID']                =   $menu->ID;
                $processed_menu[$menu->ID]['title']             =   $menu->title;
                $processed_menu[$menu->ID]['url']               =   $menu->url;
                $processed_menu[$menu->ID]['menu_order']        =   intval($menu->menu_order);
        }

        return $processed_menu;
    }
}
