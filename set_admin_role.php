<?php
require_once('../../config.php');
require_login();
$context = context_system::instance();

if (!is_siteadmin()) {
    print_error('Anda tidak memiliki izin untuk mengakses halaman ini');
}

$PAGE->set_url(new moodle_url('/local/adminmenu/set_admin_role.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('setadminrole', 'local_adminmenu'));
$PAGE->set_heading(get_string('setadminrole', 'local_adminmenu'));

echo $OUTPUT->header();

// Ambil daftar peran dalam konteks sistem
$roles = get_all_roles();
$stored_role = get_config('local_adminmenu', 'admin_role');

// Proses penyimpanan jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['admin_role'])) {
    $selected_role = clean_param($_POST['admin_role'], PARAM_INT);
    
    // Simpan peran yang dipilih ke konfigurasi Moodle
    set_config('admin_role', $selected_role, 'local_adminmenu');

    // Refresh halaman agar pilihan terbaru ditampilkan
    redirect(new moodle_url('/local/adminmenu/set_admin_role.php'));
}

// Form pemilihan peran admin
echo '<form method="post" action="">';
echo '<label for="admin_role">Pilih Peran Admin:</label>';
echo '<select name="admin_role" id="admin_role">';

// Loop untuk menampilkan opsi peran dalam dropdown
foreach ($roles as $role) {
    if (!empty($role->name)) { // Hanya tampilkan role yang memiliki nama
        $selected = ($role->id == $stored_role) ? 'selected' : '';
        echo '<option value="' . $role->id . '" ' . $selected . '>' . $role->name . '</option>';
    }
}

echo '</select><br><br>';
echo '<input type="submit" value="Simpan">';
echo '</form>';

echo '<div style="margin-top: 10px;"><a href="' . new moodle_url('/local/adminmenu/index.php') . '" style="margin-right:20px;">Back</a></div>';

echo $OUTPUT->footer();
