Reference
===================
----------

WordPress Knowledgebase Plugin
-------------

Reference is a WordPress Knowledgebase plugin that helps you manage your Knowledgebase articles easily. Create articles and organized each of your articles base on their topics.

Reference have a 'Breadcrumbs' feature that gives your users a secondary navigation scheme that reveals the user's location in your Knowledgebase.

The Reference plugin, uses the 'WordPress Menu System' in giving you convenience in creating 'Table of Contents' for your Knowledgebase. 'Sticky Table of Contents' feature that adds convenience to your users when navigating your articles.

Also, it has a 'Comment Feedback' feature that allows you to gather votes from your users, that gives you information if your articles are useful to your users or not. It also allows you to display your 'Topics' in three columns, two columns or one columns.

<strong>Current Version: 1.0.0</strong>

Features
------------
----------
 - Breadcrumbs
 - Drag and Drop Menu using the WordPress Menu System
 - Table of Contents
 - Sticky Table of Contents
 - Syntax Highlighting Shortcode
 - Ten Syntax Highlighting Styles
 - Comment Feedback
 - Column Display
 - Reference Shortcode

Installation
------------
----------
1. You can clone the GitHub repository: `https://github.com/codehaiku/reference.git`
2. Or download it directly as a ZIP file: `https://github.com/codehaiku/reference/archive/master.zip`

**Manual:**

 1. Download and unzip the "reference.zip" plugin.
 2. Upload the entire "reference" directory to your '/wp-content/plugins/'
    directory.
 3. Activate the "Reference" plugin through the Plugins menu in WordPress.
 4. Go to ‘Settings’ > ‘Reference’ to configure the setting of the plugin.

Settings
------------
----------

**Archive Slug (Advance)**

This section handles all settings related to the slug of Knowledgebase archive pages.

> **Note:**
You need to update or resave the “**permalink**” settings if you had change any settings under this section.

 1. **Slug** setting:
	 - This option allows you to change the slug of your post archive page.

	 - **Default Value:** `dsc-knowledgebase`
 2. **Category Slug** setting:
	 - This option allows you to change the slug of your taxonomy category archive page.

	 - **Default Value:** `dsc-knb-categories`
 3. **Tag Slug** setting:
	 - This option allows you to change the slug of your taxonomy archive page.

	 - **Default Value:** `dsc-knb-tags`

----------

**Archive Name (Advance)**

All settings related to the name of the knowledgebase archive pages.

 1. **Singular** setting:
	 - This setting allows you to change the singular name of your Knowledgebase archive page.

	 - **Default Value:** `Knowledgebase`
 2. **Plural** setting:
	 - This setting allows you to change the plural name of your Knowledgebase archive page.

	 - **Default Value:** `Knowledgebase`
 3. **Category Singular** setting:
	 - This setting allows you to change the singular name of your Knowledgebase category archive page.

	 - **Default Value:** `Knowledgebase Category`
 4. **Category Plural** setting:
	 - This setting allows you to change the plural name of your Knowledgebase category archive page.

	 - **Default Value:** `Knowledgebase Categories`
 5. **Tag Singular** setting:
	 - This setting allows you to change the singular name of your Knowledgebase tag archive page.

	 - **Default Value:** `Knowledgebase Tag`
 6. **Tag Plural** setting:
	 - This setting allows you to change the plural name of your Knowledgebase tag archive page.

	 - **Default Value:** `Knowledgebase Tags`

----------

**Knowledgebase Content Setting**

All settings related to the content of Knowledgebase pages.

 1. **Columns** setting:
	 - This setting allows you to change the category columns.

	 - **Default Value:** `3`
	 - **Max Value:** `3`
 2. **Syntax Highlighting** setting:
	 - This setting allows you to enable the syntax highlighting for your displayed codes which are encapsulated by the `[reference_highlighter]` shortcode.

	 - **Default Value:** `Enabled`
 3. **Syntax Highlighting Style** setting:
	 - This setting allows you to change the style for displaying your codes that is encapsulated by the `[reference_highlighter]` shortcode.

	 - **Default Value:** `dark`
 4. **Comment Feedback** setting:
	 - This setting allows you to enable the comment feedback for your Knowledgebase (Articles) pages.

	 - **Default Value:** `Enabled`
 5. **Table of Contents** setting:
	 - This setting allows you to enable the Table of Contents for your Knowledgebase (Articles) pages.

	 - **Default Value:** `Enabled`
 6. **Sticky Table of Contents** setting:
	 - This setting allows you to enable sticky Table of Contents for your Knowledgebase (Articles) pages.

	 - **Default Value:** `Enabled`
 7. **Breadcrumbs** setting:
	 - This setting allows you to enable the Breadcrumbs for your Knowledgebase (Articles) pages.

	 - **Default Value:** `Enabled`
 8. **Breadcrumbs Separator** setting:
	 - This setting allows you to change the separator for your Knowledgebase.

	 - **Default Value:** `/`
 9. **Category Excerpt** setting:
	 - This setting allows you to change the maximum characters for the category description.

	 - **Default Value:** `55`
 10. **Posts per Page** setting:
	 - This option allows you to change the maximum knowledgebase to show in a page.
> **Note:** If this setting is set to 0 it would get the "Blog pages show at most" value in the "Settings" > "Readings" page.

	 - **Default Value:** `10`

----------

Templates
------------
----------
Use **all** the 'Reference Template Files' below to integrate and accommodate the 'Reference' plugin in your theme. Just create the listed template files below in your 'wp-content' > 'themes' > '`{theme_name}`' folder.

For the **Used Template Tags**, refer to the '**Template Tags**' section.

> **Note:** To customize the 'Template Files' of the 'Reference' plugin, you need to create the mentioned 'Template Files' below in your current activated theme.

----------

 1. **archive-dsc-knowledgebase.php** file:
	 - This template file is used to display the Knowledgebase archive page.

	 - **Used Template Tags:**
		 - **reference_breadcrumb()**
		 - **reference_archive_categories()**
		 - **reference_knowledgebase_count()**
		 - **reference_navigation()**

 2. **single-dsc-knowledgebase.php** file:
	 - This template file is used to display the single Knowledgebase page.

	 - **Used Template Tags:**
		 - **reference_breadcrumb()**
		 - **reference_display_comment_feedback()**

	 - **Used Actions:**
		 - **do_action('reference_has_table_of_content_before')**
		 - **do_action('reference_single_content_before')**
		 - **do_action('reference_single_content_after')**
		 - **do_action('reference_has_table_of_content_after')**

 3. **taxonomy-knb-categories.php** file:
	 - This template file is used to display the category Knowledgebase archive page.

	 - **Used Template Tags:**
		 - **reference_breadcrumb()**
		 - **reference_category_thumbnail()**
		 - **reference_search_form()**
		 - **reference_child_categories()**
		 - **reference_knowledgebase_count()**
		 - **reference_navigation()**

 4. **knowledgebase-none.php** file:
	 - This template file is displayed if there are no posts to display.

 	 - **Used Inside:**
		 - **archive-dsc-knowledgebase.php** file
		 - **taxonomy-knb-categories.php** file

	 - **Used Template Tags:**
		 - **reference_search_form()**

 5. **knowledgebase-search.php** file:
	 - This template file is used to display the searched Knowledgebase article.

	 - **Used Template Tags:**
		 - **reference_breadcrumb()**
		 - **reference_search_form()**
		 - **reference_no_search_result()**
		 - **reference_navigation()**

Shortcodes
------------
----------

This section explains the available shortcodes for the 'Reference' plugin.

For the **Used Template Tags**, refer to the '**Template Tags**' section.

----------

 1. **[reference_loop]** shortcode
	 - This shortcode is used to display Knowledgebase articles and child categories based from the topics (category) that  were specified in the shortcode parameter and the Knowledgebase search in a page or post.

	 - **Shortcode Parameters:**
		 - **categories**
			 - Used this parameter to specify the categories of the Knowledgebase you wanted to display.
		 - **posts_per_page**
			 - Used this parameter to limit the number of 'Knowledgebase' (articles) to be display.
		 - **columns**
			 - Used this parameter to define the columns you want to display the child categories (child topics).
			 - **Max columns:** `3`
		 - **enable_search**
			 - Used this parameter to enable or disable the display of the 'Reference Search Field.'
		 -  **show_category**
			 - Used this parameter to enable or disable the display of child categories (child topics).
	 - **Used Template Tags:**
		 - **reference_loop_category()**

	 - **Shortcode Usage:**
		 - `[reference_loop categories="WordPress, BuddyPress" posts_per_page="10" columns="3" enable_search="true" show_category ="true"]`

 - **[reference_highlighter]** shortcode
	 - This shortcode is used to encapsulate a 'Code' and detects the used language automatically to highlight the code syntax based on the used language.
	 - **Shortcode Usage:**
		 -  `[reference_highlighter]<?php echo 'hello'; ?>[/reference_highlighter]`

Template Tags
-------------
----------

- **reference_breadcrumb()**
- **reference_archive_categories()**
- **reference_knowledgebase_count()**
- **reference_navigation()**
- **reference_display_comment_feedback()**
- **reference_category_thumbnail()**
- **reference_search_form()**
- **reference_child_categories()**
- **reference_no_search_result()**
- **reference_loop_category()**

Actions
-------------
----------

- **do_action('reference_has_table_of_content_before')**
- **do_action('reference_single_content_before')**
- **do_action('reference_single_content_after')**
- **do_action('reference_has_table_of_content_after')**
