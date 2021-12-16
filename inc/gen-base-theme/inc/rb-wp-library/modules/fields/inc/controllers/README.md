These classes facilitates the creation of metaboxes in posts, terms, attachments, and menu items. The metabox content is rendered with the **fields API**, or if wanted, a
**custom content** can be printed.

The classes are:

- ``RB_Metabox``: Posts
- ``RB_Taxonomy_Meta``: Terms
- ``RB_Attachment_Meta``: Attachment
- ``RB_Menu_Item_Meta``: Menu Items

Creating a new instance of these classes requires 3 parameters.

| Argument  	| Type    	| Required                                              	| Description                                                  	|
|-----------	|---------	|-------------------------------------------------------	|--------------------------------------------------------------	|
| $meta_key 	| `string`  	| yes                                                   	| Sets the meta key which will store the value in the database 	|
| $config   	| `mixed[]` 	| yes                                                   	| The configuration of the metabox. These arguments are documented for each class down below.                             	|
| $fields   	| `mixed[]` 	| If `custom_content` is not set on the `$config` array 	| The field configuration array, as seen in the  [Fields Documentation](../fields/README.md)                               	|

# RB_Metabox

Adds a metabox to the post creation and edition screens. A column for this
metadata can be added to the posts list directly from this class.

````php
<?php
new RB_Metabox('meta_key', array(
    /**
    *   @property string[]|string                                           The metabox title. Appears on the header of the metabox.
    */
    'title'			=> 'Title',
    /**
    *   @property string[]|string                                           The post types where this meta will be added.
    */
    'admin_page'	=> 'lr-article',
    // see add_meta_box
    'context'		=> 'side',
    // see add_meta_box
    'priority'		=> 'high',
    /**
    *   @property string[]                                                  Classes to add to the metabox html
    */
    'classes'		=> array('lr-metabox'),
    /**
    *   @property string|callback                                           Content to show in the metabox, instead of showing the field
    *   @param WP_Post|int|null $post
    */
    'custom_content'    => null,
    /**
    *   @property null|mixed[]                                              Column for the metadata
    */
    'column'        => array(
        /**
        *   @property string                                                Column title. Defaults to the metabox title
        */
        'title'         => 'Autor',
        /**
        *   @property string|callback                                       Column cell content
        *   @param WP_Post|int|null $meta_value
        *   @param WP_Post|int|null $post_id
        */
        'content'       => function($meta_value, $post_id){
            echo "Cell content";
        },
    ),
    /**
    *   @property callback                                                  A callback to sanitize the field value before its saved
    *   @param mixed $value                                                 The value before the sanitation
    *   @return mixed                                                       The sanitized value
    */
    'sanitize_value'    => null,
), array(
    /**
    *   Fields settings. Manages the metabox content (see fields docs.)
    */
));
````

# RB_Taxonomy_Meta

Adds a meta control to the add and edit term forms. A column for this
metadata can be added to the taxonomy terms list directly from this class.

````php
<?php
new RB_Taxonomy_Form_Field('meta_key', array(
    /**
    *   @property string[]|string                                           The metabox title. Appears on the left of the meta input in the edit form,
    *                                                                       and on top on the creation form.
    */
    'title'			=> 'Title',
    /**
    *   @property string[]|string                                           The terms slugs where this meta will be added.
    */
    'terms'	        => array('lr-article-author'),
    /**
    *   @property bool                                                      Indicates if this field should be shown in the term creation form.
    */
    'add_form'      => true,
    // see add_meta_box
    'context'		=> 'side',
    // see add_meta_box
    'priority'		=> 'high',
    /**
    *   @property string|callback                                           Content to show in the metabox, instead of showing a field
    *   @param WP_Post|int|null $term
    */
    'custom_content'    => null,
    /**
    *   @property null|mixed[]                                              Column for the metadata
    */
    'column'        => array(
        /**
        *   @property string                                                Column title. Defaults to the metabox title
        */
        'title'         => 'Autor',
        /**
        *   @property string|callback                                       Column cell content
        *   @param WP_Post|int|null $meta_value
        *   @param WP_Post|int|null $post_id
        */
        'content'       => function($meta_value, $term_id){
            echo "Cell content";
        },
    ),
    /**
    *   @property callback                                                  A callback to sanitize the field value before its saved
    *   @param mixed $value                                                 The value before the sanitation
    *   @return mixed                                                       The sanitized value
    */
    'sanitize_value'    => null,
), array(
    /**
    *   Fields settings. Manages the metabox content (see fields docs.)
    */
));
````

# RB_Attachment_Meta

Adds a meta control to the attachments data forms.

````php
<?php
new RB_Attachment_Meta('meta_key', array(
    /**
    *   @property string[]|string                                           The metabox title.
    */
    'title'			=> 'Title',
    // see add_meta_box
    'context'		=> 'side',
    // see add_meta_box
    'priority'		=> 'high',
    /**
    *   @property string|callback                                           Content to show in the metabox, instead of showing a field
    *   @param WP_Post|int|null $term
    */
    'custom_content'    => null,
    /**
    *   @property callback                                                  A callback to sanitize the field value before its saved
    *   @param mixed $value                                                 The value before the sanitation
    *   @return mixed                                                       The sanitized value
    */
    'sanitize_value'    => null,
), array(
    /**
    *   Fields settings. Manages the metabox content (see fields docs.)
    */
));
````

# RB_Menu_Item_Meta

Adds a meta control to a menu item.

````php
<?php
new RB_Menu_Item_Meta('meta_key', array(
    /**
    *   @property string[]|string                                           The metabox title.
    */
    'title'			=> 'Title',
    /**
    *   @property string[]|string                                           The post types of the menu items
    */
    'admin_page'	=> 'lr-article',  
    /**
    *   @property string|callback                                           Content to show in the metabox, instead of showing a field
    *   @param WP_Post|int|null $term
    */  
    'custom_content'    => null,
    /**
    *   @property callback                                                  A callback to sanitize the field value before its saved
    *   @param mixed $value                                                 The value before the sanitation
    *   @return mixed                                                       The sanitized value
    */
    'sanitize_value'    => null,
), array(
    /**
    *   Fields settings. Manages the metabox content (see fields docs.)
    */
));
````


# Filters

### Metabox Content: `rb_metabox_render__${meta_id}`

Filters the content to be render.
````php
<?php
$meta_id = "meta_key";
/**
*   @param string $content                                  The render content
*   @param RB_Metabox_Base $rb_metabox                      The metabox object. Extends RB_Metabox_Base
*   @param WP_Post|WP_Term|int|null                         The wordpress object
*   @return string                                          The filtered content
*/
$callback = function($content, $rb_metabox, $wp_object){
    return "<div class='metabox-container'>$content</div>";
};
add_filter("rb_metabox_render__$meta_id", $callback);
````
