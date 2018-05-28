<?php
/**
 * This class executes the Recent Articles Widget
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\RecentArticles
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference
 * @link     github.com/codehaiku/reference
 */

// namespace DSC\Reference;

if (! defined('ABSPATH')) {
    return;
}

/**
 * Initialize the Recent Articles display of the widget
 * and form settings.
 *
 * @category Reference\RecentArticles
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 * @since    1.0.1
 */
final class RecentArticles extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
        parent::__construct(
			'reference_recent_articles', // Base ID
			__( 'Reference: Recent Articles', 'reference' ), // Name
			array( 'description' => __( 'Use this widget to display the most recent articles.', 'reference' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Articles', 'reference' );
        $posts_displayed = ! empty( $instance['posts_displayed'] ) ? $instance['posts_displayed'] : 10;
        $show_post_date = ! empty( $instance['show_post_date'] ) ? $instance['show_post_date'] : 'off';
        /**
         * Query the Form
         */
        $recent_articles_args = array(
        	'numberposts' => $posts_displayed,
        	'orderby' => 'post_date',
        	'order' => 'DESC',
        	'post_type' => 'dsc-knowledgebase',
        	'post_status' => 'publish',
        	'suppress_filters' => true
        );

        $recent_articles = wp_get_recent_posts( $recent_articles_args ); ?>

        <?php echo $args['before_widget']; ?>

            <?php
                if ( ! empty( $instance['title'] ) ) {
                    echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
                }
            ?>

            <ul class="reference-recent-articles-container">
                <?php if ( ! empty ( $recent_articles ) ) : ?>
                    <?php
                    foreach( $recent_articles as $recent_article ) { ?>
                        <?php
                            $post_id = $recent_article['ID'];
                            $post_title = $recent_article['post_title'];
                            $post_date = $recent_article['post_date'];
                            $date_format = apply_filters( 'reference_recent_articles_date_format', 'F d, Y' );
                        ?>

                        <li class="reference-recent-article">
                            <a href="<?php echo esc_url( get_post_permalink( $post_id ) ); ?>" title="<?php echo esc_attr( $post_title ); ?>" class="recent-article-link">
                                <span class="recent-article-title">
                                    <?php echo esc_html( $post_title ); ?>
                                </span>
                            </a>

                            <?php if ( 'on' === $show_post_date ) { ?>
                                <span class="date-posted">
                                    <?php echo esc_html( date( $date_format, strtotime( $post_date ) ) ); ?>
                                </span>
                            <?php } ?>
                        </li>

                        <?php wp_reset_postdata(); ?>

                    <?php } ?>
                <?php else : ?>

                    <li class="reference-message alert alert-info nothing-found">
                        <p>
                            <?php esc_html_e(
                                'There are no articles created.',
                                'reference'
                            ); ?>
                        </p>
                    </li>
                    <div class="clearfix"></div>

                <?php endif; ?>
            </ul>
        <?php echo $args['after_widget'];?>
	<?php }

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Articles', 'reference' );
        $posts_displayed = ! empty( $instance['posts_displayed'] ) ? $instance['posts_displayed'] : 10;
        $show_post_date = ! empty( $instance['show_post_date'] ) ? $instance['show_post_date'] : 'off';

        $checked = '';
        if ( "on" === $show_post_date ) {
                $checked = 'checked';
            };
        ?>
        <p>

            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'reference' ); ?></label>

            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

            <span class="help-text">
                <em><?php echo esc_html__('You can use this field to enter the widget title.', 'reference'); ?></em>
            </span>
        </p>

        <p>

            <label for="<?php echo esc_attr( $this->get_field_id( 'posts_displayed' ) ); ?>"><?php echo esc_html__( 'Number of posts to show:', 'reference' ); ?></label>

            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'posts_displayed' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_displayed' ) ); ?>" type="number" value="<?php echo esc_attr( $posts_displayed ); ?>">

        </p>

        <p>
            <input class="checkbox" <?php echo esc_attr( $checked ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_post_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_post_date' ) ); ?>" type="checkbox">
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_post_date' ) ); ?>"><?php echo esc_html__( 'Display post date?', 'reference' ); ?></label>
        </p>
	<?php }

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved

        $instance = array();

        $instance['title']    = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['posts_displayed'] = ( ! empty( $new_instance['posts_displayed'] ) ) ? strip_tags( absint ($new_instance['posts_displayed'] ) ) : '';
        $instance['show_post_date']    = ( ! empty( $new_instance['show_post_date'] ) ) ? strip_tags( $new_instance['show_post_date'] ) : '';

        return $instance;
	}
}

add_action( 'widgets_init', 'reference_register_recent_articles' );

function reference_register_recent_articles() {

	register_widget( 'RecentArticles' );

	return;
}
