<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$m = App\Models\Mobil::first();
echo "FOTO=" . ($m ? $m->foto : 'NULL') . PHP_EOL;
if ($m) {
    $exists = Illuminate\Support\Facades\Storage::disk('s3')->exists($m->foto);
    echo "EXISTS=" . ($exists ? 'true' : 'false') . PHP_EOL;
    echo "URL=" . Illuminate\Support\Facades\Storage::disk('s3')->url($m->foto) . PHP_EOL;
}