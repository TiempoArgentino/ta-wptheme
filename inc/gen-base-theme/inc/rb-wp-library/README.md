# RB Wordpress Library

A series of functionalities that facilitate the realization of common and
recurrent tasks a developer faces while creating a Wordpress theme or plugin.

# Utilization

To load the library, one must include `rb-wordpress-framework.php` in the proyect to use.

# Modules - APIs

The library is composed of `modules` that manages specific functionalities. Most of the
modules are not loaded by default. To load the module, you execute the `load_module` method from the class `RB_Wordpress_Framework`, passing the module name (these are
documented below).

````php
<?php
/**
*   @param string $module_name
*/
RB_Wordpress_Framework::load_module($module_name);
?>
````

## Fields

The Fields API is primarily used to manage **meta fields and values** in
posts, terms, menu items, and in the customizer.

It allows the use of ``single``, ``group``, and ``repeater`` fields. These fields usually display `controls` that manages the front end of the value input, but a custom render function can be assign to render the input. The module comes with some basic `controls`, but you can create your own.

Check the [Fields API Documentation](modules/fields/README.md) and start adding some fields!
