<?php
require_once('../../config.php');
require_login();
$context = context_system::instance();

if (!is_siteadmin()) {
    print_error('You do not have permission to access this page');
}

$PAGE->set_url(new moodle_url('/local/adminmenu/index.php'));
$PAGE->set_context($context);
$PAGE->set_title('Admin Menu');
$PAGE->set_heading('Admin Menu');

echo $OUTPUT->header();

echo '<div style="margin-top: 50px;"><b>Set Admin Menu</b></div>';
echo '<div style="margin-bottom: 10px;"><a href="' . new moodle_url('/local/adminmenu/index_en.php') . '" style="margin-right:20px;">English</a>';
echo '<a href="' . new moodle_url('/local/adminmenu/index_id.php') . '">Indonesia</a></div>';

echo '<div><b>Set Admin Role</b></div>';
echo '<div><a href="' . new moodle_url('/local/adminmenu/set_admin_role.php') . '" style="margin-right:20px;">Set Admin role</a></div>';

echo $OUTPUT->footer();