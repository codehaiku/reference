<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

<section class="no-results not-found">
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

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'twentyseventeen' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'twentyseventeen' ); ?></p>
           <?php reference_search_form(); ?>
           <?php reference_knowledgebase_count(); ?>
		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
