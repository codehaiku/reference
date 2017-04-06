<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * PHP Version 5.4
 *
 * @category Reference
 * @package  Reference
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference
 * @link     github.com/codehaiku/reference
 * @since    1.0
 */

get_header(); ?>
<div id="archive-section">
    <div class="col-md-8" id="content-left-col">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <div class="reference-main-wrapper">

                    <?php reference_breadcrumb(); ?>

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

                        <?php reference_search_form(); ?>

                        <?php reference_archive_categories(); ?>

                        <?php reference_knowledgebase_count(); ?>

                        <?php /* Start the Loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>

                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
                                <div class="entry-meta">
                                    <a href="<?php echo esc_url(the_permalink()); ?>"title="<?php echo esc_attr(the_title()); ?>">
                                        <?php the_title(
                                            '<h1 class="entry-title">',
                                            '</h1>'
                                        ); ?>
                                    </a>
                                </div>
                                <div class="entry-content">
                                    <?php the_excerpt(); ?>
                                </div>
                            </article><!-- #post-## -->

                        <?php endwhile; ?>

                        <?php reference_navigation(); ?>

            <?php else : ?>

                <?php get_template_part('knowledgebase', 'none'); ?>

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
