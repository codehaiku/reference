<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package thrive
 */

?>

<section class="no-results not-found">
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
    <header class="page-header thrive-card no-mg-top">
        <div class="reference-header-image">
            <?php reference_category_thumbnail(); ?>
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

    <?php reference_search_form(); ?>

    <div class="page-content">
    <?php if (is_home() && current_user_can('publish_posts') ) : ?>

        <p>
            <?php printf(
                wp_kses(
                    __(
                        'Ready to publish your first post? <a href="%1$s">
                        Get started here</a>.',
                        'thrive'
                    ),
                    array(
                            'a' => array(
                                'href' => array()
                            )
                        )
                ),
                esc_url(
                    admin_url('post-new.php')
                )
            ); ?>
        </p>

    <?php elseif (is_search() ) : ?>
        <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'thrive'); ?></p>
    <?php else : ?>
        <?php reference_knowledgebase_count(); ?>
    <?php endif; ?>

    </div><!-- .page-content -->
</section><!-- .no-results -->
