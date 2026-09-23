<?php
$im = imagecreatefrompng('public/images/logo.png');
imagealphablending($im, false);
imagesavealpha($im, true);
ob_start();
imagepng($im);
$data = ob_get_clean();
$b64 = base64_encode($data);
file_put_contents('public/images/logo_clean_base64.txt', $b64);
echo "Clean Base64 Length: " . strlen($b64) . "\n";
