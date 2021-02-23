# **Components Module**

Creation and utilization of components across the Wordpress site, following a
MVC architecture.

- [Creating a component](#creating-a-component)
    -  [Template](#component-view-template)
        -  [Arguments](#arguments)
        -  [Default Arguments](#default-arguments)
    -  [Controller](#component-controller)
    -  [Options](#options)
- [Using a component](#using-a-component)
- [Filter component view](#filter-component-view)
- [Filter component options](#filter-component-options)

# Creating a component

Components must be located under the *components* folder directly under the theme
or child theme folder.

Each component has its own folder. The folders name acts as the component identifier.

Folder architecture:

- theme
    - components
        -  component_name
            -  **(required)** view.php
            -  *(optional)* controller.php
            -  *(optional)* options.php

A child theme component files will override the ones of the component of same name in the parent theme.

## Component View - Template

There must be a `view.php` file inside the folder for it to work. This file prints
the component content.

#### Arguments
Arguments can be passed to the `view.php` template when rendering the component. This
arguments can be accessed through the `$args` variable directly from the template.

#### Default Arguments
See the `defaults` option documentation on the [Options](#options) section

## Component Controller

The optional `controller.php` file allows to run whatever code we want when the component is
included. It is only called once.

It intended to be used to enqueue required scripts for the component to work.

## Options

The optional `options.php` file must return an array with the following options:

| Parameter    	| Type     	| Default 	| Description                                                                                                                                                                     	|
|--------------	|----------	|---------	|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	|
| defaults     	| mixed[]  	| []      	| Array of default variables to use in the template `view.php` file. Overriden by the arguments passed on `render`, and accesible in the template file from the `$args` variable. 	|
| dependencies 	| string[] 	| []      	| Name of the components that need to be loaded before this one. This will require the components controllers.                                                                    	|

-----

# Using a component

Once a component is set up, it can be rendered by calling `gen_render_component((string) $component_name, (array) $view_args, (array) $controller_args)`

````php
<?php
gen_render_component('rb-collapsible', array(
    'title'         => 'Collapsible Title',
    'content'       => 'Collapsible Content :)',
));
````

| Parameter        	| Type    	| Default 	| Required 	| Description                                               	|
|------------------	|---------	|---------	|----------	|-----------------------------------------------------------	|
| $component_name  	| string  	| null    	| Yes      	| The component folder name                                 	|
| $view_args       	| mixed[] 	| array() 	| No       	| Array of arguments to passed to the component view.       	|
| $controller_args 	| mixed[] 	| array() 	| No       	| Array of arguments to passed to the component controller. 	|


# Filter Component View

The filter `gen_component_{$component_name}_view` allows you to filter the component view.
The content is passed as a string and must be return the same way.

## Example

Here we wrap the view of a component named `rb-collapsible` inside a div.

````php
<?php

add_filter("gen_component_rb-collapsible_view", function($view){
    ob_start()
    ?>
    <div class="special-collapsible">
        <?php echo $view; ?>
    </div>
    <?php
	return ob_get_clean();
});
````

# Filter Component Options

The filter `gen_component_{$component_name}_options` lets you filter the component options array.
