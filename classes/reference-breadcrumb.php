<?php
/**
 * This class is executes the reference shortcode.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category Reference\Reference\Helper
 * @package  Reference WordPress Knowledgebase
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/codehaiku/reference-wordpress-knowledgebase
 * @link     github.com/codehaiku/reference-wordpress-knowledgebase  The Plugin Repository
 */

namespace DSC\Reference;

 if ( ! defined( 'ABSPATH' ) ) {
     return;
 }

class Breadcrumbs {

 	public function render( $args = array() ) {

 		if ( is_front_page() ) {
 			return;
 		}

 		$post = Helper::global_post();

 		$defaults  = array(
 			'post_type'           => 'knowledgebase',
 			'taxonomy'            => 'knb-categories',
 			'separator_icon'      => ' ' . get_option('reference_knb_breadcrumbs_separator') . ' ',
 			'breadcrumbs_id'      => 'breadcrumbs-wrap',
 			'breadcrumbs_classes' => 'breadcrumb-trail breadcrumbs',
 			'home_title'          => get_option('reference_knb_plural'),
 		);

 		$args      = apply_filters( 'reference_breadcrumbs_args', wp_parse_args( $args, $defaults ) );
 		$separator = '<span class="separator"> ' . esc_html( $args['separator_icon'] ) . ' </span>';

 		// Open the breadcrumbs
 		$html = '<div id="' . esc_attr( $args['breadcrumbs_id'] ) . '" class="' . esc_attr( $args['breadcrumbs_classes'] ) . '">';

 		// Add Post Type archive link & separator (always present)
 		$html .= '<span class="item-home"><a class="bread-link bread-home" href="' . esc_url( get_post_type_archive_link( $args['post_type'] ) ) . '" title="' . esc_attr( $args['home_title'] ) . '">' . esc_html( $args['home_title'] ) . '</a></span>';

        if (! is_post_type_archive('knowledgebase') ) {
            $html .= $separator;
        }

        // Post
        if ( is_singular( $args['post_type']  ) ) {

            $html .= '<span class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</span></span>';

        } elseif ( is_tax( $args['taxonomy'] ) ) {

            $custom_tax_name = get_queried_object()->name;

            $taxonomy = get_queried_object()->taxonomy;

            $ancestors = get_ancestors( get_queried_object()->term_id, $taxonomy );

 			if ( ! empty ( $ancestors ) ) {
 				$ancestors = array_reverse( $ancestors );
 			}

 			foreach( $ancestors as $ancestor_id ) {
 				$ancestor = get_term_by('id', $ancestor_id, $taxonomy );
 				$ancestor_link = get_term_link(  $ancestor_id, $taxonomy );

 				$html .= '<span class="item-current item-archive"><span class="bread-current bread-archive"><a href="'.esc_url($ancestor_link).'" title="">' .  esc_html( $ancestor->name ) . '</a></span>' . $separator;
 			}

 			$html .= '<span class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html( $custom_tax_name ) . '</span></span>';

 		}

 		$html .= '</div>';

 		$html = apply_filters( 'reference_breadcrumbs_filter', $html );

 		echo wp_kses_post( $html );

 	}
 }
