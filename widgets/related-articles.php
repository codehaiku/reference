<?php
/**
 * This class executes the Related Article Widget
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\RelatedArticles
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
 * Initialize the Related Article display of the widget
 * and form settings.
 *
 * @category Reference\RelatedArticles
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     github.com/codehaiku/reference
 * @since    1.0.1
 */
final class RelatedArticles extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
        parent::__construct(
			'reference_related_articles', // Base ID
			__( 'Reference: Related Articles', 'reference' ), // Name
			array( 'description' => __( 'Use this widget to display the related articles.', 'reference' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Related Articles', 'reference' );
        $taxonomy = ! empty( $instance['taxonomy'] ) ? $instance['taxonomy'] : 10;
        $taxonomy_names = ! empty( $instance['taxonomy_names'] ) ? $instance['taxonomy_names'] : '';
        $taxonomy_names_array = explode( ',', $taxonomy_names );
        $order = ! empty( $instance['order'] ) ? $instance['order'] : 'ASC';
        $order_by = ! empty( $instance['order_by'] ) ? $instance['order_by'] : 'title';
        $posts_displayed = ! empty( $instance['posts_displayed'] ) ? $instance['posts_displayed'] : 10;
        $show_post_date = ! empty( $instance['show_post_date'] ) ? $instance['show_post_date'] : 'off';

        if ( 0 !== $posts_displayed || 1 !== $posts_displayed ) {
            $posts_displayed = $posts_displayed + 1;
        }
        /**
         * Query the Form
         */
        $articles_args = array(
            'posts_per_page' => $posts_displayed,
        	'orderby' => $order_by,
        	'order' => $order,
        	'post_type' => 'dsc-knowledgebase',
        	'post_status' => 'publish',
        	'suppress_filters' => true,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'name',
                    'terms'    => $taxonomy_names_array,
                ),
            ),
        );


        $articles = new WP_Query( $articles_args );
        $related_articles = json_decode( json_encode( $articles->posts ), true ); ?>

        <?php echo $args['before_widget']; ?>

            <?php
                if ( ! empty( $instance['title'] ) ) {
                    echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
                }
            ?>

            <ul class="reference-related-articles-container">
                <?php if ( ! empty ( $related_articles ) ) : ?>
                    <?php
                    foreach( $related_articles as $article ) { ?>
                        <?php
                            $post_id = $article['ID'];
                            $post_title = $article['post_title'];
                            $post_date = $article['post_date'];
                            $date_format = apply_filters( 'reference_related_articles_date_format', 'F d, Y' );
                        ?>

                        <li class="reference-related-articles">
                            <a href="<?php echo esc_url( get_post_permalink( $post_id ) ); ?>" title="<?php echo esc_attr( $post_title ); ?>" class="related-articles-link">
                                <span class="related-article-title">
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
                                'There are no related articles.',
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
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Related Articles', 'reference' );
        $taxonomy_selector = ! empty( $instance['taxonomy'] ) ? $instance['taxonomy'] : 'knb-categories';
        $taxonomy_names = ! empty( $instance['taxonomy_names'] ) ? $instance['taxonomy_names'] : '';
        $order = ! empty( $instance['order'] ) ? $instance['order'] : 'ASC';
        $order_by = ! empty( $instance['order_by'] ) ? $instance['order_by'] : 'title';
        $posts_displayed = ! empty( $instance['posts_displayed'] ) ? $instance['posts_displayed'] : 10;
        $show_post_date = ! empty( $instance['show_post_date'] ) ? $instance['show_post_date'] : 'off';

        $checked = array(
            'show_post_date' => ''
        );
        if ( "on" === $show_post_date ) {
            $checked['show_post_date'] = 'checked';
        }; ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'reference' ); ?></label>

            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

            <span class="help-text">
                <em><?php echo esc_html__( 'You can use this field to enter the widget title.', 'reference' ); ?></em>
            </span>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy_names' ) ); ?>"><?php echo esc_html__( 'Taxonomy Names:', 'reference' ); ?></label>

            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'taxonomy_names' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy_names' ) ); ?>" type="text" value="<?php echo esc_attr( $taxonomy_names ); ?>" placeholder="<?php echo esc_attr__( 'Topic 1, Topic 2, Topic 3', 'reference' ); ?>">

            <span class="help-text">
                <em><?php echo esc_html__( 'Type the topics or tags for any articles and separate them with comma.', 'reference' ); ?></em>
            </span>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php echo esc_html__( 'Taxonomy:', 'reference' ); ?></label>

            <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>">
                <option <?php selected( esc_attr( $taxonomy_selector ), 'knb-categories' ); ?> value="knb-categories"><?php echo esc_html__( 'Topics', 'reference' ); ?></option>
                <option <?php selected( esc_attr( $taxonomy_selector ), 'knb-tags' ); ?> value="knb-tags"><?php echo esc_html__( 'Tags', 'reference' ); ?></option>
            </select>

            <span class="help-text">
                <em><?php echo esc_html__( 'Select the taxonomy for the article you want to display.', 'reference' ); ?></em>
            </span>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php echo esc_html__( 'Order:', 'reference' ); ?></label>

            <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
                <option <?php selected( esc_attr( $order ), 'ASC' ); ?> value="ASC"><?php echo esc_html__( 'Ascending', 'reference' ); ?></option>
                <option <?php selected( esc_attr( $order ), 'DESC' ); ?> value="DESC"><?php echo esc_html__( 'Descending', 'reference' ); ?></option>
            </select>

            <span class="help-text">
                <em><?php echo esc_html__( 'Select the ascending or descending for the order of your article.', 'reference' ); ?></em>
            </span>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'order_by' ) ); ?>"><?php echo esc_html__( 'Order By:', 'reference' ); ?></label>

            <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'order_by' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'order_by' ) ); ?>">
                <option <?php selected( esc_attr( $order_by ), 'title' ); ?> value="title"><?php echo esc_html__( 'Title', 'reference' ); ?></option>
                <option <?php selected( esc_attr( $order_by ), 'date' ); ?> value="date"><?php echo esc_html__( 'Date', 'reference' ); ?></option>
                <option <?php selected( esc_attr( $order_by ), 'rand' ); ?> value="rand"><?php echo esc_html__( 'Random', 'reference' ); ?></option>
                <option <?php selected( esc_attr( $order_by ), 'DESC' ); ?> value="DESC"><?php echo esc_html__( 'Descending', 'reference' ); ?></option>
            </select>

            <span class="help-text">
                <em><?php echo esc_html__( 'Select the ascending or descending for the order of your article.', 'reference' ); ?></em>
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
        $instance['taxonomy']    = ( ! empty( $new_instance['taxonomy'] ) ) ? strip_tags( $new_instance['taxonomy'] ) : '';
        $instance['taxonomy_names']    = ( ! empty( $new_instance['taxonomy_names'] ) ) ? strip_tags( $new_instance['taxonomy_names'] ) : '';
        $instance['order']    = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
        $instance['order_by']    = ( ! empty( $new_instance['order_by'] ) ) ? strip_tags( $new_instance['order_by'] ) : '';
        $instance['posts_displayed'] = ( ! empty( $new_instance['posts_displayed'] ) ) ? strip_tags( absint ($new_instance['posts_displayed'] ) ) : '';
        $instance['show_post_date']    = ( ! empty( $new_instance['show_post_date'] ) ) ? strip_tags( $new_instance['show_post_date'] ) : '';

        return $instance;
	}
}

add_action( 'widgets_init', 'reference_register_related_articles' );

function reference_register_related_articles() {

	register_widget( 'RelatedArticles' );

	return;
}
