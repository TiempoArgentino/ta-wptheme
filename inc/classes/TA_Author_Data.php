<?php

class TA_Author_Data extends Data_Manager{
    protected $defaults = array(
        'name'              => '',
        'position'          => '',
        'social'            => '',
        'photo'             => '',
        'archive_url'       => '',
        'subject'           => '',
        'quote'             => '',
        'bio'               => '',
        'networks'          => null,
    );
}
