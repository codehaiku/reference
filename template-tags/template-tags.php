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

if (! defined('ABSPATH') ) {
    return;
}

/**
 * Displays the reference breadcrumb.
 *
 * @since  1.0.0
 * @return void
 */
function Reference_breadcrumb()
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

    if (empty($breadcrumb_option_meta) && (bool)$breadcrumbs_option === true) {
        $breadcrumb_option_meta = 'enable';
    }

    if ((bool)$breadcrumbs_option === true) {

        if (Is_Option_enabled($breadcrumb_option_meta)) {

            echo $breadcrumb->render($args);

        }
    }
}
/**
 * Displays the Reference category thumbnail.
 *
 * @since  1.0.0
 * @return void
 */
function Reference_Category_thumbnail()
{
     $archive_thumbnail = new \DSC\Reference\Helper;

     echo $archive_thumbnail->getCategoryThumbnail();
}
/**
 * Displays the Reference search form.
 *
 * @since  1.0.0
 * @return void
 */
function Reference_Search_form()
{
    include_once plugin_dir_path(__FILE__) . '../templates/search-form.php';
}
/**
 * Displays the Reference category archive category lists.
 *
 * @since  1.0.0
 * @return void
 */
function Reference_Child_categories()
{
    $child_category = new \DSC\Reference\Helper;

    echo $child_category->knowledgebaseCategoryChildList();
}
/**
 * Displays the Reference archive category lists.
 *
 * @since  1.0.0
 * @return void
 */
function Reference_Archive_categories()
{
    $child_category = new \DSC\Reference\Helper;

    echo $child_category->knowledgebaseCategoryList();
}
/**
 * Displays the Reference knowledgebase count.
 *
 * @since  1.0.0
 * @return void
 */
function Reference_Knowledgebase_count()
{
    $knowledgebase_count = new \DSC\Reference\Helper;
    $option = new \DSC\Reference\Options();
    $knowledgebase = $option->getKnbPlural();
    $terms_ids = $knowledgebase_count->getTermIds();
    $count = $knowledgebase_count->getPostCount();
    $name = single_term_title("", false);
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
            esc_html__('%d %s found under "%s"', 'reference'),
            $count,
            $knowledgebase,
            $name
        ) .
    '</p>';
    echo $output;
}
/**
 * Displays the Reference category navigation.
 *
 * @since  1.0.0
 * @return void
 */
function Reference_navigation()
{
    $knowledgebase_count = new \DSC\Reference\Helper;
    $count = $knowledgebase_count->getPostCount();

    $args = array(
        'base'               => str_replace(
            $count,
            '%#%',
            esc_url(get_pagenum_link($count))
        ),
        'format'             => '?paged=%#%',
        'current'            => max(1, get_query_var('paged')),
        'show_all'           => false,
        'end_size'           => 1,
        'mid_size'           => 2,
        'prev_next'          => true,
        'prev_text'          => __('« Previous'),
        'next_text'          => __('Next »'),
        'type'               => 'plain',
        'add_args'           => false,
        'add_fragment'       => '',
        'before_page_number' => '',
        'after_page_number'  => ''
    );
    ?>

    <nav
        class="navigation reference-navigation"
        role="navigation">
            <?php echo paginate_links($args); ?>
    </nav>
<?php }
/**
 * Displays the Reference comment feedback.
 *
 * @since  1.0.0
 * @return void
 */
function Reference_Display_feedback()
{
    ?>
    <?php
    $option = new \DSC\Reference\Options();
    $comment_feedback_option = $option->getCommentFeedback();
    $comment_feedback_meta = get_post_meta(
        get_the_ID(),
        '_knowledgebase_comment_feedback_meta_key',
        true
    );

    if (empty($comment_feedback_meta)
        && true === (bool)$comment_feedback_option
    ) {
        $comment_feedback_meta = 'enable';
    }

    ?>
    <?php if (true === (bool)$comment_feedback_option) { ?>

        <?php if (Is_Option_enabled($comment_feedback_meta)) { ?>

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
                    <?php if (Is_IP_listed()) {?>
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
                        <?php Get_Reference_Feedback_Confirm_amount(); ?>
                    </span>
                    <?php esc_html_e(' said "Yes" and ', 'reference'); ?>
                    <span id="declined_amount">
                        <?php Get_Reference_Feedback_Decline_amount(); ?>
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

<?php }
/**
 * Displays the Reference confirmed feedback.
 *
 * @since  1.0.0
 * @return void
 */
function Get_Reference_Feedback_Confirm_amount()
{
    $confirm_value_meta = get_post_meta(
        get_the_ID(),
        '_knowledgebase_feedback_confirm_meta_key',
        true
    );

    if (empty($confirm_value_meta)) {
        $confirm_value_meta = esc_html__('No one', 'reference');
    }
    echo $confirm_value_meta;
}
/**
 * Displays the Reference declined feedback.
 *
 * @since  1.0.0
 * @return void
 */
function Get_Reference_Feedback_Decline_amount()
{
    $decline_value_meta = get_post_meta(
        get_the_ID(),
        '_knowledgebase_feedback_decline_meta_key',
        true
    );

    if (empty($decline_value_meta)) {
        $decline_value_meta = esc_html__('no one', 'reference');
    }

    echo $decline_value_meta;
}
/**
 * Check if the visitors has voted by getting his or her IP address and
 * checking if it exist.
 *
 * @since  1.0.0
 * @return bolean true Returns true if IP address does not exist.
 */
function Is_IP_listed()
{
    $ip = new \DSC\Reference\Helper;
    $the_ip = $ip->getIpAddress();
    $ip_addresses = (array) get_post_meta(
        get_the_ID(),
        '_knowledgebase_feedback_ip_meta_key',
        true
    );

    if (!in_array($the_ip, $ip_addresses)) {
        return true;
    }
}
/**
 * Checks if an option is enabled.
 *
 * @param string $option The value of the option.
 *
 * @since  1.0.0
 * @return bolean true Returns true if option is enable.
 */
function Is_Option_enabled($option = '')
{
    if ($option === 'enable') {
        return true;
    } elseif ($option === 'disable') {
        return false;
    }
}
/**
 * Displays the Reference category lists in the reference shortcode.
 *
 * @param array  $categories    The listed categories.
 * @param int    $columns       The number of columns.
 * @param bolean $show_category Show or hide the category lists.
 *
 * @since  1.0.0
 * @return void
 */
function Reference_Loop_category($categories, $columns, $show_category)
{
    $category = new \DSC\Reference\KnowledgebaseShortcodes;

    if ('true' === $show_category) {
        echo $category->referenceShortcodeCategoryList(
            $categories,
            $columns,
            $show_category
        );
    }
}
/**
 * Returns the Syntax Highlighting Style.
 *
 * @since  1.0.0
 * @return string $styles the Returns the Syntax Highlighting Style.
 */
function Reference_Highlighting_style()
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
 * @return string $styles the Returns the Syntax Highlighting Style.
 */
function Reference_No_Search_result($message = '')
{
    ?>
    <?php
    $helper = new \DSC\Reference\Helper;
    $options = new \DSC\Reference\Options;
    $knowledgebase = $options->getKnbSingular();

    $wp_query = $helper->globalWpQuery();
    $searched_items = $wp_query->found_posts;

    if (0 === $searched_items || 1 === $searched_items) {
        $knowledgebase = $options->getKnbPlural();
    }

    if (empty($message)) {
        if (0 === $searched_items) {
            $message = sprintf(
                esc_html('There are no %s found.', 'reference'),
                $knowledgebase
            );
        } else {
            $message = sprintf(
                esc_html('There are %d %s found.', 'reference'),
                $searched_items,
                $knowledgebase
            );
        }
    }
    ?>
    <div id="reference-message" class="notification">
        <p><?php echo ($message); ?></p>
    </div>
<?php }
