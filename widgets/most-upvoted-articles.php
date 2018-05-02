<?php
/**
 * This class executes the Most Upvoted Article Widget
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\MostUpvotedArticles
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
 * Initialize the Most Upvoted Article display of the widget
 * and form settings.
 *
 * @category Reference\MostUpvotedArticles
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 * @since    1.0.1
 */
final class MostUpvotedArticles extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
        parent::__construct(
			'reference_most_upvoted_articles', // Base ID
			__( 'Reference: Most Upvoted Articles', 'reference' ), // Name
			array( 'description' => __( 'Use this widget to display the most upvoted articles.', 'reference' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

        // Initilize the variables
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Most Upvoted Articles', 'reference' );
        $posts_displayed = ! empty( $instance['posts_displayed'] ) ? $instance['posts_displayed'] : 10;
        $show_post_date = ! empty( $instance['show_post_date'] ) ? $instance['show_post_date'] : 'off';
        $show_upvote = ! empty( $instance['show_upvote'] ) ? $instance['show_upvote'] : 'off';

        if ( 0 !== $posts_displayed || 1 !== $posts_displayed ) {
            $posts_displayed = $posts_displayed + 1;
        }
        /**
         * Query the Form
         */
        $articles_args = array(
            'posts_per_page' => $posts_displayed,
        	'orderby' => 'post_date',
        	'order' => 'DESC',
        	'post_type' => 'dsc-knowledgebase',
        	'post_status' => 'publish',
        	'suppress_filters' => true
        );

        $articles = new WP_Query( $articles_args );
        $article_posts = $articles->posts;
        $most_upvoted_articles = self::get_most_upvoted_article( $article_posts ); ?>

        <?php echo $args['before_widget']; ?>

            <?php
                if ( ! empty( $instance['title'] ) ) {
                    echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
                }
            ?>

            <ul class="reference-most-upvoted-articles-container">
                <?php if ( ! empty ( $most_upvoted_articles ) ) : ?>
                    <?php
                    foreach( $most_upvoted_articles as $article ) { ?>
                        <?php
                            $post_id = $article['ID'];
                            $post_title = $article['post_title'];
                            $post_date = $article['post_date'];
                            $upvote_count = $article['upvote_count'];
                            $date_format = apply_filters( 'reference_most_upvoted_articles_date_format', 'F d, Y' );

                            $upvote_count_message = sprintf(
                                _n( 'with %d upvote', 'with %d upvotes', $upvote_count, 'reference' ),
                                number_format_i18n( $upvote_count )
                            );

                        ?>

                        <li class="reference-most-upvoted-articles">
                            <a href="<?php echo esc_url( get_post_permalink( $post_id ) ); ?>" title="<?php echo esc_attr( $post_title ); ?>" class="most-upvoted-articles-link">
                                <span class="most-upvoted-article-title">
                                    <?php echo esc_html( $post_title ); ?>
                                </span>
                            </a>

                            <?php if ( 'on' === $show_upvote ) { ?>
                                <span class="upvote-count">
                                    <?php echo esc_html( $upvote_count_message ); ?>
                                </span>
                            <?php } ?>

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
                                'There are no upvoted articles.',
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

        // Initilize the variables
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Most Upvoted Articles', 'reference' );
        $posts_displayed = ! empty( $instance['posts_displayed'] ) ? $instance['posts_displayed'] : 10;
        $show_post_date = ! empty( $instance['show_post_date'] ) ? $instance['show_post_date'] : 'off';
        $show_upvote = ! empty( $instance['show_upvote'] ) ? $instance['show_upvote'] : 'off';

        $checked = array(
            'show_post_date' => '',
            'show_upvote' => ''
        );
        if ( "on" == $show_post_date ) {
            $checked['show_post_date'] = 'checked';
        };
        if ( "on" == $show_upvote ) {
            $checked['show_upvote'] = 'checked';
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
            <input class="checkbox" <?php echo esc_attr( $checked['show_post_date'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_post_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_post_date' ) ); ?>" type="checkbox">
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_post_date' ) ); ?>"><?php echo esc_html__( 'Display post date?', 'reference' ); ?></label>
        </p>

        <p>
            <input class="checkbox" <?php echo esc_attr( $checked['show_upvote'] ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_upvote' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_upvote' ) ); ?>" type="checkbox">
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_upvote' ) ); ?>"><?php echo esc_html__( 'Display article upvote count?', 'reference' ); ?></label>
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
        $instance['show_upvote']    = ( ! empty( $new_instance['show_upvote'] ) ) ? strip_tags( $new_instance['show_upvote'] ) : '';

        return $instance;
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function get_most_upvoted_article( $articles ) {
		// processes widget options to be saved

        // Initilize the variables
        $articles_array = '';
        $filtered_articles = array();
        $post_id = '';
        $article_upvote = '';

        if ( ! empty( $articles ) ) {

            // Converts object to array.
            $articles_array = json_decode( json_encode( $articles ), true );

            // Loops to the $articles_array and check each post
            // then push the value to the $filtered_articles if the post has an upvote.
            foreach( $articles_array as $article ) {

                $post_id = $article['ID'];

                // Fetch the upvote of a post base on the $post_id.
                $article_upvote = absint(get_post_meta(
                    $post_id,
                    '_knowledgebase_feedback_confirm_meta_key',
                    true
                ));

                // Adds an upvote index
                $article['upvote_count'] = $article_upvote;

                // Checks if the post has upvote then add it to the $filtered_articles
                if ( 0 !== $article_upvote ) {
                    $filtered_articles[] = $article;
                }
            }

            // Rearrange the $filtered_articles on a descending order base on the upvote_count index
            reference_array_sort_by_column( $filtered_articles, 'upvote_count', SORT_DESC );

            return $filtered_articles;
        }

        return;
	}
}

add_action( 'widgets_init', 'reference_register_most_upvoted_articles' );

function reference_register_most_upvoted_articles() {

	register_widget( 'MostUpvotedArticles' );

	return;
}
