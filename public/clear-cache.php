<?php
// File sementara untuk clear cache di hosting
// Upload ke public/ lalu akses sekali, kemudian HAPUS file ini!

$viewsPath = dirname(__DIR__) . '/storage/framework/views/';
$configPath = dirname(__DIR__) . '/bootstrap/cache/';

$cleared = [];
$errors = [];

// Clear compiled views
if (is_dir($viewsPath)) {
    $files = glob($viewsPath . '*');
    foreach ($files as $file) {
        if (is_file($file)) {
            if (unlink($file)) {
                $cleared[] = basename($file);
            } else {
                $errors[] = basename($file);
            }
        }
    }
}

// Clear config cache
foreach (['config.php', 'routes-v7.php', 'packages.php'] as $cacheFile) {
    $path = $configPath . $cacheFile;
    if (file_exists($path)) {
        if (unlink($path)) {
            $cleared[] = 'bootstrap/cache/' . $cacheFile;
        }
    }
}

echo '<h2>Cache Cleared!</h2>';
echo '<p>Cleared ' . count($cleared) . ' files:</p><ul>';
foreach ($cleared as $f) echo '<li>' . htmlspecialchars($f) . '</li>';
echo '</ul>';
if ($errors) {
    echo '<p style="color:red">Failed to delete:</p><ul>';
    foreach ($errors as $f) echo '<li>' . htmlspecialchars($f) . '</li>';
    echo '</ul>';
}
echo '<p><strong>PENTING: Hapus file ini dari hosting setelah digunakan!</strong></p>';
