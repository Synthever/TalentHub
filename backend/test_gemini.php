<?php
require 'vendor/autoload.php';

// Coba gunakan namespace yang benar berdasarkan composer show
// Autoload psr-4: Google\Cloud\AIPlatform\ => src
// Berarti class-nya harusnya dimulai dengan Google\Cloud\AIPlatform\

use Google\Cloud\AIPlatform\V1\PredictionServiceClient;

echo "Mencoba menginisialisasi PredictionServiceClient...\n";

try {
    $client = new PredictionServiceClient([
        'apiEndpoint' => 'us-central1-aiplatform.googleapis.com',
    ]);
    echo "Berhasil inisialisasi client!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
