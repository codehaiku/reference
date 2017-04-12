<?php
/**
 * The template for displaying search results pages.
 *
 * @package thrive
 */

get_header(); ?>
<div class="row limiter">
	<div id="content-left-col" class="col-md-8">
		<section id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

                <div class="reference-main-wrapper">

                    <?php reference_breadcrumb(); ?>

                    <header class="search-page-header mg-bottom-35">

                        <div class="clearfix">
                            <div class="pull-left">
                                <h5 class="dark_secondary_icon">
                                    <?php _e('Search Results', 'thrive'); ?>
                                </h5>
                            </div>
                        </div>

                        <h1 class="page-title">
                            <?php echo get_search_query(); ?>
                        </h1>

                        <div id="search-page-search-form">
                           <?php reference_search_form(); ?>
                        </div>

                    </header><!-- .page-header -->

                    <?php reference_no_search_result(); ?>

                    <?php if ( have_posts() ) : ?>

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

        			<?php endif; ?>

                </div><!--.reference-main-wrapper-->

			</main><!-- #main -->

		</section><!-- #primary -->

	</div><!--.col-md-8-->
	<div class="col-md-4">
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>
