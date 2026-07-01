# TOPRANK LOGIC AI DEVELOPMENT #3: STUDY CASE

## Membangun Ekosistem Talenta Mahasiswa Berbasis Gamification

## Latar Belakang

Perguruan tinggi memiliki ribuan mahasiswa dengan beragam kompetensi, minat, pengalaman, prestasi, serta aktivitas akademik maupun non-akademik. Namun, informasi tersebut sering kali tersebar di berbagai platform atau bahkan tidak terdokumentasi dengan baik.

Akibatnya, perguruan tinggi mengalami berbagai tantangan, antara lain:

1. Perguruan Tinggi sulit mengidentifikasi mahasiswa yang memiliki kompetensi tertentu.
2. Perguruan Tinggi sulit menemukan mahasiswa yang sesuai ketika terdapat kebutuhan dari industri.
3. Perguruan Tinggi seringkali belum memiliki basis data talenta mahasiswa yang terintegrasi.
4. Baik mahasiswa maupun perguruan tinggi sulit melakukan link and match antara keahlian mahasiswa satu dengan mahasiswa lainnya untuk berkolaborasi.
5. Unit kegiatan mahasiswa, dosen, maupun organisasi kampus kesulitan mencari mahasiswa dengan keahlian spesifik, seperti programmer, UI/UX designer, fotografer, videografer, MC, content creator, translator, tutor, hingga event organizer.
6. Potensi mahasiswa di luar bidang akademik sering kali tidak terdokumentasi sehingga kurang mendapatkan kesempatan untuk berkembang.
7. Belum adanya mekanisme reward untuk mahasiswa yang lebih aktif dalam kegiatan-kegiatan diluar perkuliahan.

Di sisi lain, mahasiswa juga belum memiliki wadah yang mampu menunjukkan portofolio, pencapaian, pengalaman, maupun kontribusinya secara berkelanjutan. Akibatnya, banyak potensi yang belum terlihat dan belum termanfaatkan secara optimal oleh perguruan tinggi maupun mitra industri.

## Challenge

Sebagai software engineer, Anda diminta merancang dan mengembangkan Minimum Viable Product (MVP) platform digital yang mampu membantu perguruan tinggi membangun **University Talent Hub**, yaitu sebuah ekosistem untuk memetakan, mengembangkan, serta mempertemukan talenta mahasiswa dengan berbagai peluang.

Platform yang dikembangkan tidak hanya berfungsi sebagai media pencarian talenta, tetapi juga mampu meningkatkan keterlibatan mahasiswa melalui pendekatan yang menarik, interaktif, dan berkelanjutan.

## Kebutuhan Fitur

### Role Administrator

Administrator bertanggung jawab untuk:

1. Login ke aplikasi.
2. Melihat dashboard statistik (jumlah mahasiswa, jumlah skill, project mahasiswa, dll).
3. Melihat seluruh data mahasiswa.
4. Mencari mahasiswa berdasarkan kompetensi.
5. Memverifikasi pengajuan skill.
6. Memverifikasi sertifikat.
7. Memverifikasi portfolio.
8. Menyetujui atau menolak pengajuan mahasiswa.
9. Memberikan poin terhadap pengajuan yang disetujui.
10. Mengelola daftar reward (misalnya 10 poin bisa ditukar dengan voucher belanja di kantin perguruan tinggi).
11. Melihat leaderboard mahasiswa.
12. Posting opportunity untuk mahasiswa.

### Role Mahasiswa

Mahasiswa bertanggung jawab membangun profil profesionalnya.

1. Login ke aplikasi.
2. Melengkapi profil.
3. Menambahkan skill.
4. Mengunggah sertifikat.
5. Mengunggah portfolio.
6. Mengajukan data untuk diverifikasi.
7. Melihat status pengajuan.
8. Melihat leaderboard.
9. Melihat reward.
10. Mendapatkan rekomendasi berbasis AI.

### Alur Bisnis Utama

```
Mahasiswa
    │
    ▼
Mengisi Profil
    │
    ▼
Menambah Skill / Sertifikat / Portfolio
    │
    ▼
Submit untuk Verifikasi
    │
    ▼
Administrator Melakukan Review
    │
┌───┴───┐
│       │
Reject  Approve
│       │
▼       ▼
Tidak   Memberikan Point
            │
            ▼
        Leaderboard Terupdate
            │
            ▼
        Bisa memilih reward sesuai poin yang dimiliki
```

Peserta bebas mengembangkan alur di atas selama tetap mempertahankan proses verifikasi sebelum poin diberikan.

## Contoh Aturan Poin

Point hanya diberikan setelah proses verifikasi.

| Aktivitas | Contoh Point |
|---|---|
| Sertifikat Lokal | 1 |
| Sertifikat Regional | 3 |
| Sertifikat Nasional | 5 |
| Sertifikat Internasional | 10 |
| Portfolio Personal | 2 |
| Portfolio Freelance | 5 |
| Portfolio Industri | 8 |
| Juara Kompetisi | 10 |

## Aspek Penilaian

Berikut adalah ketentuan point penilaian:

### Role Administrator (50 point)

| Requirement | Point |
|---|---|
| Authentication Admin (Login & Logout) | 10 |
| Dashboard (jumlah mahasiswa, jumlah skill, project mahasiswa, dll) | 10 |
| Data Mahasiswa - Search berdasarkan skill dan poin | 10 |
| Verification Skill / Portfolio (Approve/Reject pengajuan mahasiswa) | 10 |
| Reward Management (posting reward dan poin yang dibutuhkan untuk claim) | 10 |

### Role Mahasiswa (60 point)

| Requirement | Point |
|---|---|
| Authentication (Login & Logout) | 10 |
| Talent Profile | 10 |
| Skill Management (pengajuan verifikasi skill dan bukti) | 10 |
| Portfolio Management (pengajuan verifikasi portofolio dan bukti) | 10 |
| Leaderboard | 10 |
| Reward Catalog (claim reward dari point yang dimiliki) | 10 |

### Teknikal (40 point)

| Requirement | Point |
|---|---|
| Responsive Layout | 10 |
| Dockerized - aplikasi yang dibuat peserta bisa dijalankan menggunakan Docker | 10 |
| Deploy Online | 10 |
| AI Recommendation (bebas silahkan berkreasi terkait penerapan AI) | 10 |

Setiap requirement akan dinilai menggunakan skala berikut:

| Nilai | Kriteria |
|---|---|
| 0 | Belum diimplementasikan / Error / Tidak dapat di demokan |
| 5 | Baru tampilan saja / Sebagian berfungsi / Tampilan berantakan |
| 10 | Berfungsi dengan baik sesuai requirement. |

## Ketentuan

1. Solusi harus dikembangkan selama waktu hackathon berlangsung.
2. Peserta diperbolehkan menggunakan AI Coding Assistant seperti ChatGPT, Claude Code, Codex, Anti Grafity, Gemini, GitHub Copilot, Cursor, Windsurf, maupun tools AI lainnya.
3. Peserta diperbolehkan menggunakan bahasa pemrograman, framework, library, maupun layanan pihak ketiga.
4. Peserta tidak diperbolehkan menggunakan aplikasi yang sebelumnya telah dikembangkan dan hanya melakukan modifikasi kecil.
5. Source code yang digunakan harus merupakan hasil pengembangan selama hackathon, kecuali library, framework, starter template, atau boilerplate yang bersifat umum.
6. Juri berhak melakukan klarifikasi terhadap implementasi maupun source code apabila diperlukan.

## Deliverables

Setiap peserta wajib menyerahkan hal berikut sebelum waktu habis:

- Dokumen Checklist
- Screenshot hasil karya

## Teknis Penjurian

Juri akan melakukan penjurian langsung di meja peserta untuk verifikasi checklist mandiri yang telah dilakukan peserta dan menguji langsung produk yang telah dikembangkan.

Apabila terdapat 2 peserta atau lebih dengan total score point yang sama maka juri akan melakukan penilaian dari aspek lain seperti fitur tambahan lain yang dikembangkan, kerapian struktur kode program atau kemudahan penggunaan.
