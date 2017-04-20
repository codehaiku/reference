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
     * @param string $constant The constant key to get the value of an option.
     *
     * @return void
     */
    public static function getOption($constant) {
        $option = get_option($constant);

        return $option;
    }
    /**
     * Set the default of the Reference Settings if empty.
     *
     * @param string $constant The constant key to update the value of an option.
     *
     * @return void
     */
    public static function setOption($constant) {
        if (self::isOptionEmpty(self::getOption($constant))) {
            // update_option($constant, self::REFERENCE_DEFAULTS[$constant]);
        }
        return;
    }
    /**
     * Sanitized the value of $constant to be a valid URL.
     *
     * @param string $constant The constant value to be sanitized.
     *
     * @return string Returns the sanitized slug.
     */
    public static function sanitizedSlug($constant) {
        $sanitize_constant = sanitize_title(
            self::getOption($constant)
        );

        $slug = filter_var(
            $sanitize_constant,
            FILTER_SANITIZE_URL
        );

        return $slug;
    }
    /**
     * Sanitized the value of $constant.
     *
     * @param string $constant The constant value to be sanitized.
     *
     * @return string Returns the sanitized value.
     */
    public static function sanitizedString($constant) {

        $string = self::sanitizedSpecialChars(
            filter_var(
                self::getOption(
                    $constant
                ),
                FILTER_SANITIZE_STRING
            )
        );

        return $string;
    }
    /**
     * Sanitized the value of $constant and gets the absolute integer value.
     *
     * @param int $constant The constant value to be sanitized.
     *
     * @return string Returns the sanitized absolute integer.
     */
    public static function sanitizedInt($constant) {

        $integer = absint(
            self::sanitizedSpecialChars(
                filter_var(
                    self::getOption(
                        $constant
                    ),
                    FILTER_SANITIZE_NUMBER_INT
                )
            )
        );

        return $integer;
    }

    /**
     * Sanitized the value of $constant.
     *
     * @param string $constant The constant value to be sanitized.
     *
     * @return string Returns the sanitized string.
     */
    public static function sanitizedSpecialChars($constant) {
        $input = filter_var(
            $constant,
            FILTER_SANITIZE_SPECIAL_CHARS
        );
        return $input;
    }
    /**
     * Sanitized $constant to be absolute integer and returns boolean value.
     *
     * @param int $constant The constant value to be sanitized.
     *
     * @return boolean Returns true if is equal to 1. Otherwise, false if equals
     *              to 0.
     */
    public static function sanitizedBool($constant) {
        $bool = self::sanitizedInt(
            $constant
        );
        if (1 === $bool) {
            return true;
        }
        return false;
    }
    /**
     * Checks if $value is empty.
     *
     * @param mixed $value The value to be check.
     *
     * @return boolean Returns true if empty. Otherwise, false if not.
     */
    public static function isOptionEmpty($value) {
        if (0 !== strlen($value)) {
            return false;
        }
        return true;
    }

    /**
     * Get the Knowledgebase Slug Option and sanitized the slug.
     *
     * @return string $slug Returns sanitized slug.
     */
    public static function getKnbSlug()
    {
        $constant = self::REFERENCE_KNB_SLUG;
        $slug = self::sanitizedSlug($constant);

        self::setOption($constant);

        return $slug;
    }
    /**
     * Get the Knowledgebase Category Slug Option and sanitized the slug.
     *
     * @return string $slug Returns sanitized slug.
     */
    public static function getCategorySlug()
    {
        $constant = self::REFERENCE_KNB_CATEGORY_SLUG;
        $slug = self::sanitizedSlug($constant);

        self::setOption($constant);

        return $slug;
    }
    /**
     * Get the Knowledgebase Tag Slug Option and sanitized the slug. If setting
     * is empty set default.
     *
     * @return string $slug Returns sanitized slug.
     */
    public static function getTagSlug()
    {
        $constant = self::REFERENCE_KNB_TAG_SLUG;
        $slug = self::sanitizedSlug($constant);

        self::setOption($constant);

        return $slug;
    }

    /**
     * Get the Knowledgebase Singular Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string $string Returns sanitized value.
     */
    public static function getKnbSingular()
    {
        $constant = self::REFERENCE_KNB_SINGULAR;
        $string = self::sanitizedString($constant);

        self::setOption($constant);

        return $string;
    }
    /**
     * Get the Knowledgebase Plural Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string $string Returns sanitized value.
     */
    public static function getKnbPlural()
    {
        $constant = self::REFERENCE_KNB_PLURAL;
        $string = self::sanitizedString($constant);

        self::setOption($constant);

        return $string;
    }
    /**
     * Get the Knowledgebase Category Singular Option and sanitized the value.
     * If setting is empty set default.
     *
     * @return string $string Returns sanitized value.
     */
    public static function getCategorySingular()
    {
        $constant = self::REFERENCE_KNB_CATEGORY_SINGULAR;
        $string = self::sanitizedString($constant);

        self::setOption($constant);

        return $string;
    }
    /**
     * Get the Knowledgebase Category Plural Option and sanitized the value. If
     * setting is empty set default.
     *
     * @return string $string Returns sanitized value.
     */
    public static function getCategoryPlural()
    {
        $constant = self::REFERENCE_KNB_CATEGORY_PLURAL;
        $string = self::sanitizedString($constant);

        self::setOption($constant);

        return $string;
    }
    /**
     * Get the Knowledgebase Tag Singular Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string $string Returns sanitized value.
     */
    public static function getTagSingular()
    {
        $constant = self::REFERENCE_KNB_TAG_SINGULAR;
        $string = self::sanitizedString($constant);

        self::setOption($constant);

        return $string;
    }
    /**
     * Get the Knowledgebase Tag Plural Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string $string Returns sanitized value.
     */
    public static function getTagPlural()
    {
        $constant = self::REFERENCE_KNB_TAG_PLURAL;
        $string = self::sanitizedString($constant);

        self::setOption($constant);

        return $string;
    }

    /**
     * Get the Archive Columns Option and convert to absolute integer. If setting
     * is empty set default.
     *
     * @return integer $int Returns sanitizedInt absolute integer.
     */
    public static function getArchiveColumn()
    {
        $constant = self::REFERENCE_KNB_ARCHIVE_COLUMN;
        $int = self::sanitizedInt($constant);

        self::setOption($constant);

        return $int;
    }
    /**
     * Checks if 'Syntax Highlighting' setting is enabled. If setting
     * is empty set default.
     *
     * @return boolean $bool Returns true if 'Syntax Highlighting' setting is
     *                       enabled.
     */
    public static function getSyntaxHighlighting()
    {
        $constant = self::REFERENCE_KNB_SYNTAX_HIGHLIGHTING;
        $bool = self::sanitizedBool($constant);

        self::setOption($constant);

        return $bool;
    }
    /**
     * Get the Syntax Highlighting Style Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string $string Returns sanitized value.
     */
    public static function getSyntaxHighlightingStyle()
    {
        $constant = self::REFERENCE_KNB_SYNTAX_HIGHLIGHTING_STYLE;
        $string = self::sanitizedString($constant);

        self::setOption($constant);

        return $string;
    }
    /**
     * Checks if 'Comment Feedback' setting is enabled. If setting
     * is empty set default.
     *
     * @return boolean $bool Returns true if 'Comment Feedback' setting is
     *                       enabled.
     */
    public static function getCommentFeedback()
    {
        $constant = self::REFERENCE_KNB_COMMENT_FEEDBACK;
        $bool = self::sanitizedBool($constant);

        self::setOption($constant);

        return $bool;
    }
    /**
     * Checks if the 'Table of Contents' setting is enabled. If setting
     * is empty set default.
     *
     * @return boolean $bool Returns true if 'Table of Contents' setting is
     *                       enabled.
     */
    public static function getTableOfContent()
    {
        $constant = self::REFERENCE_KNB_TOC;
        $bool = self::sanitizedBool($constant);

        self::setOption($constant);

        return $bool;
    }
    /**
     * Checks if the 'Breadcrumbs' setting is enabled. If setting
     * is empty set default.
     *
     * @return boolean $bool Returns true if 'Breadcrumbs' setting is enabled.
     */
    public static function getBreadcrumbs()
    {
        $constant = self::REFERENCE_KNB_BREADCRUMBS;
        $bool = self::sanitizedBool($constant);

        self::setOption($constant);

        return $bool;
    }
    /**
     * Checks if the 'Sticky Kit' setting is enabled. If setting
     * is empty set default.
     *
     * @return boolean $bool Returns true if the 'Sticky Kit' setting is enabled.
     */
    public static function getStickyKit()
    {
        $constant = self::REFERENCE_KNB_STICKY_KIT;
        $bool = self::sanitizedBool($constant);

        self::setOption($constant);

        return $bool;
    }
    /**
     * Get the Breadcrumbs Separator Option and sanitized the value. If setting
     * is empty set default.
     *
     * @return string $string Returns sanitized value.
     */
    public static function getBreadcrumbsSeparator()
    {
        $constant = self::REFERENCE_KNB_BREADCRUMBS_SEPARATOR;
        $string = self::sanitizedString($constant);

        self::setOption($constant);

        return $string;
    }
    /**
     * Get the Category Excerpt Option and convert to absolute integer. If setting
     * is empty set default.
     *
     * @return integer $int Returns sanitized absolute integer.
     */
    public static function getCategoryExcerpt()
    {
        $constant = self::REFERENCE_KNB_CATEGORY_EXCERPT;
        $int = self::sanitizedInt($constant);

        self::setOption($constant);

        return $int;
    }
    /**
     * Get the Post per Page Option and convert to absolute integer. If setting
     * is empty set default.
     *
     * @return integer $int Returns sanitized absolute integer.
     */
    public static function getPostsPerPage()
    {
        $constant = self::REFERENCE_KNB_POSTS_PER_PAGE;
        $blog_posts_per_page = self::sanitizedInt('posts_per_page');
        $int = self::sanitizedInt($constant);
        if (0 === $int) {
            $int = $blog_posts_per_page;
            update_option($constant, $int);
        }

        if (0 !== $int) {
            self::setOption($constant);
        }

        return $int;
    }
}
