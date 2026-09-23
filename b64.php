<?php
$data = file_get_contents('public/images/logo.png');
file_put_contents('public/images/logo_base64.txt', base64_encode($data));
