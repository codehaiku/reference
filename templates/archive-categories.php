<?php get_header(); ?>

<?php
$reference_knb_archive_column = get_option('reference_knb_archive_column');

$args = array(
	'post_type' => 'knowledgebase',
	'posts_per_page' => 10,
    'taxonomy'=>'categories',
    'term' => $term,

);
$category_listing = new \DSC\Reference\Helper;

$knowledgebase = new WP_Query( $args );
?>

<?php if ( $knowledgebase->have_posts() ) : ?>

    <header class="page-header">
        <?php
            the_archive_title( '<h1 class="page-title">', '</h1>' );
            the_archive_description( '<div class="taxonomy-description">', '</div>' );
        ?>
        <div class="reference-knowledgebase-search-field">
            <form role="search" class="reference-knowledgebase-search-form" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
                <input type="text" name="s" placeholder="<?php esc_attr_e('Search Knowledgebase', 'reference'); ?>"/>
                <input type="hidden" name="post_type" value="knowledgebase" />
                <input class="button" type="submit" id="reference_knowledgebase_search_submit" value="<?php esc_attr_e( 'Search', 'reference' ); ?>" />
            </form>
        </div>
    </header><!-- .page-header -->

    <div class="reference-knowledgebase columns-<?php esc_attr_e($reference_knb_archive_column); ?>">

        <?php echo $category_listing->reference_display_child_category_list(); ?>

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
