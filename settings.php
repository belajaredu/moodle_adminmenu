<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // Menambahkan halaman langsung ke "Appearance"
    $ADMIN->add('appearance', new admin_externalpage(
        'local_adminmenu',
        get_string('adminmenu', 'local_adminmenu'),
        new moodle_url('/local/adminmenu/index.php')
    ));
}