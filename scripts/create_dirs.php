<?php
$dirs = [
    'bootstrap/cache',
    'storage/app/public',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
];

foreach ($dirs as $d) {
    if (!is_dir($d)) {
        mkdir($d, 0777, true);
    }
}

echo "Created runtime directories:\n";
foreach ($dirs as $d) {
    echo " - $d\n";
}
