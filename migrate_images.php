<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\File;

$source = storage_path('app/public');
$destination = public_path('images');

if (!File::exists($destination)) {
    File::makeDirectory($destination, 0755, true);
}

$items = File::allFiles($source);
$copied = 0;
$skipped = 0;

foreach ($items as $item) {
    $ext = strtolower($item->getExtension());
    $relativePath = $item->getRelativePathname();
    $targetPath = $destination . '/' . $relativePath;
    $targetDir = dirname($targetPath);
    
    if (!File::exists($targetDir)) {
        File::makeDirectory($targetDir, 0755, true);
    }
    
    if (!File::exists($targetPath)) {
        File::copy($item->getPathname(), $targetPath);
        $copied++;
        echo "Copied: {$relativePath}\n";
    } else {
        $skipped++;
        echo "Skipped (already exists): {$relativePath}\n";
    }
}

echo "Migration completed. Copied: $copied, Skipped: $skipped\n";
