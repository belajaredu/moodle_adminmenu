<?php
require_once('../../config.php');
require_login();
$context = context_system::instance();

if (!is_siteadmin()) {
    print_error('You do not have permission to access this page');
}

$PAGE->set_url(new moodle_url('/local/adminmenu/index_id.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('adminmenu', 'local_adminmenu'));
$PAGE->set_heading(get_string('adminmenu', 'local_adminmenu'));

echo $OUTPUT->header();

// Proses penyimpanan jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_name = clean_param($_POST['menu_name'], PARAM_TEXT);
    
    // Simpan Menu Name
    set_config('adminmenu_name_id', $menu_name, 'local_adminmenu');
    
    // Simpan sub menu dan URL
    for ($i = 1; $i <= 10; $i++) {
        $submenu = clean_param($_POST["submenu_$i"], PARAM_TEXT);
        $menu_url = clean_param($_POST["menu_url_$i"], PARAM_URL);
        
        set_config("submenu_id_$i", $submenu, 'local_adminmenu');
        set_config("menu_url_id_$i", $menu_url, 'local_adminmenu');
    }

    echo '<p style="color: green;">Menu updated successfully!</p>';
}

// Ambil nilai yang tersimpan
$stored_menu_name = get_config('local_adminmenu', 'adminmenu_name_id');

// Ambil submenu dan URL yang tersimpan
$submenus = [];
$menu_urls = [];
for ($i = 1; $i <= 10; $i++) {
    $submenus[$i] = get_config('local_adminmenu', "submenu_id_$i") ?: '';
    $menu_urls[$i] = get_config('local_adminmenu', "menu_url_id_$i") ?: '';
}

// Form input untuk Menu Name
echo '<form method="post" action="">';
echo '<label for="menu_name">Menu Name:</label>';
echo '<input type="text" name="menu_name" id="menu_name" value="' . s($stored_menu_name) . '"><br><br>';

// Tabel untuk Sub Menu dan URL
echo '<table border="1">';
echo '<tr><th>Sub Menu</th><th>URL</th></tr>';
for ($i = 1; $i <= 10; $i++) {
    echo '<tr>';
    echo '<td><input type="text" name="submenu_' . $i . '" value="' . s($submenus[$i]) . '"></td>';
    echo '<td><input type="text" name="menu_url_' . $i . '" value="' . s($menu_urls[$i]) . '"></td>';
    echo '</tr>';
}
echo '</table><br>';

echo '<input type="submit" value="Save">';
echo '</form>';

echo '<div style="margin-top: 10px;"><a href="' . new moodle_url('/local/adminmenu/index.php') . '" style="margin-right:20px;">Back</a></div>';

echo $OUTPUT->footer();
