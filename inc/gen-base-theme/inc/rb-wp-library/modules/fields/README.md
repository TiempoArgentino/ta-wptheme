# Fields API

The Fields API is primarily used to manage **meta fields and values** in
posts, terms, menu items, and attachments. It can also be used as a stand alone value input outside of these screens.

- [Adding Metaboxes](#adding-metaboxes)
- [Metabox Examples](#metabox-examples)

# Metabox Controllers

These display **meta fields** in the most common places needed on a Wordpress
site, and **manages the saving process of the meta value**.

Were thought to be used with the `fields system` to render the value input, but a custom render function can be passed through the `custom_content` parameter if needed.

When using `fields`, an array must be passed as parameter that indicates the `field`
settings, including the `controls` to use. These are completely documented in the [Fields Documentation](inc/fields/README.md)

How to use these classes can be seen in the [Metabox Controllers Documentation](inc/controllers/README.md)

# Fields

These manage the way the value input behaves both on front and backend. The different field types and arguments can be seen in the [Fields Documentation](inc/fields/README.md)

# Adding Metaboxes

Using the right metabox controller class, you can add a meta value control where you want it.
How to do this is explain in depth in the [Metabox Controllers Documentation](inc/controllers/README.md).
___________

# Metabox Examples

### 1 - Image control in term edition screen

A metabox field is added to the term edition and creation forms. This displays a new row in the form, that renders a media control that manages the image selection.

The meta key is `author_photo`, and the field is added to the `author` term.

````php
<?php
new RB_Taxonomy_Form_Field('author_photo', array(
    'title'			=> __('Photo', 'lr-genosha'),
    'terms'	        => array('author'),
    'context'		=> 'normal',
    'priority'		=> 'high',
    'classes'		=> array('my-metabox'),
    'add_form'      => true,
), array(
    'controls'		=> array(
        'logo'      => array(
            'type'    => 'RB_Media_Control',
        ),
    ),
));
?>
````
![Image field in term edition screen](/assets/imgs/documentation/term-image-field.PNG)

### 2 - Selection control in post metabox with a dedicated column in the posts list

A metabox field is added to the post edition and creation screen. This displays a new metabox on the side of the screen. The metabox contains a selection control, with four options (Common, Media, Voice Note, Photo).

A column is added to the posts list in the admin page, as indicated through the `column` argument. This column has a custom content and title, buy if these are not defined, they defaults to the meta value and the metabox title respectively.

The meta key is `article-type`, and the field is added to the `article` post type.

````php
<?php
new RB_Metabox('article-type', array(
    'title'			=> __('Type', 'lr-plugin'),
    'admin_page'	=> 'article',
    'context'		=> 'side',
    'priority'		=> 'high',
    'classes'		=> array('lr-metabox'),
    'column'        => array(
        'title'         => 'Type',
        'content'       => function($meta_value, $post_id){
            ?>
            The article type is <?php echo $meta_value; ?>
            <?php
        },
    ),
), array(
    'controls'		=> array(
        'type'   => array(
            'label'         => 'Type',
            'input_type'    => 'select',
            'choices'       => array(
                'media'             => 'Media',
                'voice'             => 'Voice Note',
                'photo'             => 'Photo',
            ),
            'input_options' => array(
                'option_none'   => array('common', 'Common'),
            ),
            'default'       => 'common',
        ),
    ),
));
?>
````

<p align="center"><b>Metabox</b></p>
<p align="center">
    <img style="max-height: 150px;" src="/assets/imgs/documentation/post-metabox-single-select.PNG">
</p>
<p align="center"><b>Column</b></p>
<p align="center">
    <img style="max-height: 150px;" src="/assets/imgs/documentation/post-meta-column.PNG">
</p>

### 3 - Repeater field on post metabox

A repeater field is added to a metabox in the post creation screen.

This kind of fields gives the user the ability to add a dinamyc amount of items and inputs values.

In this case, the control manages the options for a poll, so the user can add as many options as he wants it to have

The meta key is `poll_options`, and the field is added to the `poll` post type.

````php
<?php
new RB_Metabox('poll_options', array(
    'title'			=> __('Options', 'lr-plugin'),
    'admin_page'	=> 'poll',
    'context'		=> 'advanced',
    'priority'		=> 'high',
    'classes'		=> array('lr-metabox'),
), array(
    'repeater'          => array(
        'collapsible'       => false,
        'item_title'        => 'Option ($n)',
        //'title_link'        => 'option_label',
    ),
    'controls'		    => array(
        'option_label'      => array(
            'label'             => '',
            'input_type'        => 'text',
        )
    ),
));
?>
````

The repeater options are set in the `repeater` argument of the `field` settings.
By defining a title with a `($n)`, we make a dynamic title that replaces that string with the item current position, as seen in the following pictures.

The value stored by the repeater is an array with the value of each item. The value of the items depends of the controls, but it can contain the value of any field (single, group or repeater).

<p align="center">
    <img style="max-height: 300px;" src="/assets/imgs/documentation/post-repeater-field-metabox.PNG">
</p>
