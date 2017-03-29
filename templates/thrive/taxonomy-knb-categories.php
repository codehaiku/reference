<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package thrive
 */

get_header(); ?>
<div id="archive-section">
	<div class="col-md-8" id="content-left-col">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

                <div class="reference-main-wrapper">

        			<?php if ( have_posts() ) : ?>
        				<?php
        					$archive_allowed_tags = array(
        					    'a' => array(
        					        'href' => array(),
        					        'title' => array()
        					    ),
        					    'span' => array(
        					    	'class' => array()
        					    )
        					);
        				?>

                        <?php knb_breadcrumb(); ?>

        				<header class="page-header thrive-card no-mg-top">
                            <div class="reference-header-image">
                                <?php knb_category_thumbnail(); ?>
                            </div>
        					<?php
                                $archive_title = get_the_archive_title( '<h1 class="page-title">', '</h1>' );
                                $archive_description = get_the_archive_description( '<div class="taxonomy-description">', '</div>' );
        					?>
                            <div class="reference-header-info">
            					<?php if ( empty ( $archive_title ) ) { ?>

            						<h1 class="page-title">

            							<i class="material-icons md-24 md-dark">archive</i><?php _e( 'Archives', 'thrive' ); ?>

            						</h1>

            					<?php } else { ?>

            						<?php echo wp_kses( $archive_title, $archive_allowed_tags ); ?>

            					<?php } ?>

            					<?php echo ( $archive_description ); ?>
                            </div>
        				</header><!-- .page-header -->

                        <?php knb_search_form(); ?>

                        <?php knb_child_categories(); ?>

                        <?php knb_knowledgebase_count(); ?>

        				<?php /* Start the Loop */ ?>
        				<?php while ( have_posts() ) : the_post(); ?>

                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="entry-meta">
                                    <a href="<?php echo esc_url(the_permalink()); ?>" title="<?php echo esc_attr(the_title()); ?>">
                                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                                    </a>
                                </div>
                                <div class="entry-content">
                                    <?php the_excerpt(); ?>
                                </div>
                            </article><!-- #post-## -->

        				<?php endwhile; ?>

                        <?php reference_navigation(); ?>

        			<?php else : ?>

        				<?php get_template_part( 'knowledgebase', 'none' ); ?>

        			<?php endif; ?>
                </div><!--.reference-main-wrapper-->
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--col-md-8-->

<div class="col-md-4" id="content-right-col">
	<?php get_sidebar(); ?>
</div>
</div><!--#archive-section-->
<?php get_footer(); ?>
