<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Barryvdh\DomPDF\Facade\Pdf;

// Test 1: Base64 image
$logoPath = public_path('images/logo.png');
$logoData = file_get_contents($logoPath);
$logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);

$html = '<html><body><h1>Base64 Test</h1><img src="' . $logoBase64 . '" width="60"></body></html>';

try {
    $pdf = Pdf::loadHTML($html);
    file_put_contents(storage_path('app/test_base64.pdf'), $pdf->output());
    echo "Base64 OK. Size: " . filesize(storage_path('app/test_base64.pdf')) . "\n";
} catch (\Exception $e) {
    echo "Base64 Error: " . $e->getMessage() . "\n";
}

// Test 2: Absolute path with chroot
$html2 = '<html><body><h1>Path Test</h1><img src="' . $logoPath . '" width="60"></body></html>';
try {
    $pdf2 = Pdf::setOptions(['chroot' => public_path(), 'tempDir' => storage_path('app')])->loadHTML($html2);
    file_put_contents(storage_path('app/test_path.pdf'), $pdf2->output());
    echo "Path OK. Size: " . filesize(storage_path('app/test_path.pdf')) . "\n";
} catch (\Exception $e) {
    echo "Path Error: " . $e->getMessage() . "\n";
}
