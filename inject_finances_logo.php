<?php
// Generate clean base64 for logo-cos.png
$im = @imagecreatefrompng('public/images/logo-cos.png');
if ($im) {
    imagealphablending($im, false);
    imagesavealpha($im, true);
    ob_start();
    imagepng($im);
    $data = ob_get_clean();
    $b64 = base64_encode($data);
} else {
    $b64 = base64_encode(file_get_contents('public/images/logo-cos.png'));
}

$dataUri = 'data:image/png;base64,' . $b64;

// Inject into pdf.blade.php
$bladePath = 'resources/views/admin/finances/pdf.blade.php';
$content = file_get_contents($bladePath);

// Replace <img src="{{ public_path('images/logo-cos.png') }}" alt="Logo COS">
$search = '<img src="{{ public_path(\'images/logo-cos.png\') }}" alt="Logo COS">';
$replace = '<img src="' . $dataUri . '" alt="Logo COS">';

$newContent = str_replace($search, $replace, $content);
file_put_contents($bladePath, $newContent);

echo "Successfully injected base64 for logo-cos.png into pdf.blade.php\n";
