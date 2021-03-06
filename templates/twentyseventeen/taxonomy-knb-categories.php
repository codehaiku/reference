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
        <?php reference_breadcrumb(); ?>

        <header class="page-header">
            <div class="reference-header-image">
                <?php reference_category_thumbnail(); ?>
            </div>

            <div class="reference-header-info">
                <?php the_archive_title( '<h1 class="page-title"><a href="' . get_the_permalink() . '">', '</a></h1>' ); ?>
                <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
            </div>

        </header><!-- .page-header -->

        <?php reference_search_form(); ?>
    <?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
            <?php reference_child_categories(); ?>
            <?php reference_knowledgebase_count(); ?>
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

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
