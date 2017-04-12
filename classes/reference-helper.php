<?php
/**
 * This class is used to display value, fetch data and set conditions.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Helper
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference
 * @link     github.com/codehaiku/reference
 */

namespace DSC\Reference;

use \WP_Query;

if (! defined('ABSPATH')) {
    return;
}

/**
 * This class is used to display value, fetch data and set conditions.
 *
 * @category Reference\Helper
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */
final class Helper
{
    /**
     * This method is used to fetch the knowledgebase taxonomies.
     *
     * @since  1.0.0
     * @access public
     * @return object $post Returns the global $post.
     */
    public static function globalPost()
    {
        global $post;

        return $post;
    }
    /**
     * This method is used to fetch the knowledgebase taxonomies.
     *
     * @since  1.0.0
     * @access public
     * @return string $term Returns the global $term.
     */
    public static function globalTerm()
    {
        global $term;

        return $term;
    }
    /**
     * This method is used to fetch the knowledgebase taxonomies.
     *
     * @since  1.0.0
     * @access public
     * @return object $wp_query Returns the global $wp_query.
     */
    public static function globalWpQuery()
    {
        global $wp_query;

        return $wp_query;
    }
    /**
     * This method is used to fetch the knowledgebase taxonomies.
     *
     * @since  1.0.0
     * @access public
     * @return array $taxonomies Returns the Knowledgebase taxonomies.
     */
    public static function getTaxonomies()
    {
        $post = self::globalPost();

        if (! empty($post->ID)) {
            $post = get_post($post->ID);

            $post_type = $post->post_type;

            $taxonomies = get_object_taxonomies($post_type, 'objects');

            return $taxonomies;
        }
        return false;
    }
    /**
     * This method is used to display the Category Listing for
     * 'Knowledgebase Archives.'
     *
     * @since  1.0.0
     * @access public
     * @return string $categories Returns the Category List.
     */
    public static function knowledgebaseCategoryList()
    {
        $post = self::globalPost();

        $term = '';
        $image_id = '';
        $thumbnail = '';
        $thumbnail_letter = '';
        $displayed_thumbnail = '';
        $columns = Options::getArchiveColumn();
        $excerpt = Options::getCategoryExcerpt();
        $count_categories = 0;
        $taxonomy = 'knb-categories';

        $openings = '<div class="category-column">';
        $closings = '<div class="category-listing allowance"></div></div>';

        $categories_list = array();

        $terms = get_terms(
            $taxonomy,
            array(
            'hide_empty' => 0,
            'include' => 0
            )
        );

        if (empty($excerpt)) {
            $excerpt = 15;
        }
        if (!empty($terms)) {
            $categories_list[] = '
                <div class="category-listings columns-'.$columns.'">
            ';

            foreach ($terms as $term) {
                $term = array_shift($terms);

                if (0 === $term->parent) {
                    if (2 === $columns) {
                        if ($count_categories % 2 === 0) {
                            $categories_list[] = $openings;
                        }
                    }
                    if (3 === $columns) {
                        if ($count_categories % 3 === 0) {
                            $categories_list[] = $openings;
                        }
                    }
                    $image_id = get_term_meta(
                        $term->term_id,
                        'categories-image-id',
                        true
                    );
                    $thumbnail = wp_get_attachment_image(
                        $image_id,
                        'reference-knowledgebase-thumbnail'
                    );
                    $thumbnail_letter = self::getFallbackThumbnail(
                        $term->name
                    );
                    $displayed_thumbnail = $thumbnail;

                    if (empty($thumbnail)) {
                        $displayed_thumbnail = '
                            <span class="letter-thumbnail">' .
                            $thumbnail_letter .
                            '</span>
                        ';
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
                        esc_attr(
                            strtolower(
                                str_replace(
                                    " ",
                                    "-",
                                    $term->name
                                )
                            )
                        ),
                        $displayed_thumbnail,
                        esc_url(
                            get_term_link(
                                $term->slug,
                                $taxonomy
                            )
                        ),
                        esc_html(
                            $term->name
                        ),
                        esc_html(
                            self::stringTrailing(
                                $term->description,
                                $excerpt
                            )
                        ),
                        esc_html(
                            '(' .
                            self::getPostCount(
                                $term->term_id
                            ) .
                            ')'
                        )
                    );

                    $count_categories++;

                    if (2 === $columns) {
                        if ($count_categories % 2 === 0) {
                            $categories_list[] = $closings;
                        }
                    }
                    if (3 === $columns) {
                        if ($count_categories % 3 === 0) {
                            $categories_list[] = $closings;
                        }
                    }
                }
            }
            $categories_list[] = '
                    <div class="category-listing allowance"></div>
                    <div class="category-listing allowance"></div>
                </div>
            ';
        }

        if ($count_categories % $columns) {
            $categories[] = '</div>';
        }

        return implode('', $categories_list);
    }
    /**
     * This method is used to display the Category Listing for
     * 'Category Archives.'
     *
     * @since  1.0.0
     * @access public
     * @return string $categories Returns the Category List.
     */
    public static function knowledgebaseCategoryChildList()
    {
        $post = self::globalPost();

        $terms = '';
        $term = '';
        $image_id = '';
        $thumbnail = '';
        $thumbnail_letter = '';
        $displayed_thumbnail = '';
        $columns = Options::getArchiveColumn();
        $excerpt = Options::getCategoryExcerpt();
        $count_categories = 0;
        $taxonomies = self::getTaxonomies();

        $openings = '<div class="category-column">';
        $closings = '<div class="category-listing allowance"></div></div>';

        if (empty($excerpt)) {
            $excerpt = 15;
        }

        $get_current_term = get_queried_object()->term_id;

        $get_current_term_id = get_term($get_current_term, 'knb-categories');

        $get_current_term_parent = ($get_current_term_id->parent == 0) ?
                                    $get_current_term_id : get_term(
                                        $get_current_term_id->parent,
                                        'knb-categories'
                                    );

        $categories = array();

        if (!$taxonomies) {
           return;
        }

        foreach ($taxonomies as $taxonomy_slug => $taxonomy) {
            $args = array(
                'hide_empty' => 0,
                'include' => 0,
                'parent' => $get_current_term_id->term_id,
            );

            $terms = get_terms('knb-categories', $args);

            if (!empty($terms)) {
                $categories[] = '
                    <div class="category-listings columns-'.$columns.'">
                ';

                foreach ($terms as $term) {
                    $term = array_shift($terms);

                    if ($get_current_term === $term->parent
                        || $term->parent === $get_current_term_parent
                    ) {
                        if (2 === $columns) {
                            if ($count_categories % 2 === 0) {
                                $categories[] = $openings;
                            }
                        }
                        if (3 === $columns) {
                            if ($count_categories % 3 === 0) {
                                $categories[] = $openings;
                            }
                        }

                        $image_id = get_term_meta(
                            $term->term_id,
                            'categories-image-id',
                            true
                        );

                        $thumbnail = wp_get_attachment_image(
                            $image_id,
                            'reference-knowledgebase-thumbnail'
                        );

                        $thumbnail_letter = self::getFallbackThumbnail(
                            $term->name
                        );

                        $displayed_thumbnail = $thumbnail;

                        if (empty($thumbnail)) {
                            $displayed_thumbnail = '
                                <span class="letter-thumbnail">' .
                                $thumbnail_letter .
                                '</span>
                            ';
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
                            esc_attr(
                                strtolower(
                                    str_replace(
                                        " ",
                                        "-",
                                        $term->name
                                    )
                                )
                            ),
                            $displayed_thumbnail,
                            esc_url(
                                get_term_link(
                                    $term->slug,
                                    $taxonomy_slug
                                )
                            ),
                            esc_html(
                                $term->name
                            ),
                            esc_html(
                                self::stringTrailing(
                                    $term->description,
                                    $excerpt
                                )
                            ),
                            esc_html(
                                '(' .
                                self::getPostCount(
                                    $term->term_id
                                ) .
                                ')'
                            )
                        );

                        $count_categories++;

                        if (2 === $columns) {
                            if ($count_categories % 2 === 0) {
                                $categories[] = '
                                        <div class="category-listing allowance">
                                        </div>
                                    </div>
                                ';
                            }
                        }
                        if (3 === $columns) {
                            if ($count_categories % 3 === 0) {
                                $categories[] = $closings;
                            }
                        }
                    }
                }
                $categories[] = $closings;
            }
            if ($count_categories % $columns) {
                  $categories[] = '</div>';
            }
            return implode('', $categories);
        }
    }
    /**
     * This method is used to collect all 'Knowledgebase Category' term_id.
     *
     * @since  1.0.0
     * @access public
     * @return array $term_ids Returns the collection of 'Knowledgebase Category'
     *                         term_id.
     */
    public static function getTermIds()
    {
        $term_ids = array();

        $term_args = array(
            'hide_empty' => 0,
        );

        $terms = get_terms('knb-categories', $term_args);

        foreach ($terms as $term) {
            $term_ids[] = $term->term_id;
        }

        return $term_ids;
    }
    /**
     * This method is used to display the number of post in a category or in the
     * Knowledgebase archive.
     *
     * @param integer $id The category term_id.
     * @param boolean $enable_tax_query Enable or disable $tax_query.
     *
     * @since  1.0.0
     * @access public
     * @return integer Returns the number of post.
     */
    public static function getPostCount($id = '', $enable_tax_query = true)
    {
        $tax_query = '';

        if (true === $enable_tax_query) {
            $tax_query = array(
            'relation' => 'AND',
                array(
                    'taxonomy' => 'knb-categories',
                    'field' => 'id',
                    'terms' => $id
                )
            );

            if (is_tax('knb-categories')) {
                if (empty($id)) {
                    $id = self::getCurrentTermId();
                }

                $tax_query = array(
                'relation' => 'AND',
                    array(
                        'taxonomy' => 'knb-categories',
                        'field' => 'id',
                        'terms' => array($id)
                    )
                );
            }
        }

        $args = array(
            'post_type'     => 'dsc-knowledgebase',
            'post_status'   => 'publish',
            'posts_per_page' => -1,
            'tax_query' => $tax_query
        );

        $query = new WP_Query($args);

        return absint($query->post_count);
    }
    /**
     * This method is used to display the thumbnail of a category and checks
     * if the category has a 'Category Image' to dispaly.
     * If the category does not have a 'Category Image' to display, then it
     * displays the first letter of the 'Category Title.'
     *
     * @since  1.0.0
     * @access public
     * @return string $displayed_thumbnail Returns the category thumbnail.
     */
    public static function getCategoryThumbnail()
    {
        $get_current_term_id = self::getCurrentTermId();
        $term_title = single_term_title("", false);
        $term_link = get_term_link($get_current_term_id);
        $image_id = get_term_meta(
            $get_current_term_id,
            'categories-image-id',
            true
        );
        $thumbnail = wp_get_attachment_image(
            $image_id,
            'reference-knowledgebase-thumbnail'
        );
        $thumbnail_letter = self::getFallbackThumbnail($term_title);
        $displayed_thumbnail = '<a href="' . esc_url($term_link) .'" title="' .
                                esc_attr($term_title) . '">'.
                                $thumbnail . '</a>';

        if (empty($thumbnail)) {
            $displayed_thumbnail = '<a href="' . esc_url($term_link) .
                                   '" title="' . esc_attr($term_title) .
                                   '"><span class="letter-thumbnail">'.
                                   $thumbnail_letter . '</span></a>';
        }

        return $displayed_thumbnail;
    }
    /**
     * This method is used to fetch the current term ID.
     *
     * @since  1.0.0
     * @access public
     * @return interger $term_id Returns the current term ID.
     */
    public static function getCurrentTermId()
    {
        $term_id = '';
        $taxonomy = 'knb-categories';
        $get_current_term = get_queried_object()->term_id;

        $get_current_term_id = get_term($get_current_term, $taxonomy);

        foreach ($get_current_term_id as $key => $value) {
            $$key = $value;
        }
        return absint($term_id);
    }
    /**
     * This method is used to fetch the first letter of the given text.
     *
     * @param string $title The base text to get the first letter.
     *
     * @since  1.0.0
     * @access public
     * @return string Returns the first letter of the $title.
     */
    public static function getFallbackThumbnail($title = '')
    {
        return substr($title, 0, 1);
    }
    /**
     * This method is used to excerpt text based on the given number.
     * This is used to excerpt 'Category Description.''
     *
     * @param string  $text   The text to be excerpt.
     * @param integer $lenght the Number of characters to display.
     *
     * @since  1.0.0
     * @access public
     * @return string $text Returns the excerpt text.
     */
    public static function stringTrailing($text = '', $lenght = 15)
    {
        $lenght = absint($lenght);

        if (strlen($text) > $lenght) {
            $text = substr($text, 0, $lenght) . '...';
        }
        return $text;
    }
    /**
     * This method fetch all the 'WordPress Menus.'
     *
     * @since  1.0.0
     * @access public
     * @return array $menu Returns the list of 'WordPress Menus.'
     */
    public static function getNavMenu()
    {
        $menu = get_terms(
            'nav_menu',
            array(
                'hide_empty' => true
            )
        );
        return $menu;
    }
    /**
     * This method displays the assigned Menu for the current 'Knowledgebase.'
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function getTableOfContentMenu()
    {
        $reference_menu = self::getTableOfContentSetting();
        $nav_menu = self::getNavMenu();

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

        if (!empty($menu)
            && !empty($reference_menu)
            && is_nav_menu($reference_menu)
        ) {
            echo $ordered_list;
        }
        return;
    }
    /**
     * This method fetch the value of 'Table of Contents' metabox based on the
     * ID current 'Knowledgebase.'
     *
     * @since  1.0.0
     * @access public
     * @return boolean $table_of_content_setting Returns if the value
     *                                           of the post meta.
     */
    public static function getTableOfContentSetting()
    {
        $table_of_content_setting = get_post_meta(
            get_the_ID(),
            '_reference_knowledgebase_menu_meta_key',
            true
        );

        return $table_of_content_setting;
    }
    /**
     * This method fetch the IP address of the visitor to your site.
     * This is used by the 'Comment Feedback' feature of the 'Reference' plugin
     * to track the visitors IP address and is used to check if the visitor
     * has already voted.
     *
     * @since  1.0.0
     * @access public
     * @return array $ip Returns the collection of IP addresses.
     */
    public static function getIpAddress()
    {
        $ip = $_SERVER['SERVER_ADDR'];

        if ('WINNT' == PHP_OS) {
            $ip = getHostByName(getHostName());
        }

        if ('Linux' === PHP_OS) {
            $ip = array();
            $command = "/sbin/ifconfig";
            $pattern = '/inet addr:?([^ ]+)/';

            exec($command, $output);

            foreach ($output as $key => $subject) {
                $result = preg_match_all($pattern, $subject, $subpattern);
                if ($result == 1) {
                    if ($subpattern[1][0] != "127.0.0.1") {
                        $ip = $subpattern[1][0];
                    }
                }
            }
        }
        return $ip;
    }
    /**
     * This method contains the collection of all allowed
     * 'Syntax Highlighting Style.'
     * This method is used to display the allowed 'Syntax Highlighting Style' in
     * the 'Syntax Highlighting Style' setting of the 'Reference Settings' page.
     *
     * @since  1.0.0
     * @access public
     * @return array $styles_library Returns the collection of the allowed
     *                               'Syntax Highlighting Style.'
     */
    public static function getSyntaxHighlightingStyle()
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
    /**
     * Fetch the assigned style for the 'Syntax Highlighting Style'
     * settings in the 'Reference Settings' page.
     * This method replace space to dash base of the value of
     * the 'Syntax Highlighting Style' setting.
     *
     * @since  1.0.0
     * @access public
     * @return string $formated_styles Returns the exact filename for the
     *                                 Syntax Highlighting.
     */
    public static function getSyntaxHighlightingStyleFile()
    {
        $formated_styles = '';
        $style = Options::getSyntaxHighlightingStyle();

        $formated_styles = str_replace(' ', '-', $style);

        return $formated_styles;
    }
    /**
     * This method checks if the the option of the
     * Reference Setting is set to true.
     *
     * @param string $option The value of the Reference Setting option
     *
     * @since  1.0.0
     * @access public
     * @return string $option Returns 'enable' if the option is true and
     *                        returns 'disable' if the option is false.
     */
    public static function isOptionTrue($key = '')
    {
        $option = array(
            true => 'enable',
            false => 'disable',
        );

        return $option[$key];
    }
    /**
     * (Unfinished) returns an array of menu in the Table of Contens.
     * Used to display the prev and next in a single knowledgebase.
     *
     * @param string $current_menu The name of the Menu.
     *
     * @since  1.0.0
     * @access public
     * @return array $processed_menu Array of menus in the table of contents.
     */
    public static function getNavMenuArray($current_menu = '')
    {
        if (empty($current_menu)) {
            $current_menu = self::getTableOfContentSetting();
        }
        $queried_menu = wp_get_nav_menu_items($current_menu);

        $processed_menu = array();
        $submenu = array();

        foreach ($queried_menu as $menu) {
            $processed_menu[$menu->ID] = array();
            $processed_menu[$menu->ID]['object_id'] = intval($menu->object_id);
            $processed_menu[$menu->ID]['ID'] = $menu->ID;
            $processed_menu[$menu->ID]['title'] = $menu->title;
            $processed_menu[$menu->ID]['url'] = $menu->url;
            $processed_menu[$menu->ID]['menu_order'] = intval($menu->menu_order);
        }
        return $processed_menu;
    }
}
