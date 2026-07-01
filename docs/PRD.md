# Product Requirements Document (PRD)
# TalentHub — University Talent Hub

> **Versi:** 1.0  
> **Tanggal:** 1 Juli 2026  
> **Status:** Draft  

---

## 1. Ringkasan Produk

**TalentHub** adalah platform digital berbasis web yang dirancang untuk membantu perguruan tinggi membangun ekosistem talenta mahasiswa. Platform ini memetakan, mengembangkan, dan mempertemukan talenta mahasiswa dengan berbagai peluang melalui pendekatan **gamification** (sistem poin, leaderboard, dan reward).

Platform dilengkapi fitur **AI Recommendation** berbasis Vertex AI untuk memberikan rekomendasi cerdas terkait skill matching, development path, dan kolaborasi antar mahasiswa.

---

## 2. Masalah yang Diselesaikan

| # | Masalah | Solusi TalentHub |
|---|---------|-----------------|
| 1 | Perguruan tinggi sulit mengidentifikasi mahasiswa dengan kompetensi tertentu | Pencarian mahasiswa berdasarkan skill dan filter kompetensi |
| 2 | Tidak ada basis data talenta terintegrasi | Profil talenta terpusat dengan skill, sertifikat, dan portfolio |
| 3 | Sulit melakukan link & match antar mahasiswa | AI-powered kolaborasi recommendation |
| 4 | Potensi non-akademik tidak terdokumentasi | Portfolio management dengan bukti dan verifikasi |
| 5 | Tidak ada mekanisme reward untuk mahasiswa aktif | Sistem gamification: poin, leaderboard, reward catalog |
| 6 | Mahasiswa tidak punya wadah portofolio berkelanjutan | Talent profile sebagai digital resume |

---

## 3. Target Pengguna

### 3.1 Administrator (Admin Perguruan Tinggi)
- Staff biro kemahasiswaan, dosen pembina, atau unit karir
- Bertanggung jawab memverifikasi data dan mengelola ekosistem talenta

### 3.2 Mahasiswa
- Seluruh mahasiswa aktif perguruan tinggi
- Membangun profil profesional, mengajukan skill/sertifikat/portfolio

---

## 4. Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Backend Framework | Laravel 12 (PHP 8.4) |
| Frontend | Blade + Tailwind CSS v4 |
| Build Tool | Vite 8 |
| Database | MySQL / SQLite |
| AI/ML | Google Vertex AI (Gemini) |
| Testing | Pest v4 |
| Containerization | Docker |
| Deployment | Cloud (to be determined) |

---

## 5. Fitur & Requirements

### 5.1 Role Administrator (50 Poin)

#### 5.1.1 Authentication Admin (10 poin)
- Login dan Logout
- Guard terpisah atau role-based access control
- Session management

#### 5.1.2 Dashboard (10 poin)
- Statistik total mahasiswa terdaftar
- Total skill yang teregistrasi
- Total project/portfolio mahasiswa
- Jumlah pengajuan pending verifikasi
- Grafik/chart ringkasan data

#### 5.1.3 Data Mahasiswa — Search (10 poin)
- Daftar seluruh mahasiswa
- Pencarian berdasarkan skill
- Filter berdasarkan poin
- Detail profil mahasiswa

#### 5.1.4 Verification Skill/Portfolio (10 poin)
- Daftar pengajuan masuk (pending)
- Detail pengajuan dengan bukti (file/link)
- Aksi Approve dengan pemberian poin
- Aksi Reject dengan alasan penolakan
- Riwayat verifikasi

#### 5.1.5 Reward Management (10 poin)
- CRUD daftar reward
- Set poin yang dibutuhkan per reward
- Stok/kuota reward
- Melihat riwayat klaim reward mahasiswa
- Posting opportunity untuk mahasiswa

---

### 5.2 Role Mahasiswa (60 Poin)

#### 5.2.1 Authentication Mahasiswa (10 poin)
- Registrasi dan Login
- Logout
- Session management

#### 5.2.2 Talent Profile (10 poin)
- Lengkapi profil: nama, foto, jurusan, angkatan, bio
- Informasi kontak dan media sosial
- Ringkasan skill dan pencapaian
- Profil sebagai digital talent card

#### 5.2.3 Skill Management (10 poin)
- Tambah skill baru
- Unggah bukti pendukung (sertifikat, link)
- Submit untuk verifikasi
- Lihat status pengajuan (pending/approved/rejected)

#### 5.2.4 Portfolio Management (10 poin)
- Tambah portfolio/project
- Deskripsi, gambar, link demo
- Kategorisasi (personal/freelance/industri)
- Submit untuk verifikasi
- Lihat status pengajuan

#### 5.2.5 Leaderboard (10 poin)
- Ranking mahasiswa berdasarkan total poin
- Filter berdasarkan jurusan/angkatan
- Posisi sendiri di leaderboard

#### 5.2.6 Reward Catalog (10 poin)
- Lihat daftar reward yang tersedia
- Informasi poin yang dibutuhkan
- Klaim reward dari poin yang dimiliki
- Riwayat klaim

---

### 5.3 Teknikal (40 Poin)

#### 5.3.1 Responsive Layout (10 poin)
- Mobile-first responsive design
- Breakpoint: mobile (< 768px), tablet (768-1024px), desktop (> 1024px)
- Navigasi yang adaptif

#### 5.3.2 Dockerized (10 poin)
- Dockerfile untuk aplikasi
- docker-compose.yml untuk full stack
- Dokumentasi menjalankan via Docker

#### 5.3.3 Deploy Online (10 poin)
- Aplikasi dapat diakses via URL publik
- Environment production yang stabil

#### 5.3.4 AI Recommendation (10 poin)
- **Skill Matching**: Rekomendasi mahasiswa berdasarkan kecocokan skill untuk kebutuhan admin/industri
- **Skill Development Path**: Saran pengembangan skill berdasarkan profil mahasiswa
- **Kolaborasi Recommendation**: Rekomendasi partner kolaborasi berdasarkan skill yang saling melengkapi
- Integrasi dengan Google Vertex AI (Gemini model)

---

## 6. Sistem Poin & Gamification

### 6.1 Aturan Poin

Poin **hanya diberikan setelah verifikasi** oleh administrator.

| Aktivitas | Poin |
|-----------|------|
| Sertifikat Lokal | 1 |
| Sertifikat Regional | 3 |
| Sertifikat Nasional | 5 |
| Sertifikat Internasional | 10 |
| Portfolio Personal | 2 |
| Portfolio Freelance | 5 |
| Portfolio Industri | 8 |
| Juara Kompetisi | 10 |

### 6.2 Leaderboard
- Ranking real-time berdasarkan total poin
- Update otomatis setelah poin diberikan

### 6.3 Reward
- Admin mengelola katalog reward
- Mahasiswa klaim reward menggunakan poin
- Poin dikurangi setelah klaim berhasil

---

## 7. Alur Bisnis Utama

```
┌─────────────┐
│  Mahasiswa   │
│  Registrasi  │
└──────┬──────┘
       ▼
┌─────────────┐
│  Lengkapi   │
│   Profil    │
└──────┬──────┘
       ▼
┌──────────────────────────┐
│  Tambah Skill/Sertifikat │
│  /Portfolio + Bukti      │
└──────────┬───────────────┘
           ▼
┌─────────────────┐
│  Submit untuk   │
│  Verifikasi     │
└────────┬────────┘
         ▼
┌─────────────────┐
│  Admin Review   │
└───┬─────────┬───┘
    ▼         ▼
┌────────┐ ┌──────────┐
│ Reject │ │ Approve  │
│        │ │ + Poin   │
└────────┘ └────┬─────┘
                ▼
        ┌──────────────┐
        │ Leaderboard  │
        │  Terupdate   │
        └──────┬───────┘
               ▼
        ┌──────────────┐
        │ Klaim Reward │
        └──────────────┘
```

---

## 8. Database Schema (High-Level)

| Tabel | Deskripsi |
|-------|-----------|
| `users` | Data user (admin & mahasiswa), role-based |
| `profiles` | Profil detail mahasiswa (jurusan, angkatan, bio, foto) |
| `skills` | Master data skill |
| `user_skills` | Skill yang dimiliki mahasiswa + status verifikasi |
| `certificates` | Sertifikat mahasiswa + file bukti + level + status verifikasi |
| `portfolios` | Portfolio/project mahasiswa + kategori + status verifikasi |
| `points` | Riwayat poin yang diterima (polymorphic ke source) |
| `rewards` | Katalog reward yang tersedia |
| `reward_claims` | Riwayat klaim reward oleh mahasiswa |
| `opportunities` | Peluang yang diposting admin |

---

## 9. AI Features Detail (Vertex AI)

### 9.1 Skill Matching
- **Input**: Daftar skill yang dicari (dari admin/industri)
- **Output**: Ranked list mahasiswa yang paling cocok
- **Method**: Gemini prompt-based analysis dari data profil mahasiswa

### 9.2 Skill Development Path
- **Input**: Profil skill mahasiswa saat ini
- **Output**: Rekomendasi skill yang sebaiknya dipelajari selanjutnya
- **Method**: Gemini generative AI berdasarkan konteks jurusan dan trend industri

### 9.3 Kolaborasi Recommendation
- **Input**: Profil skill mahasiswa A
- **Output**: Mahasiswa lain dengan skill komplementer untuk kolaborasi
- **Method**: Complementary skill analysis via Gemini

---

## 10. Aspek Penilaian (Scoring Reference)

| Kategori | Requirement | Maks Poin |
|----------|-------------|-----------|
| **Admin (50)** | Authentication | 10 |
| | Dashboard | 10 |
| | Data Mahasiswa - Search | 10 |
| | Verification Skill/Portfolio | 10 |
| | Reward Management | 10 |
| **Mahasiswa (60)** | Authentication | 10 |
| | Talent Profile | 10 |
| | Skill Management | 10 |
| | Portfolio Management | 10 |
| | Leaderboard | 10 |
| | Reward Catalog | 10 |
| **Teknikal (40)** | Responsive Layout | 10 |
| | Dockerized | 10 |
| | Deploy Online | 10 |
| | AI Recommendation | 10 |
| **Total** | | **150** |

### Skala Penilaian

| Nilai | Kriteria |
|-------|----------|
| 0 | Belum diimplementasikan / Error / Tidak dapat didemokan |
| 5 | Baru tampilan saja / Sebagian berfungsi / Tampilan berantakan |
| 10 | Berfungsi dengan baik sesuai requirement |

---

## 11. Deliverables

- [ ] Aplikasi web fungsional (TalentHub)
- [ ] Dokumen Checklist penilaian
- [ ] Screenshot hasil karya
- [ ] Source code di repository
- [ ] Docker setup (Dockerfile + docker-compose.yml)
- [ ] Deployment online (URL publik)

---

## 12. Non-Functional Requirements

| Aspek | Target |
|-------|--------|
| Bahasa UI | Bahasa Indonesia |
| Responsive | Mobile, Tablet, Desktop |
| Performance | Load time < 3 detik |
| Security | CSRF protection, input validation, auth guard |
| Accessibility | Semantic HTML, proper contrast |
