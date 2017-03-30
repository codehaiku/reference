<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">

	<header class="page-header">
		<?php if ( have_posts() ) : ?>
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyseventeen' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		<?php else : ?>
			<h1 class="page-title"><?php _e( 'Nothing Found', 'twentyseventeen' ); ?></h1>
		<?php endif; ?>
	</header><!-- .page-header -->

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
            <?php knb_breadcrumb(); ?>

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

            <?php knb_breadcrumb(); ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyseventeen' ); ?></p>
            <div id="search-page-search-form">
               <?php knb_search_form(); ?>
            </div>

            <?php reference_no_search_result(); ?>
        <?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();