<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'local/adminmenu:adminmenu' => [
        'captype' => 'edit',
        'contextlevel' => CONTEXT_SYSTEM,
    ]
];
