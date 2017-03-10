<?php
/**
 * This file is part of the Reference WordPress Knowledgebase Plugin Package.
 * The template for displaying all single knowledgebase
 *
 * (c) Joseph Gabito <joseph@useissuestabinstead.com>
 * (c) Jasper Jardin <jasper@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Reference
* @since Reference 1.0.0
 */
 get_header(); ?>


    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header><!-- .entry-header -->

            <?php do_action('reference_has_table_of_content_before'); ?>

            <?php do_action('reference_single_content_before'); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="entry-content">
                    <?php
                        /* translators: %s: Name of current post */
                        the_content();
                    ?>
                </div><!-- .entry-content -->

            </article><!-- #post-## -->

        <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        ?>

<?php
$reference_menu = \DSC\Reference\Helper::get_table_of_content_setting();

$menu = wp_nav_menu(
    array(
        'menu' => $reference_menu,
        'menu_id' => 'reference-menu',
        'container_class' => 'reference-menu-wrap',
        'echo' => false,
        'fallback_cb' => ''
    )
);
$nav_menu = \DSC\Reference\Helper::get_nav_menu_array(\DSC\Reference\Helper::get_table_of_content_setting());


$current_page = get_the_ID();

echo $current_page;


echo '<pre>';
var_dump($nav_menu);
echo '</pre>';
?>

        <?php do_action('reference_single_content_after'); ?>

        <?php do_action('reference_has_table_of_content_after'); ?>

        </main><!-- .site-main -->
    </div><!-- .content-area -->

 <?php get_footer(); ?>
