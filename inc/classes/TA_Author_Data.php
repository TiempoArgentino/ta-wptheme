<?php

class TA_Author_Data extends Data_Manager{
    protected $defaults = array(
        'ID'                => null,
        'name'              => '',
        'position'          => '',
        'social'            => '',
        'socials'           => '',
        'photo'             => '',
        'has_photo'         => false,
        'archive_url'       => '',
        'subject'           => '',
        'quote'             => '',
        'bio'               => '',
        'networks'          => null,
    );
}
