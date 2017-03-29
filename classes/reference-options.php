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
 * @category Reference\Reference\Options
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
class Options
{
    /**
     * Get the Knowledgebase Slug Option and sanitized the slug
     *
     * @return sanitized slug
     */
    public static function getKnbSlug()
    {
        $slug = filter_var(get_option('reference_knb_slug'), FILTER_SANITIZE_URL);
        return $slug;
    }
    /**
     * Get the Knowledgebase Categoty Slug Option and sanitized the slug
     *
     * @return sanitized slug
     */
    public static function getCategorySlug()
    {
        $slug = filter_var(get_option('reference_knb_category_slug'), FILTER_SANITIZE_URL);
        return $slug;
    }
    /**
     * Get the Knowledgebase Tag Slug Option and sanitized the slug
     *
     * @return sanitized slug
     */
    public static function getTagSlug()
    {
        $slug = filter_var(get_option('reference_knb_tag_slug'), FILTER_SANITIZE_URL);
        return $slug;
    }

    /**
     * Get the Knowledgebase Singular Option and sanitized the value
     *
     * @return sanitized value
     */
    public static function getKnbSingular()
    {
        return esc_html(get_option('reference_knb_singular'));
    }
    /**
     * Get the Knowledgebase Plural Option and sanitized the value
     *
     * @return sanitized value
     */
    public static function getKnbPlural()
    {
        return esc_html(get_option('reference_knb_plural'));
    }
    /**
     * Get the Knowledgebase Category Singular Option and sanitized the value
     *
     * @return sanitized value
     */
    public static function getCategorySingular()
    {
        return esc_html(get_option('reference_knb_category_singular'));
    }
    /**
     * Get the Knowledgebase Category Plural Option and sanitized the value
     *
     * @return sanitized value
     */
    public static function getCategoryPlural()
    {
        return esc_html(get_option('reference_knb_category_plural'));
    }
    /**
     * Get the Knowledgebase Tag Singular Option and sanitized the value
     *
     * @return sanitized value
     */
    public static function getTagSingular()
    {
        return esc_html(get_option('reference_knb_tag_singular'));
    }
    /**
     * Get the Knowledgebase Tag Plural Option and sanitized the value
     *
     * @return sanitized value
     */
    public static function getTagPlural()
    {
        return esc_html(get_option('reference_knb_tag_plural'));
    }

    /**
     * Get the Archive Columns Option and convert to absolute integer
     *
     * @return absolute integer
     */
    public static function getArchiveColumn()
    {
        return absint(get_option('reference_knb_archive_column'));
    }
    /**
     * Get the Syntax Highlighting Option and convert to absolute integer
     *
     * @return absolute integer
     */
    public static function getSyntaxHighlighting()
    {
        return absint(get_option('reference_knb_syntax_highlighting'));
    }
    /**
     * Get the Syntax Highlighting Style Option and sanitized the value
     *
     * @return sanitized value
     */
    public static function getSyntaxHighlightingStyle()
    {
        return esc_html(get_option('reference_knb_syntax_highlighting_style'));
    }
    /**
     * Get the Comment Feedback Option and convert to absolute integer
     *
     * @return absolute integer
     */
    public static function getCommentFeedback()
    {
        return absint(get_option('reference_knb_comment_feedback'));
    }
    /**
     * Get the Table of Content Option and convert to absolute integer
     *
     * @return absolute integer
     */
    public static function getTableOfContent()
    {
        return absint(get_option('reference_knb_toc'));
    }
    /**
     * Get the Breadcrumbs Option and convert to absolute integer
     *
     * @return absolute integer
     */
    public static function getBreadcrumbs()
    {
        return absint(get_option('reference_knb_breadcrumbs'));
    }
    /**
     * Get the Sticky Kit Option and convert to absolute integer
     *
     * @return absolute integer
     */
    public static function getStickyKit()
    {
        return absint(get_option('reference_knb_sticky_kit'));
    }
    /**
     * Get the Breadcrumbs Separator Option and sanitized the value
     *
     * @return sanitized value
     */
    public static function getBreadcrumbsSeparator()
    {
        return esc_html(get_option('reference_knb_breadcrumbs_separator'));
    }
    /**
     * Get the Category Excerpt Option and convert to absolute integer
     *
     * @return absolute integer
     */
    public static function getCategoryExcerpt()
    {
        return absint(get_option('reference_knb_category_excerpt'));
    }
    /**
     * Get the Post per Page Option and convert to absolute integer
     *
     * @return absolute integer
     */
    public static function getPostsPerPage()
    {
        return absint(get_option('reference_knb_posts_per_page'));
    }
}
