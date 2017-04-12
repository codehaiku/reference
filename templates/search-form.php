<div class="reference-knowledgebase-search-field">
    <form role="search" class="reference-knowledgebase-search-form" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
        <input type="text" name="s" placeholder="<?php esc_attr_e('Search Knowledgebase', 'reference'); ?>"/>
        <input type="hidden" name="post_type" value="dsc-knowledgebase" />
        <input class="button" type="submit" id="reference_knowledgebase_search_submit" value="<?php esc_attr_e( 'Search', 'reference' ); ?>" />
    </form>
</div>
