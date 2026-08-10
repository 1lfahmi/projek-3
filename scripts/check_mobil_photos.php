<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$mobils = App\Models\Mobil::all();
$disk = Illuminate\Support\Facades\Storage::disk('s3');
$s3Files = array_flip($disk->allFiles('mobil'));

foreach ($mobils as $mobil) {
    $foto = $mobil->foto;
    $exists = $foto && isset($s3Files[$foto]) ? 'true' : 'false';
    echo sprintf("ID=%s SERI=%s FOTO=%s EXISTS=%s\n", $mobil->id, $mobil->seri, $foto ?? 'NULL', $exists);
}

echo "\nS3 file list (mobil/):\n";
foreach (array_keys($s3Files) as $file) {
    echo "$file\n";
}