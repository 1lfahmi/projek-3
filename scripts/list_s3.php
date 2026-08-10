<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$disk = Illuminate\Support\Facades\Storage::disk('s3');
$files = $disk->allFiles('mobil');
foreach ($files as $file) {
    echo $file . PHP_EOL;
}