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

    $breadcrumb_option = get_post_meta(get_the_ID(), '_knowledgebase_breadcrumbs_meta_key', true);

	$args = array(
        'post_type'           => 'knowledgebase',
        'taxonomy'            => 'knb-categories',
        'separator_icon'      => ' ' . get_option('reference_knb_breadcrumbs_separator') . ' ',
        'breadcrumbs_id'      => 'breadcrumbs-wrap',
        'breadcrumbs_classes' => 'breadcrumb-trail breadcrumbs',
        'home_title'          => get_option('reference_knb_plural'),
	);

    if ((bool)get_option('reference_knb_breadcrumbs') === true) {

        if (is_option_enabled($breadcrumb_option)) {

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
    $knowledgebase = get_option('reference_knb_plural');
    $count = $knowledgebase_count->get_post_count();
    $name = single_term_title("", false);
    $output = '';

    if ($count <= 1) {
        $knowledgebase = get_option('reference_knb_singular');
    }


    $output = '<p class="knowledgebase-count">' . sprintf(esc_html__('There are %d %s found under "%s"', 'reference'), $count, $knowledgebase, $name) . '</p>';
    echo $output;
}

function knb_display_feedback()
{ ?>
    <?php $comment_feedback_option = get_post_meta(get_the_ID(), '_knowledgebase_comment_feedback_meta_key', true); ?>

    <?php if ((bool)get_option('reference_knb_comment_feedback') === true) { ?>

        <?php if (is_option_enabled($comment_feedback_option)) { ?>

            <div class="reference-feedback-container" id="reference-feedback" data-value="<?php echo get_the_ID(); ?>">
                <p lass="feedback-header"><?php esc_html_e('Was this article helpful?', 'reference'); ?></p>
                <div class="feedback-response-link">
                    <?php if (is_ip_listed()) {?>
                        <a href="" id="reference-confirm-feedback"><?php esc_html_e('Yes', 'reference'); ?></a>/<a href="" id="reference-decline-feedback"><?php esc_html_e('No', 'reference'); ?></a>
                    <?php } else { ?>
                        <?php esc_html_e('You have already voted.', 'reference'); ?>
                    <?php } ?>
                </div>
                <small class="feedback-results">
                    <span id="confirmed_amount"><?php get_feedback_confirm_amount(); ?></span><?php esc_html_e(' said "Yes" while ', 'reference'); ?><span id="declined_amount"><?php get_feedback_decline_amount(); ?></span><?php esc_html_e(' said "No"', 'reference'); ?>
                </small>
                <?php wp_nonce_field( 'reference-feedback-ajax-nonce', 'reference-feedback-security' ); ?>
            </div>

        <?php } ?>

    <?php } ?>

<?php }

function get_feedback_confirm_amount()
{
    $confirm_value = get_post_meta(get_the_ID(), '_knowledgebase_feedback_confirm_meta_key', true);

    if(empty($confirm_value)) {
        $confirm_value = 0;
    }
    echo $confirm_value;
}
function get_feedback_decline_amount()
{
    $decline_value = get_post_meta(get_the_ID(), '_knowledgebase_feedback_decline_meta_key', true);

    if(empty($decline_value)) {
        $decline_value = 0;
    }

    echo $decline_value;
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

/**
 * For Development Purposes (Remove after Finished)
 */
function display_ips()
{
    $ip_addresses = (array) get_post_meta(get_the_ID(), '_knowledgebase_feedback_ip_meta_key', true);

    echo '<pre>';
        var_dump($ip_addresses);
    echo '</pre>';
}
