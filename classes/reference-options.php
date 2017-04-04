<?php
/**
 * This class is used to sanitized Reference Settings before used.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Options
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
 * This class is used to sanitized Reference Settings before used.
 *
 * @category Reference\Options
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */
class Options
{
    /**
     * Get the Knowledgebase Slug Option and sanitized the slug.
     *
     * @return string $slug Returns sanitized slug.
     */
    public static function getKnbSlug()
    {
        $slug = filter_var(
            get_option(
                'reference_knb_slug'
            ),
            FILTER_SANITIZE_URL
        );
        return $slug;
    }
    /**
     * Get the Knowledgebase Category Slug Option and sanitized the slug.
     *
     * @return string $slug Returns sanitized slug.
     */
    public static function getCategorySlug()
    {
        $slug = filter_var(
            get_option(
                'reference_knb_category_slug'
            ),
            FILTER_SANITIZE_URL
        );
        return $slug;
    }
    /**
     * Get the Knowledgebase Tag Slug Option and sanitized the slug
     *
     * @return string $slug Returns sanitized slug.
     */
    public static function getTagSlug()
    {
        $slug = filter_var(
            get_option(
                'reference_knb_tag_slug'
            ),
            FILTER_SANITIZE_URL
        );
        return $slug;
    }

    /**
     * Get the Knowledgebase Singular Option and sanitized the value.
     *
     * @return string Returns sanitized value.
     */
    public static function getKnbSingular()
    {
        return esc_html(
            get_option(
                'reference_knb_singular'
            )
        );
    }
    /**
     * Get the Knowledgebase Plural Option and sanitized the value.
     *
     * @return string Returns sanitized value.
     */
    public static function getKnbPlural()
    {
        return esc_html(
            get_option(
                'reference_knb_plural'
            )
        );
    }
    /**
     * Get the Knowledgebase Category Singular Option and sanitized the value.
     *
     * @return string Returns sanitized value.
     */
    public static function getCategorySingular()
    {
        return esc_html(
            get_option(
                'reference_knb_category_singular'
            )
        );
    }
    /**
     * Get the Knowledgebase Category Plural Option and sanitized the value.
     *
     * @return string Returns sanitized value.
     */
    public static function getCategoryPlural()
    {
        return esc_html(
            get_option(
                'reference_knb_category_plural'
            )
        );
    }
    /**
     * Get the Knowledgebase Tag Singular Option and sanitized the value.
     *
     * @return string Returns sanitized value.
     */
    public static function getTagSingular()
    {
        return esc_html(
            get_option(
                'reference_knb_tag_singular'
            )
        );
    }
    /**
     * Get the Knowledgebase Tag Plural Option and sanitized the value
     *
     * @return string Returns sanitized value.
     */
    public static function getTagPlural()
    {
        return esc_html(
            get_option(
                'reference_knb_tag_plural'
            )
        );
    }

    /**
     * Get the Archive Columns Option and convert to absolute integer.
     *
     * @return integer Returns absolute integer.
     */
    public static function getArchiveColumn()
    {
        return absint(
            get_option(
                'reference_knb_archive_column'
            )
        );
    }
    /**
     * Checks if 'Syntax Highlighting' setting is enabled.
     *
     * @return boolean Returns true if 'Syntax Highlighting' setting is enabled.
     */
    public static function getSyntaxHighlighting()
    {
        $is_enabled = absint(
            get_option(
                'reference_knb_syntax_highlighting'
            )
        );

        if (1 === $is_enabled) {
            return true;
        }

        return false;
    }
    /**
     * Get the Syntax Highlighting Style Option and sanitized the value.
     *
     * @return string Returns sanitized value.
     */
    public static function getSyntaxHighlightingStyle()
    {
        return esc_html(
            get_option(
                'reference_knb_syntax_highlighting_style'
            )
        );
    }
    /**
     * Checks if 'Comment Feedback' setting is enabled.
     *
     * @return boolean Returns true if 'Comment Feedback' setting is enabled.
     */
    public static function getCommentFeedback()
    {
        $is_enabled = absint(
            get_option(
                'reference_knb_comment_feedback'
            )
        );

        if (1 === $is_enabled) {
            return true;
        }

        return false;
    }
    /**
     * Checks if the 'Table of Contents' setting is enabled.
     *
     * @return boolean Returns true if 'Table of Contents' setting is enabled.
     */
    public static function getTableOfContent()
    {
        $is_enabled = absint(
            get_option(
                'reference_knb_toc'
            )
        );

        if (1 === $is_enabled) {
            return true;
        }

        return false;
    }
    /**
     * Checks if the 'Breadcrumbs' setting is enabled.
     *
     * @return boolean Returns true if 'Breadcrumbs' setting is enabled.
     */
    public static function getBreadcrumbs()
    {
        $is_enabled = absint(
            get_option(
                'reference_knb_breadcrumbs'
            )
        );

        if (1 === $is_enabled) {
            return true;
        }

        return false;
    }
    /**
     * Checks if the 'Sticky Kit' setting is enabled.
     *
     * @return boolean Returns true if the 'Sticky Kit' setting is enabled.
     */
    public static function getStickyKit()
    {
        $is_enabled = absint(
            get_option(
                'reference_knb_sticky_kit'
            )
        );

        if (1 === $is_enabled) {
            return true;
        }

        return false;
    }
    /**
     * Get the Breadcrumbs Separator Option and sanitized the value.
     *
     * @return string Returns sanitized value.
     */
    public static function getBreadcrumbsSeparator()
    {
        return esc_html(
            get_option(
                'reference_knb_breadcrumbs_separator'
            )
        );
    }
    /**
     * Get the Category Excerpt Option and convert to absolute integer.
     *
     * @return integer Returns absolute integer.
     */
    public static function getCategoryExcerpt()
    {
        return absint(
            get_option(
                'reference_knb_category_excerpt'
            )
        );
    }
    /**
     * Get the Post per Page Option and convert to absolute integer.
     *
     * @return integer Returns absolute integer.
     */
    public static function getPostsPerPage()
    {
        return absint(
            get_option(
                'reference_knb_posts_per_page'
            )
        );
    }
}
