<?php get_header(); ?>

<?php

$args = array(
	'post_type' => 'knowledgebase',
	'posts_per_page' => 10,
    'taxonomy'=>'categories',
    'term' => $term,

);

$knowledgebase = new WP_Query( $args );
?>

<?php if ( $knowledgebase->have_posts() ) : ?>

    <header class="page-header">
        <?php
            the_archive_title( '<h1 class="page-title">', '</h1>' );
            the_archive_description( '<div class="taxonomy-description">', '</div>' );
        ?>
    </header><!-- .page-header -->
<?php

$plugin = new \DSC\Reference\Helper;
echo $plugin->reference_display_knowledgebase_category_list();

?>



    <div class="reference-knowledgebase">

        <div class="reference-knowledgebase-search-field">
            <?php get_template_part( 'form', 'search' ); ?>
        </div>

        <?php while ( $knowledgebase->have_posts() ) : ?>

            <?php $knowledgebase->the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <a class="reference-knowledgebase-link" href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( the_title() ); ?>" target="_self"></a>

                <div class="reference-knowledgebase-wrap">

                    <div class="reference-knowledgebase-thumbnail">

                        <?php if ( has_post_thumbnail() ) { ?>

                            <?php the_post_thumbnail(); ?>

                        <?php } ?>

                    </div>

                    <div class="reference-knowledgebase-details">

                        <div class="reference-knowledgebase-details-title-wrapper">

                            <div class="reference-knowledgebase-details-title">

                                <h5>

                                    <a href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( the_title() ); ?>">

                                        <?php the_title();?>

                                    </a>

                                </h5>

                                <?php the_content();?>

                            </div>

                        </div>

                    </div>

                </div>

            </article>

        <?php endwhile; ?>

    </div>

    <?php wp_reset_postdata(); ?>

<?php else : ?>

<div class="alert alert-info">
    <p>
        <?php esc_html_e( 'There are no items found in your knowledgebase.', 'reference' ); ?>
    </p>
</div>

<div class="clearfix"></div>

<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
