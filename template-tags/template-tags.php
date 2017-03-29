<?php
/**
 * This class is executes during plugin activation.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\ActionHooks
 * @package  Reference WordPress Knowledgebase
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference-wordpress-knowledgebase
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 * @since    1.0
 */

function knb_breadcrumb()
{

    $breadcrumb = new \DSC\Reference\Breadcrumbs();
    $option = new \DSC\Reference\Options();

    $reference_plural_option = $option->getKnbPlural();
    $breadcrumbs_option = $option->getBreadcrumbs();
    $breadcrumbs_separator_option = $option->getBreadcrumbsSeparator();

    $breadcrumb_option_meta = get_post_meta(get_the_ID(), '_knowledgebase_breadcrumbs_meta_key', true);

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

        if (is_option_enabled($breadcrumb_option_meta)) {

            echo $breadcrumb->render( $args );

        }
    }
}
function knb_category_thumbnail()
{
     $archive_thumbnail = new \DSC\Reference\Helper;

     echo $archive_thumbnail->the_category_thumbnail();
}
function knb_search_form()
{
    require_once plugin_dir_path( __FILE__ ) . '../templates/search-form.php';
}
function knb_child_categories()
{
    $child_category = new \DSC\Reference\Helper;

    echo $child_category->reference_display_child_category_list();
}
function knb_archive_categories()
{
    $child_category = new \DSC\Reference\Helper;

    echo $child_category->reference_display_knowledgebase_category_list();
}
function knb_knowledgebase_count()
{
    $knowledgebase_count = new \DSC\Reference\Helper;
    $option = new \DSC\Reference\Options();
    $knowledgebase = $option->getKnbPlural();
    $count = $knowledgebase_count->get_post_count();
    $name = single_term_title("", false);
    $output = '';

    if ($count <= 1) {
        $knowledgebase = $option->getKnbSingular();
    }
    if (is_post_type_archive('knowledgebase')) {
        $name = $knowledgebase;
    }

    $output = '<p class="reference-knowledgebase-count">' . sprintf(esc_html__('%d %s found under "%s"', 'reference'), $count, $knowledgebase, $name) . '</p>';
    echo $output;
}

function reference_navigation()
{
    $knowledgebase_count = new \DSC\Reference\Helper;
    $count = $knowledgebase_count->get_post_count();

    $args = array(
    	'base'               => str_replace( $count, '%#%', esc_url( get_pagenum_link( $count ) ) ),
    	'format'             => '?paged=%#%',
    	'current'            => max( 1, get_query_var('paged') ),
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

    <nav class="navigation reference-navigation" role="navigation"><?php echo paginate_links( $args ); ?></nav>
<?php }

function knb_display_feedback()
{ ?>
    <?php
    $option = new \DSC\Reference\Options();
    $comment_feedback_option = $option->getCommentFeedback();

    $comment_feedback_meta = get_post_meta(get_the_ID(), '_knowledgebase_comment_feedback_meta_key', true);

    if (empty($comment_feedback_meta) && (bool)$comment_feedback_option === true) {
        $comment_feedback_meta = 'enable';
    }

    ?>
    <?php if ((bool)$comment_feedback_option === true) { ?>

        <?php if (is_option_enabled($comment_feedback_meta)) { ?>

            <div class="reference-feedback-container" id="reference-feedback" data-value="<?php echo get_the_ID(); ?>">
                <p lass="feedback-header"><?php esc_html_e('Was this article helpful?', 'reference'); ?></p>
                <span class="feedback-response-link">
                    <?php if (is_ip_listed()) {?>
                        <a href="" id="reference-confirm-feedback"><?php esc_html_e('Yes', 'reference'); ?></a><?php esc_html_e(' / ', 'reference'); ?><a href="" id="reference-decline-feedback"><?php esc_html_e('No', 'reference'); ?></a>
                    <?php } else { ?>
                        <?php esc_html_e('You have already voted.', 'reference'); ?>
                    <?php } ?>
                </span>
                <small class="feedback-results">
                    <span id="confirmed_amount"><?php get_feedback_confirm_amount(); ?></span><?php esc_html_e(' said "Yes" and ', 'reference'); ?><span id="declined_amount"><?php get_feedback_decline_amount(); ?></span><?php esc_html_e(' said "No"', 'reference'); ?>
                </small>
                <?php wp_nonce_field( 'reference-feedback-ajax-nonce', 'reference-feedback-security' ); ?>
            </div>

        <?php } ?>

    <?php } ?>

<?php }

function get_feedback_confirm_amount()
{
    $confirm_value_meta = get_post_meta(get_the_ID(), '_knowledgebase_feedback_confirm_meta_key', true);

    if(empty($confirm_value_meta)) {
        $confirm_value_meta = esc_html__('No one', 'reference');
    }
    echo $confirm_value_meta;
}
function get_feedback_decline_amount()
{
    $decline_value_meta = get_post_meta(get_the_ID(), '_knowledgebase_feedback_decline_meta_key', true);

    if(empty($decline_value_meta)) {
        $decline_value_meta = esc_html__('no one', 'reference');
    }

    echo $decline_value_meta;
}
function is_ip_listed()
{
    $ip = new \DSC\Reference\Helper;
    $the_ip = $ip->get_ip();
    $ip_addresses = (array) get_post_meta(get_the_ID(), '_knowledgebase_feedback_ip_meta_key', true);

    if (!in_array($the_ip, $ip_addresses)) {
        return true;
    }
}
function is_option_enabled($option = '')
{
    if ($option === 'enable') {
        return true;
    } elseif ($option === 'disable') {
        return false;
    }
}
function reference_loop_category($categories, $columns, $show_category)
{
    $category = new \DSC\Reference\KnowledgebaseShortcodes;

    if ('true' === $show_category) {
        echo $category->reference_shortcode_display_knowledgebase_category_list($categories, $columns, $show_category);
    }
}

function reference_highlighting_style()
{
    $styles = new \DSC\Reference\Helper;
    return $styles->get_highlighting_style();

}
function reference_no_search_result($message = '')
{ ?>
    <?php
    $helper = new \DSC\Reference\Helper;
    $options = new \DSC\Reference\Options;
    $knowledgebase = $options->getKnbSingular();

    $wp_query = $helper->global_wp_query();
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
