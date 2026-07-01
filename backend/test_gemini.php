<?php
require 'vendor/autoload.php';

use Google\Cloud\AiPlatform\V1\Client\PredictionServiceClient;
use Google\Cloud\AiPlatform\V1\PredictRequest;

// Konfigurasi Project
$projectId = 'your-gcp-project-id';
$location = 'us-central1';
$modelId = 'gemini-1.5-flash';

// Inisialisasi Client
$client = new PredictionServiceClient([
    'apiEndpoint' => "{$location}-aiplatform.googleapis.com",
]);

echo "Koneksi Vertex AI siap. (Ingat ganti project ID dan set GOOGLE_APPLICATION_CREDENTIALS)\n";
?>
