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
    const REFERENCE_KNB_SLUG = 'reference_knb_slug';
    const REFERENCE_KNB_CATEGORY_SLUG = 'reference_knb_category_slug';
    const REFERENCE_KNB_TAG_SLUG = 'reference_knb_tag_slug';
    const REFERENCE_KNB_SINGULAR = 'reference_knb_singular';
    const REFERENCE_KNB_PLURAL = 'reference_knb_plural';
    const REFERENCE_KNB_CATEGORY_SINGULAR = 'reference_knb_category_singular';
    const REFERENCE_KNB_CATEGORY_PLURAL = 'reference_knb_category_plural';
    const REFERENCE_KNB_TAG_SINGULAR = 'reference_knb_tag_singular';
    const REFERENCE_KNB_TAG_PLURAL = 'reference_knb_tag_plural';
    const REFERENCE_KNB_ARCHIVE_COLUMN = 'reference_knb_archive_column';
    const REFERENCE_KNB_SYNTAX_HIGHLIGHTING = 'reference_knb_syntax_highlighting';
    const REFERENCE_KNB_SYNTAX_HIGHLIGHTING_STYLE = 'reference_knb_syntax_highlighting_style';
    const REFERENCE_KNB_COMMENT_FEEDBACK = 'reference_knb_comment_feedback';
    const REFERENCE_KNB_TOC = 'reference_knb_toc';
    const REFERENCE_KNB_BREADCRUMBS = 'reference_knb_breadcrumbs';
    const REFERENCE_KNB_STICKY_KIT = 'reference_knb_sticky_kit';
    const REFERENCE_KNB_BREADCRUMBS_SEPARATOR = 'reference_knb_breadcrumbs_separator';
    const REFERENCE_KNB_CATEGORY_EXCERPT = 'reference_knb_category_excerpt';
    const REFERENCE_KNB_POSTS_PER_PAGE = 'reference_knb_posts_per_page';

    const REFERENCE_DEFAULTS = array(
        self::REFERENCE_KNB_SLUG => 'dsc-knowledgebase',
        self::REFERENCE_KNB_CATEGORY_SLUG => 'dsc-knb-categories',
        self::REFERENCE_KNB_TAG_SLUG => 'dsc-knb-tags',
        self::REFERENCE_KNB_SINGULAR => 'Knowledgebase',
        self::REFERENCE_KNB_PLURAL => 'Knowledgebase',
        self::REFERENCE_KNB_CATEGORY_SINGULAR => 'Knowledgebase Category',
        self::REFERENCE_KNB_CATEGORY_PLURAL => 'Knowledgebase Categories',
        self::REFERENCE_KNB_TAG_SINGULAR => 'Knowledgebase Tag',
        self::REFERENCE_KNB_TAG_PLURAL => 'Knowledgebase Tags',
        self::REFERENCE_KNB_ARCHIVE_COLUMN => '3',
        self::REFERENCE_KNB_SYNTAX_HIGHLIGHTING => true,
        self::REFERENCE_KNB_SYNTAX_HIGHLIGHTING_STYLE => 'dark',
        self::REFERENCE_KNB_COMMENT_FEEDBACK => true,
        self::REFERENCE_KNB_TOC => true,
        self::REFERENCE_KNB_BREADCRUMBS => true,
        self::REFERENCE_KNB_STICKY_KIT => true,
        self::REFERENCE_KNB_BREADCRUMBS_SEPARATOR => '/',
        self::REFERENCE_KNB_CATEGORY_EXCERPT => '55',
        self::REFERENCE_KNB_POSTS_PER_PAGE => '10',
    );

    /**
     * Set the default of the Reference Settings.
     *
     * @param string $option_key The option key to get the value of an option.
     *
     * @return string $option_value The value of the option. Otherwise return
     *                              default value.
     */
    public static function getOption($option_key, $is_checkbox = false) {
        $option_value = '';

        if (!empty(get_option($option_key)) || true === $is_checkbox) {
            $option_value = get_option($option_key);
        }

        if (empty(get_option($option_key)) && false === get_option($option_key)) {
            $option_value = self::REFERENCE_DEFAULTS[$option_key];
        }

        return $option_value;
    }
    /**
     * Sanitized the value of $option_value to be a valid URL.
     *
     * @param string $option_value The slug value to be sanitized.
     *
     * @return string $slug Returns the sanitized slug.
     */
    public static function sanitizedSlug($option_value) {
        $sanitize_slug = sanitize_title(
            $option_value
        );

        $slug = filter_var(
            $sanitize_slug,
            FILTER_SANITIZE_URL
        );

        return $slug;
    }
    /**
     * Sanitized the value of $option_value.
     *
     * @param string $option_value The option value to be sanitized.
     *
     * @return string $sanitized_string Returns the sanitized value.
     */
    public static function sanitizedString($option_value) {

        $sanitized_string = self::sanitizedSpecialChars(
            filter_var(
                $option_value,
                FILTER_SANITIZE_STRING
            )
        );

        return $sanitized_string;
    }
    /**
     * Sanitized the value of $option_value and gets the absolute integer value.
     *
     * @param int $option_value The option value to be sanitized.
     *
     * @return int $sanitized_integer Returns the sanitized absolute integer.
     */
    public static function sanitizedInt($option_value) {

        $sanitized_integer = absint(
            self::sanitizedSpecialChars(
                filter_var(
                    $option_value,
                    FILTER_SANITIZE_NUMBER_INT
                )
            )
        );

        return $sanitized_integer;
    }

    /**
     * Sanitized the value of $constant.
     *
     * @param string $option_value The option value to be sanitized.
     *
     * @return string $sanitized_input Returns the sanitized string.
     */
    public static function sanitizedSpecialChars($option_value) {
        $sanitized_input = filter_var(
            $option_value,
            FILTER_SANITIZE_SPECIAL_CHARS
        );
        return $sanitized_input;
    }
    /**
     * Sanitized $option_value to be absolute integer and returns boolean value.
     *
     * @param int $option_value The option value to be sanitized.
     *
     * @return boolean Returns true if is equal to 1. Otherwise, false if equals
     *              to 0.
     */
    public static function sanitizedBool($option_value) {
        $bool = self::sanitizedInt(
            $option_value
        );

        if (1 === $bool) {
            return true;
        }
        return false;
    }

    /**
     * Get the Knowledgebase Slug Option and sanitized the slug.
     *
     * @return string Returns sanitized slug.
     */
    public static function getKnbSlug()
    {
        return self::sanitizedSlug(self::getOption(self::REFERENCE_KNB_SLUG));
    }
    /**
     * Get the Knowledgebase Category Slug Option and sanitized the slug.
     *
     * @return string Returns sanitized slug.
     */
    public static function getCategorySlug()
    {
        return self::sanitizedSlug(self::getOption(self::REFERENCE_KNB_CATEGORY_SLUG));
    }
    /**
     * Get the Knowledgebase Tag Slug Option and sanitized the slug. If setting
     * is empty set default.
     *
     * @return string Returns sanitized slug.
     */
    public static function getTagSlug()
    {
        return self::sanitizedSlug(self::getOption(self::REFERENCE_KNB_TAG_SLUG));
    }

    /**
     * Get the Knowledgebase Singular Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string Returns sanitized value.
     */
    public static function getKnbSingular()
    {
        return self::sanitizedString(self::getOption(self::REFERENCE_KNB_SINGULAR));
    }
    /**
     * Get the Knowledgebase Plural Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string Returns sanitized value.
     */
    public static function getKnbPlural()
    {
        return self::sanitizedString(self::getOption(self::REFERENCE_KNB_PLURAL));
    }
    /**
     * Get the Knowledgebase Category Singular Option and sanitized the value.
     * If setting is empty set default.
     *
     * @return string Returns sanitized value.
     */
    public static function getCategorySingular()
    {
        return self::sanitizedString(self::getOption(self::REFERENCE_KNB_CATEGORY_SINGULAR));
    }
    /**
     * Get the Knowledgebase Category Plural Option and sanitized the value. If
     * setting is empty set default.
     *
     * @return string Returns sanitized value.
     */
    public static function getCategoryPlural()
    {
        return self::sanitizedString(self::getOption(self::REFERENCE_KNB_CATEGORY_PLURAL));
    }
    /**
     * Get the Knowledgebase Tag Singular Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string Returns sanitized value.
     */
    public static function getTagSingular()
    {
        return self::sanitizedString(self::getOption(self::REFERENCE_KNB_TAG_SINGULAR));
    }
    /**
     * Get the Knowledgebase Tag Plural Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string Returns sanitized value.
     */
    public static function getTagPlural()
    {
        return self::sanitizedString(self::getOption(self::REFERENCE_KNB_TAG_PLURAL));
    }

    /**
     * Get the Archive Columns Option and convert to absolute integer. If setting
     * is empty set default.
     *
     * @return integer Returns sanitizedInt absolute integer.
     */
    public static function getArchiveColumn()
    {
        return self::sanitizedInt(self::getOption(self::REFERENCE_KNB_ARCHIVE_COLUMN));
    }
    /**
     * Checks if 'Syntax Highlighting' setting is enabled. If setting
     * is empty set default.
     *
     * @return boolean Returns true if 'Syntax Highlighting' setting is
     *                 enabled.
     */
    public static function getSyntaxHighlighting()
    {
        return self::sanitizedBool(self::getOption(self::REFERENCE_KNB_SYNTAX_HIGHLIGHTING, true));
    }
    /**
     * Get the Syntax Highlighting Style Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string Returns sanitized value.
     */
    public static function getSyntaxHighlightingStyle()
    {
        return self::sanitizedString(self::getOption(self::REFERENCE_KNB_SYNTAX_HIGHLIGHTING_STYLE));
    }
    /**
     * Checks if 'Comment Feedback' setting is enabled. If setting
     * is empty set default.
     *
     * @return boolean Returns true if 'Comment Feedback' setting is
     *                 enabled.
     */
    public static function getCommentFeedback()
    {
        return self::sanitizedBool(self::getOption(self::REFERENCE_KNB_COMMENT_FEEDBACK, true));
    }
    /**
     * Checks if the 'Table of Contents' setting is enabled. If setting
     * is empty set default.
     *
     * @return boolean Returns true if 'Table of Contents' setting is
     *                 enabled.
     */
    public static function getTableOfContent()
    {
        return self::sanitizedBool(self::getOption(self::REFERENCE_KNB_TOC, true));
    }
    /**
     * Checks if the 'Breadcrumbs' setting is enabled. If setting
     * is empty set default.
     *
     * @return boolean Returns true if 'Breadcrumbs' setting is enabled.
     */
    public static function getBreadcrumbs()
    {
        return self::sanitizedBool(self::getOption(self::REFERENCE_KNB_BREADCRUMBS, true));
    }
    /**
     * Checks if the 'Sticky Kit' setting is enabled. If setting
     * is empty set default.
     *
     * @return boolean Returns true if the 'Sticky Kit' setting is enabled.
     */
    public static function getStickyKit()
    {
        return self::sanitizedBool(self::getOption(self::REFERENCE_KNB_STICKY_KIT, true));
    }
    /**
     * Get the Breadcrumbs Separator Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string Returns sanitized value.
     */
    public static function getBreadcrumbsSeparator()
    {
        return self::sanitizedString(self::getOption(self::REFERENCE_KNB_BREADCRUMBS_SEPARATOR));
    }
    /**
     * Get the Category Excerpt Option and convert to absolute integer. If setting
     * is empty set default.
     *
     * @return integer Returns sanitized absolute integer.
     */
    public static function getCategoryExcerpt()
    {
        return self::sanitizedInt(self::getOption(self::REFERENCE_KNB_CATEGORY_EXCERPT));
    }
    /**
     * Get the Post per Page Option and convert to absolute integer. If setting
     * is empty set default.
     *
     * @return integer $posts_per_page Returns sanitized absolute integer.
     */
    public static function getPostsPerPage()
    {
        $blog_posts_per_page = self::sanitizedInt('posts_per_page');
        $posts_per_page = self::sanitizedInt(self::getOption(self::REFERENCE_KNB_POSTS_PER_PAGE));

        if (0 === $posts_per_page) {
            $posts_per_page = $blog_posts_per_page;
        }

        return absint($posts_per_page);
    }
}
