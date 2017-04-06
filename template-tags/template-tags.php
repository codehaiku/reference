<?php
/**
 * Reference Template Tags
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference-wordpress-knowledgebase
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */

if (! defined('ABSPATH')) {
    return;
}

/**
 * Displays the reference breadcrumb.
 *
 * @since  1.0.0
 * @return void
 */
function reference_breadcrumb()
{

    $breadcrumb = new \DSC\Reference\Breadcrumbs();
    $option = new \DSC\Reference\Options();

    $reference_plural_option = $option->getKnbPlural();
    $breadcrumbs_option = $option->getBreadcrumbs();
    $breadcrumbs_separator_option = $option->getBreadcrumbsSeparator();

    $breadcrumb_option_meta = get_post_meta(
        get_the_ID(),
        '_knowledgebase_breadcrumbs_meta_key',
        true
    );

    $args = array(
        'post_type'           => 'knowledgebase',
        'taxonomy'            => 'knb-categories',
        'separator_icon'      => ' ' . $breadcrumbs_separator_option . ' ',
        'breadcrumbs_id'      => 'breadcrumbs-wrap',
        'breadcrumbs_classes' => 'breadcrumb-trail breadcrumbs',
        'home_title'          => $reference_plural_option,
    );

    if (empty($breadcrumb_option_meta) && true === $breadcrumbs_option) {
        $breadcrumb_option_meta = 'enable';
    }
    if (true === $breadcrumbs_option) {
        if (reference_is_option_meta_enabled($breadcrumb_option_meta)) {
            echo $breadcrumb->render($args);
        }
    }
    return;
}
/**
 * Displays the Reference category thumbnail.
 *
 * @since  1.0.0
 * @return void
 */
function reference_category_thumbnail()
{
     $archive_thumbnail = new \DSC\Reference\Helper;

     echo $archive_thumbnail->getCategoryThumbnail();

     return;
}
/**
 * Displays the Reference search form.
 *
 * @since  1.0.0
 * @return void
 */
function reference_search_form()
{
    include plugin_dir_path(__FILE__) . '../templates/search-form.php';
}
/**
 * Displays the Reference category archive category lists.
 *
 * @since  1.0.0
 * @return void
 */
function reference_child_categories()
{
    $child_category = new \DSC\Reference\Helper;

    echo $child_category->knowledgebaseCategoryChildList();

    return;
}
/**
 * Displays the Reference archive category lists.
 *
 * @since  1.0.0
 * @return void
 */
function reference_archive_categories()
{
    $child_category = new \DSC\Reference\Helper;

    echo $child_category->knowledgebaseCategoryList();

    return;
}
/**
 * Displays the Reference knowledgebase count.
 *
 * @since  1.0.0
 * @return void
 */
function reference_knowledgebase_count()
{
    $knowledgebase_count = new \DSC\Reference\Helper;

    $option = new \DSC\Reference\Options();

    $knowledgebase = $option->getKnbPlural();

    $terms_ids = $knowledgebase_count->getTermIds();

    $count = $knowledgebase_count->getPostCount();

    $name = single_term_title('', false);

    $output = '';

    if ($count <= 1) {
        $knowledgebase = $option->getKnbSingular();
    }
    if (is_post_type_archive('knowledgebase')) {
        $name = $knowledgebase;
        $count = $knowledgebase_count->getPostCount($terms_ids);
    }

    $output = '<p class="reference-knowledgebase-count">' .
        sprintf(
            esc_html__('%1$d %2$s found under "%3$s"', 'reference'),
            $count,
            $knowledgebase,
            $name
        ) .
    '</p>';
    echo $output;

    return;
}
/**
 * Displays the Reference category navigation.
 *
 * @since  1.0.0
 * @return void
 */
function reference_navigation()
{
    $knowledgebase_count = new \DSC\Reference\Helper;
    $enable_tax_query = true;
    $count = $knowledgebase_count->getPostCount();

    if (is_post_type_archive('knowledgebase')) {
        $count = $knowledgebase_count->getPostCount('', false);
    }

    $args = array(
        'base'      => str_replace(
            $count,
            '%#%',
            esc_url(get_pagenum_link($count))
        ),
        'format'    => '?paged=%#%',
        'current'   => max(1, get_query_var('paged')),
        'show_all'  => false,
        'end_size'  => 1,
        'mid_size'  => 2,
        'prev_next' => true,
        'add_args'  => false,
    );

    ?>

    <nav
        class="navigation reference-navigation"
        role="navigation">
            <?php echo paginate_links($args); ?>
    </nav>

    <?php return; ?>

<?php }
/**
 * Displays the Reference comment feedback.
 *
 * @since  1.0.0
 * @return void
 */
function reference_display_comment_feedback()
{

    $option = new \DSC\Reference\Options();
    $comment_feedback_option = $option->getCommentFeedback();
    $comment_feedback_meta = get_post_meta(
        get_the_ID(),
        '_knowledgebase_comment_feedback_meta_key',
        true
    );

    if (empty($comment_feedback_meta) && true === $comment_feedback_option) {
        $comment_feedback_meta = 'enable';
    }
    ?>

    <?php if (true === $comment_feedback_option) { ?>

        <?php if (reference_is_option_meta_enabled($comment_feedback_meta)) { ?>
            <div
                class="reference-feedback-container"
                id="reference-feedback"
                data-value="<?php echo get_the_ID(); ?>"
            >
                <p lass="feedback-header">
                    <?php esc_html_e(
                        'Was this article helpful?',
                        'reference'
                    ); ?>
                </p>
                <span class="feedback-response-link">
                    <?php if (reference_is_ip_exist()) { ?>
                        <a href="" id="reference-confirm-feedback">
                            <?php esc_html_e('Yes', 'reference'); ?>
                        </a>
                        <?php esc_html_e(' / ', 'reference'); ?>
                        <a href="" id="reference-decline-feedback">
                            <?php esc_html_e('No', 'reference'); ?>
                        </a>
                    <?php } else { ?>
                        <?php esc_html_e(
                            'You have already voted.',
                            'reference'
                        ); ?>
                    <?php } ?>
                </span>
                <small class="feedback-results">
                    <span id="confirmed_amount">
                        <?php reference_upvote_comment_feedback_value(); ?>
                    </span>
                    <?php esc_html_e(' said "Yes" and ', 'reference'); ?>
                    <span id="declined_amount">
                        <?php reference_downvote_comment_feedback_value(); ?>
                    </span>
                    <?php esc_html_e(' said "No"', 'reference'); ?>
                </small>
                <?php wp_nonce_field(
                    'reference-feedback-ajax-nonce',
                    'reference-feedback-security'
                ); ?>
            </div>

        <?php } ?>

    <?php } ?>

    <?php return; ?>

<?php }
/**
 * Displays the number of Reference Upvote Comment Feedback.
 *
 * @since  1.0.0
 * @return void
 */
function reference_upvote_comment_feedback_value()
{
    $confirm_value_meta = absint(get_post_meta(
        get_the_ID(),
        '_knowledgebase_feedback_confirm_meta_key',
        true
    ));

    if (empty($confirm_value_meta)) {
        $confirm_value_meta = esc_html__('No one', 'reference');
    }

    echo $confirm_value_meta;

    return;
}
/**
 * Displays the number of Reference Downvote Comment Feedback.
 *
 * @since  1.0.0
 * @return void
 */
function reference_downvote_comment_feedback_value()
{
    $decline_value_meta = absint(get_post_meta(
        get_the_ID(),
        '_knowledgebase_feedback_decline_meta_key',
        true
    ));

    if (empty($decline_value_meta)) {
        $decline_value_meta = esc_html__('no one', 'reference');
    }

    echo $decline_value_meta;

    return;
}
/**
 * Check if the visitors has voted by getting his or her IP address and
 * checking if it exist.
 *
 * @since  1.0.0
 * @return boolean Returns true if IP address does not exist.
 */
function reference_is_ip_exist()
{
    $ip = new \DSC\Reference\Helper;
    $user_ip = $ip->getIpAddress();
    $ip_addresses = get_post_meta(
        get_the_ID(),
        '_knowledgebase_feedback_ip_meta_key',
        true
    );
    if (empty($ip_addresses)) {
        $ip_addresses = array();
    }

    if (! in_array($user_ip, $ip_addresses)) {
        return true;
    }

    return;
}

/**
 * Checks if an option is enabled.
 *
 * @param string $key The key of the option meta.
 *
 * @since  1.0.0
 * @return boolean Returns true if option is enable. Otherwise returns false
 *                 if option is disabled.
 */
function reference_is_option_meta_enabled($key = '')
{
    $option = array(
        'enable' => true,
        'disable' => false,
    );

    return $option[$key];
}
/**
 * Displays the Reference category lists in the reference shortcode.
 *
 * @param array   $categories    Parent categories.
 * @param int     $columns       The number of columns.
 * @param string  $show_category Show or hide the category lists.
 *
 * @since  1.0.0
 * @return void
 */
function reference_loop_category(
    $categories = array(),
    $columns = 3,
    $show_category = 'true'
) {

    $category = new \DSC\Reference\KnowledgebaseShortcodes;

    if ('true' === $show_category) {
        echo $category->referenceShortcodeCategoryList(
            $categories,
            $columns,
            $show_category
        );
    }

    return;
}
/**
 * Returns the Syntax Highlighting Style.
 *
 * @since  1.0.0
 * @return string $styles Returns the Syntax Highlighting Style.
 */
function reference_get_syntax_highlighting_style()
{
    $styles = new \DSC\Reference\Helper;

    return $styles->getSyntaxHighlightingStyle();
}
/**
 * Displays the Reference no search result section.
 *
 * @param string $message The no search result message.
 *
 * @since  1.0.0
 * @return void
 */
function reference_no_search_result($message = '')
{

    $helper = new \DSC\Reference\Helper;
    $options = new \DSC\Reference\Options;
    $knowledgebase = $options->getKnbSingular();

    $reference_query = $helper->globalWpQuery();
    $searched_items = $reference_query->found_posts;
    $term_title = single_term_title(" in ", false);


    if ($searched_items < 2) {
        $knowledgebase = $options->getKnbPlural();
    }

    if (empty($message)) {
        if (0 === $searched_items) {
            $message = sprintf(
                esc_html('There are no %s found%s.', 'reference'),
                $knowledgebase,
                $term_title
            );
        } else {
            $message = sprintf(
                esc_html('There are %d %s found%s.', 'reference'),
                $searched_items,
                $knowledgebase,
                $term_title
            );
        }
    }
    ?>
    <div id="reference-message" class="notification">
        <p><?php echo $message; ?></p>
    </div>

    <?php return; ?>

<?php }
