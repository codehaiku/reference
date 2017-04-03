<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
    <div class="wrap">
    	<div id="primary" class="content-area">
    		<main id="main" class="site-main" role="main">

                <?php Reference_breadcrumb(); ?>

                <header class="entry-header">
            		<?php
            			if ( is_single() ) {
            				the_title( '<h1 class="entry-title">', '</h1>' );
            			} else {
            				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            			}
            		?>
            	</header><!-- .entry-header -->

                <?php do_action('reference_has_table_of_content_before'); ?>

                    <?php do_action('reference_single_content_before'); ?>

                        <?php
                        while ( have_posts() ) : the_post(); ?>

                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="entry-meta">
                                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                                </div>
                                <div class="entry-content">
                                    <?php the_content(); ?>
                                </div>
                            </article><!-- #post-## -->

                            <?php Reference_Display_feedback(); ?>

                            <?php
                                // If comments are open or we have at least one comment, load up the comment template.
                                if ( comments_open() || get_comments_number() ) :
                                    comments_template();
                                endif;
                            ?>

                            <?php endwhile; // End of the loop. ?>

                    <?php do_action('reference_single_content_after'); ?>

                <?php do_action('reference_has_table_of_content_after'); ?>

            </main><!-- #main -->
        </div><!-- #primary -->
    	<?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php
get_footer();
