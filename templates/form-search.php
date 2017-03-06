<?php

/**
 * Search
 *
 * @package Reference
 * @subpackage Theme
 */

?>

<form role="search" class="reference-knowledgebase-search-form" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
    <input type="hidden" name="reference_knowledgebase_action" value="knowledgebase" />
    <input type="text" name="reference_knowledgebase_search" placeholder="<?php esc_attr_e('Search Knowledgebase', 'reference'); ?>"/>
    <input class="button" type="submit" id="reference_knowledgebase_search_submit" value="<?php esc_attr_e( 'Search', 'reference' ); ?>" />
</form>
