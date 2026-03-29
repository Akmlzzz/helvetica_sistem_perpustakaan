<?php
require __DIR__ . "/vendor/autoload.php";
$app = require_once __DIR__ . "/bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$series = App\Models\Series::find(3);
if ($series) {
    echo "Series found: " . $series->nama_series . "\n";
    $bukus = collect([
        ['id' => 1, 'v' => 2],
        ['id' => 1, 'v' => null],
    ])->sortBy('v');
    echo "BUKUS: " . json_encode($bukus->pluck('id'));

    $bks = $series->buku;
    echo "Series has " . count($bks) . " books.\n";
    foreach($bks->sortBy('nomor_volume') as $b) {
        echo "- " . $b->judul_buku . " (Vol: " . $b->nomor_volume . ")\n";
    }
} else {
    echo "Series 3 not found.";
}
