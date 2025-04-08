<?php
defined('MOODLE_INTERNAL') || die();

function local_adminmenu_extend_navigation() {
    global $PAGE, $USER, $DB;

    // Ambil bahasa antarmuka pengguna
    $userlang = current_language();

    // Ambil role yang diizinkan dari konfigurasi
    $allowed_role = get_config('local_adminmenu', 'admin_role');

    // Cek apakah pengguna memiliki role yang diizinkan
    $user_roles = $DB->get_records('role_assignments', ['userid' => $USER->id]);
    $has_access = is_siteadmin();

    foreach ($user_roles as $role) {
        if ($role->roleid == $allowed_role) {
            $has_access = true;
            break;
        }
    }

    // Jika user tidak memiliki role yang diizinkan, jangan tampilkan menu
    if (!$has_access) {
        return;
    }

    // Pilih menu utama berdasarkan bahasa
    if ($userlang === 'en') {
        $menu_name = get_config('local_adminmenu', 'adminmenu_name_en');
        $menu_url = new moodle_url('/local/adminmenu/index_en.php');
    } elseif ($userlang === 'id') {
        $menu_name = get_config('local_adminmenu', 'adminmenu_name_id');
        $menu_url = new moodle_url('/local/adminmenu/index_id.php');
    } else {
        return;
    }

    // Jika tidak ada nama menu, hentikan proses
    if (empty($menu_name)) {
        return;
    }

    // Bangun submenu dengan elemen <div class="dropdown-menu">
    $divsubmenu = '';

    for ($i = 1; $i <= 10; $i++) {
        $submenu = get_config('local_adminmenu', "submenu_{$userlang}_$i");
        $menu_url_item = new moodle_url(get_config('local_adminmenu', "menu_url_{$userlang}_$i"));
        
        if (empty($submenu) || empty($menu_url_item)) {
            break; // Stop jika ada submenu yang kosong
        }

        $divsubmenu .= '<a class="dropdown-item" role="menuitem" href="' . $menu_url_item . '" tabindex="-1">' . s($submenu) . '</a>';
    }

    // Tambahkan menu utama ke navigasi dengan submenus
    $PAGE->requires->js_init_code("
        document.addEventListener('DOMContentLoaded', function() {
            let menuElement = document.querySelector('ul[role=menubar]');
            if (menuElement) {
                let newMenuItem = document.createElement('li');
                newMenuItem.className = 'dropdown nav-item';
                newMenuItem.innerHTML = `<a class='dropdown-toggle nav-link' role='menuitem' data-toggle='dropdown' style='cursor:pointer;'>" . s($menu_name) . "</a>`;
               
                
                let div_ = document.createElement('div');
                div_.className = 'dropdown-menu';
                div_.setAttribute('role', 'menu');
                div_.innerHTML = `$divsubmenu`;
                newMenuItem.appendChild(div_);
                
                 menuElement.appendChild(newMenuItem);
            }
        });
    ");
}


function local_adminmenu_extend_navigation_callback() {
    global $PAGE;
    local_adminmenu_extend_navigation();
}