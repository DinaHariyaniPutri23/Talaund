<?php
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Run migration
echo "Running migrations...\n";
Artisan::call('migrate');

// Seed MSatuan
echo "Seeding MSatuan...\n";
Artisan::call('db:seed', ['--class' => 'Database\Seeders\MSatuanSeeder']);

echo "Done!\n";
