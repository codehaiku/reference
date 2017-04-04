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

    <?php if ( have_posts() ) : ?>
        <header class="page-header">
            <?php
                the_archive_title( '<h1 class="page-title"><a href="' . get_the_permalink() . '">', '</a></h1>' );
                the_archive_description( '<div class="taxonomy-description">', '</div>' );
                ?>
            </header><!-- .page-header -->

    <?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

        <?php reference_breadcrumb(); ?>

        <?php reference_search_form(); ?>

        <?php reference_archive_categories(); ?>

        <?php reference_knowledgebase_count(); ?>

		<?php
		if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                    <?php
                        if (is_single()) {
            				the_title('<h1 class="entry-title">', '</h1>');
            			} else {
            				the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            			}
                        the_excerpt();
                    ?>
                    </header>
                </article>

			<?php endwhile; ?>

            <?php reference_navigation(); ?>

		<?php else : ?>

            <?php get_template_part( 'knowledgebase', 'none' ); ?>

        <?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
