<?php

/**
*   Ver argumentos del constructor de suplementos en LR_Suplementos.php
*/

// Creacion de un nuevo suplemento
// new TA_Micrositio('test', array(
//     'title'                 => 'Test',
//     'priority'              => 2,
//     //'custom_content'       => true,
//     //'public'             => false,
// ));

// Eliminacion del suplemento (ademas de borrar el anterior new TA_Micrositio)
// add_action('init', function(){
//     TA_Micrositio::delete_suplement( 'test' );
// });

new TA_Micrositio('ambiental', array(
    'title'                 => 'Activo ambiental',
    'priority'              => 1,
    'custom_content'        => true,
    // 'public'                => false,
));

new TA_Micrositio('habitat', array(
    'title'                 => 'Hábitat & Pandemia',
    'priority'              => 2,
    'custom_content'        => true,
));

new TA_Micrositio('medios', array(
    'title'                 => 'Monitor de medios',
    'priority'              => 3,
    'custom_content'        => true,
));

new TA_Micrositio('radiografia-del-vaciamiento', array(
    'title'                 => 'Radiografías del Vaciamiento',
    'priority'              => 3,
    'custom_content'        => true,
));
