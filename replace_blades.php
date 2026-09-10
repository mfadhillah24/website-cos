<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\File;

$excludeFiles = [
    'admin/letters/incoming/show.blade.php',
    'admin/letter-templates/index.blade.php',
    'admin/letter-templates/show.blade.php',
    'admin/letters/outgoing/show.blade.php',
    'admin/archives/show.blade.php'
];

$files = File::allFiles(resource_path('views'));

foreach ($files as $file) {
    $relativePath = str_replace('\\', '/', $file->getRelativePathname());
    
    if (in_array($relativePath, $excludeFiles)) {
        continue;
    }
    
    $content = file_get_contents($file->getPathname());
    
    $newContent = preg_replace('/\\\\Illuminate\\\\Support\\\\Facades\\\\Storage::url\(([^)]+)\)/', "asset('images/' . $1)", $content);
    $newContent = preg_replace('/Storage::url\(([^)]+)\)/', "asset('images/' . $1)", $newContent);

    if ($content !== $newContent) {
        file_put_contents($file->getPathname(), $newContent);
        echo "Updated: $relativePath\n";
    }
}
echo "Blade files updated.\n";
