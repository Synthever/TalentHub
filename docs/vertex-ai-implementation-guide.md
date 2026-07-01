# Panduan Implementasi Vertex AI (Google Cloud)

## Daftar Isi
- [Pengenalan](#pengenalan)
- [Arsitektur Sistem](#arsitektur-sistem)
- [Prasyarat](#prasyarat)
- [Setup Google Cloud Project](#setup-google-cloud-project)
- [Konfigurasi Service Account](#konfigurasi-service-account)
- [Instalasi Dependencies](#instalasi-dependencies)
- [Struktur Kode](#struktur-kode)
- [Implementasi Service Class](#implementasi-service-class)
- [Implementasi Controller](#implementasi-controller)
- [Konfigurasi Environment](#konfigurasi-environment)
- [Penggunaan API](#penggunaan-api)
- [Error Handling](#error-handling)
- [Best Practices](#best-practices)
- [Troubleshooting](#troubleshooting)
- [Migrasi ke Project Lain](#migrasi-ke-project-lain)

---

## Pengenalan

Dokumentasi ini menjelaskan cara kerja implementasi **Vertex AI (Google Cloud Gemini API)** pada project Arthananta Financial Management. Implementasi ini menggunakan **Gemini 2.0 Flash** model untuk memproses data keuangan melalui:

1. **Natural Language Processing (NLP)** - Memproses teks voice input untuk ekstraksi data transaksi
2. **Computer Vision (OCR)** - Memproses gambar struk/receipt untuk ekstraksi data transaksi
3. **Conversational AI** - Chat assistant untuk analisis keuangan personal

### Keunggulan Vertex AI vs Google AI Studio

| Fitur | Vertex AI | Google AI Studio (API Key) |
|-------|-----------|---------------------------|
| Authentication | OAuth2 Service Account | API Key |
| Production Ready | ✅ Ya | ⚠️ Limited |
| Billing Control | ✅ Terpisah per project | ❌ Shared quota |
| Enterprise Features | ✅ Ya (IAM, Audit Logs) | ❌ Tidak |
| Rate Limits | ✅ Higher | ⚠️ Lower |
| Keamanan | ✅ Service Account + IAM | ⚠️ API Key dapat dicuri |

Project ini mendukung **kedua metode** dengan sistem fallback untuk fleksibilitas development.

---

## Arsitektur Sistem

### Diagram Alur

```
┌─────────────────┐
│  Client App     │
│ (Flutter/Web)   │
└────────┬────────┘
         │ HTTP Request (POST)
         ▼
┌─────────────────────────────────────────┐
│         AiController.php                │
│  ┌───────────────────────────────────┐  │
│  │ processVoice()                    │  │
│  │ processReceipt()                  │  │
│  └───────────────┬───────────────────┘  │
└──────────────────┼──────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────┐
│         GeminiService.php               │
│  ┌───────────────────────────────────┐  │
│  │ • processVoiceText()              │  │
│  │ • processReceiptImage()           │  │
│  │ • processChat()                   │  │
│  │ • parseAndPriceInvestments()      │  │
│  └───────────────┬───────────────────┘  │
│                  │                       │
│  ┌───────────────▼───────────────────┐  │
│  │ Authentication Handler            │  │
│  │ • getAccessToken() (Vertex)       │  │
│  │ • API Key (Google AI Studio)      │  │
│  └───────────────┬───────────────────┘  │
└──────────────────┼──────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────┐
│    Google Cloud Vertex AI               │
│    Gemini 2.0 Flash Model               │
└─────────────────┬───────────────────────┘
                  │
                  ▼
          JSON Response
```

### Komponen Utama

1. **GeminiService** - Service class yang menangani semua interaksi dengan Gemini API
2. **AiController** - Controller yang mengekspos endpoint API untuk client
3. **ServiceAccountCredentials** - Google Auth library untuk OAuth2
4. **GuzzleHTTP Client** - HTTP client untuk komunikasi dengan Vertex AI

---

## Prasyarat

### 1. Google Cloud Account
- Akun Google Cloud dengan billing enabled
- Project GCP yang sudah dibuat

### 2. PHP Environment
- PHP 8.0 atau lebih tinggi
- Composer untuk dependency management
- Extension PHP yang diperlukan:
  - `ext-json`
  - `ext-curl`
  - `ext-mbstring`

### 3. Dependencies Composer
```json
{
  "require": {
    "guzzlehttp/guzzle": "^7.0",
    "google/auth": "^1.0"
  }
}
```

---

## Setup Google Cloud Project

### 1. Buat Project Baru atau Gunakan Existing

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Klik dropdown project di header → **New Project**
3. Masukkan nama project (contoh: `my-app-ai-service`)
4. Catat **Project ID** (bukan nama, tapi ID unik)

### 2. Enable Vertex AI API

1. Di Google Cloud Console, buka **APIs & Services** → **Enable APIs and Services**
2. Cari **Vertex AI API**
3. Klik **Enable**
4. Tunggu hingga API aktif (biasanya 1-2 menit)

### 3. Enable Billing

⚠️ **PENTING**: Vertex AI adalah layanan berbayar. Tanpa billing, API akan mengembalikan error `BILLING_DISABLED`.

1. Buka **Billing** di menu navigasi
2. Link project Anda ke billing account
3. Set up payment method jika belum

**Estimasi Biaya** (per 1 juta karakter):
- Gemini 2.0 Flash: $0.075 (input) / $0.30 (output)
- Untuk aplikasi keuangan personal: ~$5-10/bulan dengan 1000 users aktif

---

## Konfigurasi Service Account

### 1. Buat Service Account

1. Di Google Cloud Console → **IAM & Admin** → **Service Accounts**
2. Klik **Create Service Account**
3. Masukkan detail:
   - **Name**: `vertex-ai-service`
   - **Description**: `Service account for Vertex AI API access`
4. Klik **Create and Continue**

### 2. Grant Permissions

Berikan role berikut ke service account:
- **Vertex AI User** (`roles/aiplatform.user`)

Cara:
1. Di halaman create service account, pada step "Grant this service account access to project"
2. Pilih role **Vertex AI User**
3. Klik **Continue**

### 3. Generate JSON Key

1. Pada step "Grant users access to this service account" → skip (klik **Done**)
2. Di daftar service accounts, klik service account yang baru dibuat
3. Tab **Keys** → **Add Key** → **Create New Key**
4. Pilih **JSON** → **Create**
5. File JSON akan terdownload otomatis

**⚠️ KEAMANAN**: File JSON ini adalah kredensial sensitif. JANGAN commit ke Git!

### 4. Simpan Service Account Key

Letakkan file JSON di lokasi aman dalam project:
```
project-root/
  └── storage/
      └── app/
          └── google-cloud-key.json
```

Tambahkan ke `.gitignore`:
```
storage/app/google-cloud-key.json
*.json
!composer.json
!package.json
```

---

## Instalasi Dependencies

### 1. Install via Composer

```bash
composer require guzzlehttp/guzzle
composer require google/auth
```

### 2. Verifikasi Instalasi

Cek `composer.json`:
```json
{
  "require": {
    "guzzlehttp/guzzle": "^7.0",
    "google/auth": "^1.0"
  }
}
```

Run:
```bash
composer install
```

---

## Struktur Kode

### Directory Structure

```
app/
├── controllers/
│   └── AiController.php          # Endpoint handlers
├── services/
│   └── GeminiService.php         # Vertex AI service
└── models/
    └── Transaction.php            # Data model

storage/
└── app/
    └── google-cloud-key.json      # Service account credentials
```

---

## Implementasi Service Class

### File: `app/services/GeminiService.php`

Service class ini adalah core dari implementasi Vertex AI. Berikut breakdown fungsi utamanya:

#### 1. Constructor & Configuration

```php
<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;

class GeminiService
{
    private string $model;
    private string $authMode;
    private string $projectId;
    private string $location;
    private ?string $apiKey;
    private ?string $accessToken = null;

    public function __construct()
    {
        // Auth mode: 'vertex' or 'apikey'
        $this->authMode = _env('GEMINI_AUTH_MODE', 'vertex');
        $this->model = _env('VERTEX_AI_MODEL', 'gemini-2.0-flash');
        
        // Vertex AI settings
        $this->projectId = _env('VERTEX_AI_PROJECT_ID', '');
        $this->location = _env('VERTEX_AI_LOCATION', 'us-central1');
        
        // API Key fallback
        $this->apiKey = _env('GEMINI_API_KEY');
    }
}
```

**Penjelasan:**
- `authMode`: Menentukan metode autentikasi (vertex/apikey)
- `model`: Model Gemini yang digunakan (default: gemini-2.0-flash)
- `projectId`: Project ID dari Google Cloud
- `location`: Region untuk Vertex AI endpoint
- `accessToken`: Cached OAuth2 token
