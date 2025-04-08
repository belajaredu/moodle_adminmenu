<?php
defined('MOODLE_INTERNAL') || die();

$functions = [
    'local_adminmenu_extend_navigation' => [
        'classname'   => 'local_adminmenu_external',
        'methodname'  => 'extend_navigation',
        'classpath'   => 'local/adminmenu/lib.php',
        'description' => 'Extend navigation for admin menu',
        'type'        => 'read',
        'capabilities'=> 'moodle/site:config'
    ]
];

$services = [
    'local_adminmenu_service' => [
        'functions' => ['local_adminmenu_extend_navigation'],
        'restrictedusers' => 0,
        'enabled' => 1,
        'shortname' => 'adminmenu_service'
    ]
];
