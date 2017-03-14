<?php
/**
 * Reference shortcode Template
 *
 * @since  1.0.0
 * @package reference\shortcodes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

extract( $atts );


// Filter allowed columns.
$allowed_columns = array( "1", "2", "3" );


if ( ! in_array( $columns, $allowed_columns, true ) ) {
	$columns = 3;
}

$categories = explode(",", $categories);

$args = array(
	'post_type' => 'knowledgebase',
	'posts_per_page' => $posts_per_page,
    'tax_query' => array(
		array(
			'taxonomy' => 'knb-categories',
			'field'    => 'slug',
			'terms'    => $categories,
		),
	),
);

// var_dump($categories);
?>

<?php $knowledgebase = new WP_Query( $args ); ?>

<?php if ( $knowledgebase->have_posts() ) : ?>

    <header class="reference-header">
        <h1 class="reference-title"><?php esc_html_e($title); ?></h1>

        <div class="reference-knowledgebase-search-field">
            <form role="search" class="reference-knowledgebase-search-form" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
                <input type="text" name="s" placeholder="<?php esc_attr_e('Search Knowledgebase', 'reference'); ?>"/>
                <input type="hidden" name="post_type" value="knowledgebase" />
                <input class="button" type="submit" id="reference_knowledgebase_search_submit" value="<?php esc_attr_e( 'Search', 'reference' ); ?>" />
            </form>
        </div>
    </header><!-- .page-header -->

    <div class="reference-knowledgebase columns-<?php esc_attr_e($columns); ?>">
        <?php
            echo \DSC\Reference\KnowledgebaseShortcodes::reference_shortcode_display_knowledgebase_category_list($categories, $columns);
        ?>
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

                                <?php the_excerpt();?>

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
