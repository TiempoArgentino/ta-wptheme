# Fields

These are a group of controllers that allows managment of settings values in an organize way.

These generate different kind of inputs based on the settings provided.

The render of these inputs are managed by extensions of the  `RB_Field_Control` class. These are called `controls`. A field can be composed of one (`single field`) or many controls (`group field`). These fields can be generated dinamically via an special kind of field called `repeater field`.

### Arguments

| Parameter           	| Type    	| Default 	| Description                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         	|
|---------------------	|---------	|:-------:	|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	|
| collapsible         	| bool    	|   true  	| If the repeater items are collapsibles                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              	|
| accordion           	| bool    	|  false  	| If collapsible is true, indicates if the items list  should behave like an accordion                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                	|
| item_title          	| string  	|    ''   	| The items title. Can be constant, or a template,  using (\$n) as a placeholder that will be replaced  by the item index.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            	|
| title_link          	| string  	|    ''   	| Name of a field to which the title of the item is linked. This will make the title change dinamically to the value of the field  it is linked to.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   	|
| item_controller     	| mixed[] 	|   null  	| The field settings for the repeater item.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           	|
| dependencies        	| array   	| null    	| Array of fields names this field visibility depends on. The field will only  be visible if all the dependencies evaluate to `true`.<br/> If a name of a dependency is preceded by a `!`, then the expected value from that dependency is `false`.<br/> If the dependencies aren't all necessary, a different type of array can be passed, setting in the first item the logic operator (`OR` or `AND`), and in the second item the array of dependencies names. If the logic operator is `OR`, then only one of the dependencies is required. If it is `AND`, then all of the dependencies must have the expected values.                                                                                                                                           	|
| global_dependencies 	| bool    	| false   	| Indicates if the dependencies of the fields should be checked outside of the parent's field; that is, with inputs that matches the dependencies in any part of the site.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            	|
| controls            	| mixed[] 	| null    	| Associative array, where the keys are the ID of the control, and the value the settings. More  than one item indicates that this is a `group` type field.<br/>  A control settings depends of the type of control it is, but there are some reserved words that  shouldn't be overwritten. <br/>  - `type`(string): Indicates the control to use (a class name). It defaults to `RB_Input_Control`.<br/>  - `label`(string)<br/>  - `description`(string)<br/> - `default`(string): The controls default value.<br/> - `controls`(array): If set, this control will be considered a `field`. The settings of the field can be set in the `controller` param.<br/> - `controller`(array): If `controls` is defined, this array contains the settings for the field.  	|

## Single Field

Generates a single field. The value stored is the one of the control input.

````php
<?php
array(//Field options
    'title'		    => 'Title',
    'description'   => 'Control description.',
    'collapsible'   => true,
    'controls'	=> array(
        'name'	=> array(
            'input_type'    => 'text',
            'label'         => 'Nombre',
        ),
    ),
)
````

## Group Field

A field that contains multiple fields. The final value is a JSON containing the value for each of the group fields.

A field with only one control can be forced to be a group by setting `group => true`.

````php
<?php
array(//Field options
    'title'		    => 'Title',
    'description'   => 'Control description.',
    'collapsible'   => true,
    'controls'	=> array(
        'first'	=> array(
            'input_type'    => 'text',
            'label'         => 'Single Nº1',
        ),
        'secnod'	=> array(
            'input_type'    => 'text',
            'label'         => 'Single Nº2',
        ),
    ),
)
````

A group is not restricted to single fields; it can also contain other groups or repeaters.

#### Group of Groups

For an inner field to be considered a group, it must have defined an array of controls in the `controls` parameter, with more than one control.

The inner group settings are passed through the parameter `controller`. This options are the same that can be used in the top level field.

````php
<?php

array(//Field options
    'title'		    => 'Title',
    'description'   => 'Control description.',
    'collapsible'   => true,
    'controls'	=> array(
        'first_inner_group'	=> array(
            'controller'    => array(// Field Settings
                'title' => 'Subgrupo Nº1',
                'description'   => 'Soy la description del grupo dentro del grupo (inception)',
            ),
            'controls'  => array( // Inner group controls
                'first' => array(
                    'label'         => 'Single Nº1',
                    'input_type'    => 'text',
                ),
                'second' => array(
                    'label'         => 'Single Nº2',
                    'input_type'    => 'text',
                ),
            ),
        ),
        'second_inner_group'	=> array( // Field Settings
            'controller'    => array(
                'title' => 'Subgrupo Nº2',
            ),
            'controls'  => array( // Inner group controls
                'first' => array(
                    'label'         => 'Single Nº1',
                    'input_type'    => 'text',
                ),
                'second' => array(
                    'label'         => 'Single Nº2',
                    'input_type'    => 'text',
                ),
            ),
        ),
    ),
)
````

#### Group of Repeaters

For an inner field to be considered a group, in its settings the `repeater` parameter should evaluate to true (see more in the repeater section).

````php
<?php

array(//Field options
    'title'		    => 'Title',
    'description'   => 'Control description.',
    'collapsible'   => true,
    'controls'	=> array(
        'first_repeater'	=> array(
            'controller'    => array( // Field Settings
                'title' => 'Repeater Nº1',
                'description'   => 'Soy la description del repeater dentro del grupo',
                'repeater'      => true, // Makes the inner field a repeater
            ),
            'controls'  => array( // Repeater fields - Only one control -> Single field
                'first' => array(
                    'label'         => 'Single Nº1',
                    'input_type'    => 'text',
                ),
            ),
        ),
        'second_repeater'	=> array(
            'controller'    => array( // Field Settings
                'title' => 'Repeater Nº2',
                'repeater'      => true,
            ),
            'controls'  => array( // Repeater fields - Multiples controls -> Group field
                'first' => array(
                    'label'         => 'Single Nº1',
                    'input_type'    => 'text',
                ),
                'second' => array(
                    'label'         => 'Single Nº2',
                    'input_type'    => 'text',
                ),
            ),
        ),
    ),
)
````

## Repeater

The repeater is a type of field that allows the dynamic generation of new fields (singles, groups and repeaters). The value of the repeater is an array containing the values of the items fields.

To make a repeater, the `repeater` index of the options array must evaluate to `true`. This parameter can also be setted to an array of options for the repeater and its items. This array may contain the following options:

| Parameter       	| Type   	| Default 	| Description                                                                                                                                       	|
|-----------------	|--------	|:-------:	|---------------------------------------------------------------------------------------------------------------------------------------------------	|
| collapsible     	| bool   	|   true  	| If the repeater items are collapsibles                                                                                                            	|
| accordion       	| bool   	|  false  	| If collapsible is true, indicates if the items list  should behave like an accordion                                                              	|
| item_title      	| string 	|    ''   	| The items title. Can be constant, or a template,  using (\$n) as a placeholder that will be replaced  by the item index.                          	|
| title_link      	| string 	|    ''   	| Name of a field to which the title of the item is linked. This will make the title change dinamically to the value of the field  it is linked to. 	|
| item_controller 	| mixed  	|   null  	| The field settings for the repeater item.                                                                                                         	|

#### Example: Repeater of Single Fields

````php
<?php

array(//Field options
    'title'		    => 'Title',
    'description'   => 'Control description.',
    'repeater'      => true, // Indicates that this field is a repeater
    'controls'	=> array( //This are the controls the repeater items will have
        'first'	=> array(
            'label'         => 'Single Nº1',
            'input_type'    => 'text',
        ),
    ),
)
````
