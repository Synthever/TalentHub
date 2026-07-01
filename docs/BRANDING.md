# Branding Guidelines
# TalentHub — University Talent Hub

> **Versi:** 1.0  
> **Tanggal:** 1 Juli 2026  

---

## 1. Brand Identity

### 1.1 Nama Produk
**TalentHub**

### 1.2 Tagline
> *"Discover. Develop. Connect."*

### 1.3 Deskripsi Singkat
Platform ekosistem talenta mahasiswa berbasis gamification untuk perguruan tinggi.

### 1.4 Brand Personality
- **Profesional** — Kredibel dan terpercaya untuk lingkungan akademik
- **Minimalis** — Bersih, terstruktur, tanpa noise visual
- **Elegan** — Premium feel tanpa berlebihan
- **Approachable** — Mudah digunakan oleh mahasiswa dan admin

---

## 2. Logo

### 2.1 Konsep Logo
Logo TalentHub menggabungkan elemen:
- **"T" dan "H"** sebagai monogram dari TalentHub
- Bentuk geometris sederhana yang merepresentasikan koneksi dan jaringan talenta
- Gaya minimalis tanpa ornamen berlebihan

### 2.2 Penggunaan Logo
| Konteks | Format |
|---------|--------|
| Header navigasi | Logo horizontal (icon + text) |
| Favicon | Icon saja (monogram TH) |
| Login page | Logo vertikal (icon di atas, text di bawah) |
| Footer | Logo horizontal, versi muted/subtle |

### 2.3 Clear Space
- Minimum clear space di sekeliling logo: setengah dari tinggi icon logo
- Logo tidak boleh ditimpa elemen lain

---

## 3. Color Palette

### 3.1 Filosofi Warna
Palet warna TalentHub menggunakan pendekatan **Minimalist & Elegant** dengan neutral tones sebagai fondasi, diperkaya aksen warna yang sophisticated namun tidak mencolok.

### 3.2 Primary Colors

| Nama | Hex | HSL | Penggunaan |
|------|-----|-----|------------|
| **Slate 900** | `#0f172a` | `222° 47% 11%` | Text utama, heading |
| **Slate 700** | `#334155` | `215° 25% 27%` | Text sekunder |
| **Slate 50** | `#f8fafc` | `210° 40% 98%` | Background utama |
| **White** | `#ffffff` | `0° 0% 100%` | Card background, surface |

### 3.3 Accent Colors

| Nama | Hex | HSL | Penggunaan |
|------|-----|-----|------------|
| **Indigo 600** | `#4f46e5` | `239° 75% 58%` | Primary action, CTA, link |
| **Indigo 700** | `#4338ca` | `243° 55% 50%` | Primary hover state |
| **Indigo 50** | `#eef2ff` | `226° 100% 97%` | Primary light background |
| **Indigo 100** | `#e0e7ff` | `226° 100% 94%` | Selected/active state background |

### 3.4 Semantic Colors

| Nama | Hex | Penggunaan |
|------|-----|------------|
| **Emerald 600** | `#059669` | Success, approved, verified |
| **Emerald 50** | `#ecfdf5` | Success background |
| **Amber 500** | `#f59e0b` | Warning, pending |
| **Amber 50** | `#fffbeb` | Warning background |
| **Rose 600** | `#e11d48` | Error, rejected, danger |
| **Rose 50** | `#fff1f2` | Error background |
| **Sky 600** | `#0284c7` | Info, notification |
| **Sky 50** | `#f0f9ff` | Info background |

### 3.5 Gamification Colors

| Nama | Hex | Penggunaan |
|------|-----|------------|
| **Amber 400** | `#fbbf24` | Gold — Rank 1 / Top tier |
| **Slate 400** | `#94a3b8` | Silver — Rank 2 |
| **Orange 600** | `#ea580c` | Bronze — Rank 3 |
| **Violet 600** | `#7c3aed` | Point badge, XP indicator |

### 3.6 Gradient

```css
/* Primary gradient - untuk hero section, header accent */
background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);

/* Subtle gradient - untuk card highlight */
background: linear-gradient(135deg, #eef2ff 0%, #f5f3ff 100%);
```

---

## 4. Typography

### 4.1 Font Family

| Tipe | Font | Fallback | Penggunaan |
|------|------|----------|------------|
| **Heading** | `Inter` | `system-ui, sans-serif` | H1-H6, judul, navigasi |
| **Body** | `Inter` | `system-ui, sans-serif` | Paragraf, label, deskripsi |
| **Mono** | `JetBrains Mono` | `monospace` | Kode, data teknis, badge poin |

### 4.2 Font Scale

| Level | Size | Weight | Line Height | Penggunaan |
|-------|------|--------|-------------|------------|
| **Display** | 36px / 2.25rem | 700 (Bold) | 1.2 | Hero heading |
| **H1** | 30px / 1.875rem | 700 (Bold) | 1.2 | Page title |
| **H2** | 24px / 1.5rem | 600 (Semibold) | 1.3 | Section title |
| **H3** | 20px / 1.25rem | 600 (Semibold) | 1.4 | Card title |
| **H4** | 18px / 1.125rem | 500 (Medium) | 1.4 | Subtitle |
| **Body** | 16px / 1rem | 400 (Regular) | 1.6 | Paragraf utama |
| **Body Small** | 14px / 0.875rem | 400 (Regular) | 1.5 | Label, caption |
| **Caption** | 12px / 0.75rem | 500 (Medium) | 1.4 | Badge, tag, meta info |

### 4.3 Google Fonts Import

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
```

---

## 5. Iconography

### 5.1 Icon Library
- **Lucide Icons** (via CDN atau package) — Konsisten, minimalis, stroke-based
- Stroke width: 1.5px (default)
- Size standar: 20px untuk inline, 24px untuk navigasi

### 5.2 Icon Usage

| Konteks | Contoh Icon |
|---------|-------------|
| Dashboard | `layout-dashboard` |
| Mahasiswa | `users` |
| Skill | `sparkles` |
| Sertifikat | `award` |
| Portfolio | `briefcase` |
| Verifikasi | `shield-check` |
| Poin | `star` |
| Leaderboard | `trophy` |
| Reward | `gift` |
| Settings | `settings` |
| Logout | `log-out` |
| Search | `search` |
| AI/Recommendation | `brain` |

---

## 6. Brand Voice & Tone

### 6.1 Prinsip Komunikasi
- **Jelas** — Hindari jargon teknis untuk mahasiswa
- **Ringkas** — Sampaikan informasi secukupnya
- **Mendukung** — Tone positif dan memotivasi

### 6.2 Contoh Copy

| Konteks | Contoh |
|---------|--------|
| Empty state skill | "Belum ada skill. Mulai tambahkan skill pertamamu!" |
| Approved | "Selamat! Pengajuanmu telah diverifikasi. +5 poin" |
| Rejected | "Pengajuan ditolak. Alasan: [alasan]. Silakan ajukan ulang." |
| Leaderboard | "Kamu di peringkat #12. Terus tingkatkan skillmu!" |
| Reward claim | "Reward berhasil diklaim! Sisa poin: 25" |

---

## 7. Brand Assets Checklist

- [ ] Logo SVG (horizontal & vertikal)
- [ ] Favicon (ICO + PNG 32x32, 192x192)
- [ ] OG Image (1200x630) untuk social sharing
- [ ] Color palette Tailwind config
- [ ] Font files (atau Google Fonts link)
- [ ] Icon set (Lucide)
