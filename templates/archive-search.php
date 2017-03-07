<?php
/* Template Name: Custom Search */
/**
 * Search
 *
 * @package Reference
 * @subpackage Theme
 */

get_header(); ?>

<div class="contentarea">
    <div id="content" class="content_right">
             <h3>Search Result for : <?php echo "$s"; ?> </h3>
             <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a><h4>
            <!-- <p><?php the_exerpt(); ?></p> -->
            <p align="right"><a href="<?php the_permalink(); ?>">Read     More</a></p>
            <span class="post-meta"> Post By <?php the_author(); ?>
             | Date : <?php echo date('j F Y'); ?></span>
        </article>
<?php endwhile; ?>
<?php endif; ?>




   </div><!-- content -->
</div><!-- contentarea -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
