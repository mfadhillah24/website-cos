<?php
$im = imagecreatefrompng('public/images/logo.png');
imagealphablending($im, false);
imagesavealpha($im, true);
imagepng($im, 'public/images/logo_pdf.png');
echo "Created logo_pdf.png successfully.\n";
