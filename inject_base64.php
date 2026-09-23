<?php
$bladePath = 'resources/views/pdf/registration.blade.php';
$content = file_get_contents($bladePath);

$b64 = file_get_contents('public/images/logo_clean_base64.txt');
$dataUri = 'data:image/png;base64,' . $b64;

$phpBlockStart = "@php\n                    // Array of possible paths to handle InfinityFree";
$phpBlockEnd = "@endphp";

$startPos = strpos($content, "@php\n                    // Array of possible paths to handle InfinityFree");
if ($startPos !== false) {
    $endPos = strpos($content, "@endphp", $startPos) + strlen("@endphp");
    
    $newPhpBlock = "                @php\n" .
                   "                    // Hardcoded Base64 Data URI to bypass ALL InfinityFree file reading/GD issues\n" .
                   "                    \$logoDataUri = '$dataUri';\n" .
                   "                @endphp";
                   
    $newContent = substr($content, 0, $startPos) . ltrim($newPhpBlock) . substr($content, $endPos);
    file_put_contents($bladePath, $newContent);
    echo "Successfully injected hardcoded Base64 into blade file.\n";
} else {
    echo "Could not find the PHP block in the blade file.\n";
}
