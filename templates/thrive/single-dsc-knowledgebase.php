<?php
/**
 * The template for displaying all single posts.
 *
 * @package thrive
 */

get_header(); ?>

<?php $layout = thrive_get_layout(); ?>
<div class="<?php echo esc_attr( $layout['layout'] ); ?>">

	<div id="content-left-col" class="<?php echo esc_attr( $layout['content'] ); ?>">

		<div id="primary" class="content-area">

			<main id="main" class="site-main" role="main">

                <div class="reference-main-wrapper">

                    <?php reference_breadcrumb(); ?>

                    <?php do_action('reference_has_table_of_content_before'); ?>

                        <?php do_action('reference_single_content_before'); ?>

                			<?php while ( have_posts() ) : the_post(); ?>

                                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                    <div class="entry-meta">
                                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                                    </div>
                                    <div class="entry-content">
                                        <?php the_content(); ?>
                                    </div>
                                </article><!-- #post-## -->

                                <?php reference_display_comment_feedback(); ?>

                				<?php
                					// If comments are open or we have at least one comment, load up the comment template.
                					if ( comments_open() || get_comments_number() ) :
                						comments_template();
                					endif;
                				?>

                			<?php endwhile; // End of the loop. ?>

                        <?php do_action('reference_single_content_after'); ?>

                    <?php do_action('reference_has_table_of_content_after'); ?>

                    <div class="reference-clearfix"></div>

                </div><!--.reference-main-wrapper-->
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--col-md-8-->
	<div id="content-right-col" class="<?php echo esc_attr( $layout['sidebar'] ); ?>">
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>
