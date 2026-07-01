# UI Standard
# TalentHub — University Talent Hub

> **Versi:** 1.0  
> **Tanggal:** 1 Juli 2026  

---

## 1. Design Principles

1. **Minimalis** — Setiap elemen punya tujuan. Tidak ada dekorasi yang tidak perlu.
2. **Konsisten** — Komponen yang sama terlihat dan berperilaku sama di seluruh aplikasi.
3. **Hierarki** — Informasi penting terlihat lebih dulu melalui ukuran, warna, dan posisi.
4. **Responsif** — Semua halaman berfungsi optimal di mobile, tablet, dan desktop.
5. **Aksesibel** — Kontras warna memadai, semantic HTML, fokus state jelas.

---

## 2. Layout System

### 2.1 Grid

| Breakpoint | Lebar | Kolom | Padding Kontainer |
|------------|-------|-------|-------------------|
| Mobile | < 640px | 1 kolom | 16px |
| Tablet | 640-1024px | 2 kolom | 24px |
| Desktop | > 1024px | 12 kolom | 32px |

### 2.2 Max Width
- Content area: `max-w-7xl` (1280px)
- Form/content narrow: `max-w-2xl` (672px)
- Card grid: `max-w-6xl` (1152px)

### 2.3 Spacing Scale (Tailwind)

| Token | Value | Penggunaan |
|-------|-------|------------|
| `gap-1` / `p-1` | 4px | Spacing antar badge, micro spacing |
| `gap-2` / `p-2` | 8px | Spacing dalam komponen kecil |
| `gap-3` / `p-3` | 12px | Padding button, input |
| `gap-4` / `p-4` | 16px | Padding card, antar elemen |
| `gap-6` / `p-6` | 24px | Padding section dalam card |
| `gap-8` / `p-8` | 32px | Spacing antar section |
| `gap-12` / `p-12` | 48px | Spacing antar major section |

---

## 3. Component Library

### 3.1 Buttons

#### Primary Button
```html
<button class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
    Label
</button>
```

#### Secondary Button
```html
<button class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
    Label
</button>
```

#### Danger Button
```html
<button class="inline-flex items-center gap-2 rounded-lg bg-rose-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
    Label
</button>
```

#### Ghost Button
```html
<button class="inline-flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
    Label
</button>
```

#### Button Sizes

| Size | Padding | Font Size |
|------|---------|-----------|
| Small | `px-3 py-1.5` | `text-xs` |
| Default | `px-4 py-2.5` | `text-sm` |
| Large | `px-6 py-3` | `text-base` |

---

### 3.2 Cards

#### Basic Card
```html
<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <h3 class="text-lg font-semibold text-slate-900">Judul Card</h3>
    <p class="mt-2 text-sm text-slate-600">Deskripsi card.</p>
</div>
```

#### Stat Card (Dashboard)
```html
<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="flex items-center gap-4">
        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-50">
            <!-- Icon -->
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Total Mahasiswa</p>
            <p class="text-2xl font-bold text-slate-900">1,247</p>
        </div>
    </div>
</div>
```

#### Card dengan Status Badge
```html
<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="flex items-center justify-between">
        <h3 class="font-semibold text-slate-900">Nama Pengajuan</h3>
        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700">
            Pending
        </span>
    </div>
</div>
```

---

### 3.3 Forms

#### Text Input
```html
<div>
    <label class="block text-sm font-medium text-slate-700">Label</label>
    <input type="text" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Placeholder">
</div>
```

#### Select
```html
<div>
    <label class="block text-sm font-medium text-slate-700">Label</label>
    <select class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
        <option>Pilih opsi</option>
    </select>
</div>
```

#### Textarea
```html
<div>
    <label class="block text-sm font-medium text-slate-700">Label</label>
    <textarea rows="4" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm transition-colors focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Placeholder"></textarea>
</div>
```

#### File Upload
```html
<div>
    <label class="block text-sm font-medium text-slate-700">Unggah File</label>
    <div class="mt-1 flex items-center justify-center rounded-lg border-2 border-dashed border-slate-300 px-6 py-8 transition-colors hover:border-indigo-400">
        <div class="text-center">
            <!-- Upload icon -->
            <p class="text-sm text-slate-600">Drag & drop atau <span class="font-medium text-indigo-600">pilih file</span></p>
            <p class="mt-1 text-xs text-slate-400">PNG, JPG, PDF maks 5MB</p>
        </div>
    </div>
</div>
```

#### Error State
```html
<input type="text" class="block w-full rounded-lg border border-rose-300 px-3 py-2.5 text-sm text-slate-900 focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500">
<p class="mt-1 text-xs text-rose-600">Pesan error di sini.</p>
```

---

### 3.4 Badges & Status

```html
<!-- Approved / Success -->
<span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
    Disetujui
</span>

<!-- Pending / Warning -->
<span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700">
    Menunggu
</span>

<!-- Rejected / Error -->
<span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-0.5 text-xs font-medium text-rose-600">
    Ditolak
</span>

<!-- Info -->
<span class="inline-flex items-center rounded-full bg-sky-50 px-2.5 py-0.5 text-xs font-medium text-sky-700">
    Info
</span>

<!-- Point Badge -->
<span class="inline-flex items-center gap-1 rounded-full bg-violet-50 px-2.5 py-0.5 text-xs font-medium text-violet-700">
    ★ 25 Poin
</span>

<!-- Skill Tag -->
<span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">
    PHP
</span>
```

---

### 3.5 Table

```html
<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                    Kolom
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            <tr class="transition-colors hover:bg-slate-50">
                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-900">
                    Data
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

---

### 3.6 Navigation

#### Sidebar (Desktop)
```
┌──────────────────────────────────────────┐
│ [Logo] TalentHub        [User Avatar ▾] │
├────────────┬─────────────────────────────┤
│            │                             │
│  Dashboard │    Main Content Area        │
│  Mahasiswa │                             │
│  Verifikasi│                             │
│  Reward    │                             │
│  Leaderb.  │                             │
│            │                             │
│  ────────  │                             │
│  Settings  │                             │
│  Logout    │                             │
│            │                             │
├────────────┴─────────────────────────────┤
```

- Sidebar width: `w-64` (256px)
- Background: `bg-white` dengan `border-r border-slate-200`
- Active item: `bg-indigo-50 text-indigo-700 font-medium`
- Inactive item: `text-slate-600 hover:bg-slate-50`

#### Bottom Navigation (Mobile)
```
┌──────────────────────────────────────────┐
│                                          │
│           Main Content Area              │
│                                          │
├──────────────────────────────────────────┤
│  🏠    👤    📊    🎁    ☰              │
│ Home  Profil Board Reward More          │
└──────────────────────────────────────────┘
```

---

### 3.7 Modal & Dialog

```html
<!-- Backdrop -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm">
    <!-- Modal -->
    <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl">
        <h2 class="text-lg font-semibold text-slate-900">Judul Modal</h2>
        <p class="mt-2 text-sm text-slate-600">Konten modal.</p>
        <div class="mt-6 flex justify-end gap-3">
            <button class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">
                Batal
            </button>
            <button class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white">
                Konfirmasi
            </button>
        </div>
    </div>
</div>
```

---

### 3.8 Alert / Notification

```html
<!-- Success -->
<div class="flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 p-4">
    <!-- Check icon -->
    <p class="text-sm font-medium text-emerald-800">Pengajuan berhasil disetujui!</p>
</div>

<!-- Error -->
<div class="flex items-center gap-3 rounded-lg border border-rose-200 bg-rose-50 p-4">
    <!-- X icon -->
    <p class="text-sm font-medium text-rose-800">Gagal mengunggah file. Coba lagi.</p>
</div>

<!-- Warning -->
<div class="flex items-center gap-3 rounded-lg border border-amber-200 bg-amber-50 p-4">
    <!-- Warning icon -->
    <p class="text-sm font-medium text-amber-800">Poin tidak mencukupi untuk klaim reward ini.</p>
</div>
```

---

### 3.9 Leaderboard Item

```html
<div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <!-- Rank -->
    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-400 text-sm font-bold text-white">
        1
    </div>
    <!-- Avatar -->
    <img class="h-10 w-10 rounded-full object-cover" src="..." alt="">
    <!-- Info -->
    <div class="flex-1">
        <p class="font-semibold text-slate-900">Nama Mahasiswa</p>
        <p class="text-xs text-slate-500">Teknik Informatika • 2023</p>
    </div>
    <!-- Points -->
    <div class="text-right">
        <p class="text-lg font-bold text-indigo-600">85</p>
        <p class="text-xs text-slate-400">poin</p>
    </div>
</div>
```

Rank badge colors:
- **#1**: `bg-amber-400` (Gold)
- **#2**: `bg-slate-400` (Silver)  
- **#3**: `bg-orange-500` (Bronze)
- **#4+**: `bg-slate-200 text-slate-600`

---

### 3.10 Reward Card

```html
<div class="group rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
    <div class="flex items-start justify-between">
        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-violet-50">
            <!-- Gift icon -->
        </div>
        <span class="inline-flex items-center gap-1 rounded-full bg-violet-50 px-2.5 py-0.5 text-xs font-medium text-violet-700">
            ★ 10 Poin
        </span>
    </div>
    <h3 class="mt-4 font-semibold text-slate-900">Nama Reward</h3>
    <p class="mt-1 text-sm text-slate-500">Deskripsi reward singkat.</p>
    <button class="mt-4 w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
        Klaim Reward
    </button>
</div>
```

---

## 4. Page Layout Templates

### 4.1 Dashboard Layout (Admin)

```
┌─────────────────────────────────────────────────┐
│ Header: Breadcrumb + Page Title + Action Button │
├─────────────────────────────────────────────────┤
│                                                 │
│  ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐          │
│  │ Stat │ │ Stat │ │ Stat │ │ Stat │          │
│  │ Card │ │ Card │ │ Card │ │ Card │          │
│  └──────┘ └──────┘ └──────┘ └──────┘          │
│                                                 │
│  ┌──────────────────┐ ┌──────────────┐         │
│  │                  │ │              │         │
│  │   Chart Area     │ │  Recent      │         │
│  │                  │ │  Activity    │         │
│  │                  │ │              │         │
│  └──────────────────┘ └──────────────┘         │
│                                                 │
│  ┌──────────────────────────────────┐           │
│  │     Data Table / List           │           │
│  │     (Pengajuan Terbaru)         │           │
│  └──────────────────────────────────┘           │
└─────────────────────────────────────────────────┘
```

### 4.2 Talent Profile Layout (Mahasiswa)

```
┌─────────────────────────────────────────────────┐
│ ┌─────────────────────────────────────────────┐ │
│ │  Cover / Gradient Banner                    │ │
│ │                                             │ │
│ │  [Avatar]  Nama Mahasiswa                   │ │
│ │            Jurusan • Angkatan               │ │
│ │            ★ 45 Poin                        │ │
│ └─────────────────────────────────────────────┘ │
│                                                 │
│ ┌──────────┐ ┌──────────┐ ┌──────────┐        │
│ │  Skills  │ │  Sertif  │ │ Portfolio │        │
│ │   Tab    │ │   Tab    │ │   Tab     │        │
│ └──────────┘ └──────────┘ └──────────┘        │
│                                                 │
│ ┌─────────────────────────────────────────────┐ │
│ │  Tab Content                                │ │
│ │  (Skills list / Sertifikat / Portfolio)     │ │
│ └─────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────┘
```

---

## 5. Animation & Transitions

### 5.1 Transition Defaults
```css
/* Semua transisi standar */
transition-property: color, background-color, border-color, box-shadow, opacity, transform;
transition-duration: 150ms;
transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
```

### 5.2 Micro-animations

| Elemen | Animasi | Durasi |
|--------|---------|--------|
| Button hover | Background color shift | 150ms |
| Card hover | Subtle shadow lift (`shadow-sm` → `shadow-md`) | 200ms |
| Modal open | Fade in + scale up dari 95% ke 100% | 200ms |
| Modal close | Fade out + scale down ke 95% | 150ms |
| Toast notification | Slide in dari kanan | 300ms |
| Page transition | Fade in | 200ms |
| Badge appear | Scale from 0 to 1 | 200ms |
| Sidebar nav active | Left border slide in | 150ms |

### 5.3 Loading States
```html
<!-- Skeleton loader -->
<div class="animate-pulse">
    <div class="h-4 w-3/4 rounded bg-slate-200"></div>
    <div class="mt-2 h-4 w-1/2 rounded bg-slate-200"></div>
</div>

<!-- Spinner -->
<svg class="h-5 w-5 animate-spin text-indigo-600" viewBox="0 0 24 24">...</svg>
```

---

## 6. Responsive Breakpoints

| Prefix | Min Width | Target |
|--------|-----------|--------|
| (default) | 0px | Mobile |
| `sm:` | 640px | Mobile landscape |
| `md:` | 768px | Tablet |
| `lg:` | 1024px | Desktop |
| `xl:` | 1280px | Large desktop |

### 6.1 Responsive Rules

- **Mobile (< 768px)**:
  - Sidebar collapse menjadi bottom navigation
  - Card grid: 1 kolom
  - Table: horizontal scroll atau card-based list
  - Font size Display → 24px

- **Tablet (768-1024px)**:
  - Sidebar collapse menjadi hamburger menu
  - Card grid: 2 kolom
  - Stat cards: 2 per baris

- **Desktop (> 1024px)**:
  - Full sidebar visible
  - Card grid: 3-4 kolom
  - Stat cards: 4 per baris
  - Split layout untuk detail view

---

## 7. Accessibility Standards

| Aspek | Standar |
|-------|---------|
| Contrast ratio | Minimum 4.5:1 (text), 3:1 (large text) |
| Focus state | Visible ring (`ring-2 ring-indigo-500 ring-offset-2`) |
| Alt text | Semua image wajib alt text deskriptif |
| ARIA labels | Semua interactive element yang non-text |
| Keyboard nav | Tab order logis, Enter/Space untuk aksi |
| Semantic HTML | `<header>`, `<nav>`, `<main>`, `<section>`, `<aside>` |

---

## 8. Dark Mode (Optional Enhancement)

Mapping warna dark mode jika diimplementasikan:

| Light | Dark |
|-------|------|
| `bg-white` | `bg-slate-900` |
| `bg-slate-50` | `bg-slate-950` |
| `text-slate-900` | `text-slate-100` |
| `text-slate-600` | `text-slate-400` |
| `border-slate-200` | `border-slate-700` |
| `bg-indigo-50` | `bg-indigo-950` |

---

## 9. Z-Index Scale

| Layer | Z-Index | Penggunaan |
|-------|---------|------------|
| Base | `z-0` | Content default |
| Dropdown | `z-10` | Dropdown menu |
| Sticky | `z-20` | Sticky header |
| Sidebar | `z-30` | Sidebar overlay (mobile) |
| Modal backdrop | `z-40` | Modal background |
| Modal | `z-50` | Modal content |
| Toast | `z-[60]` | Notification toast |

---

## 10. Border Radius Scale

| Token | Value | Penggunaan |
|-------|-------|------------|
| `rounded` | 4px | Small elements |
| `rounded-lg` | 8px | Buttons, inputs |
| `rounded-xl` | 12px | Cards |
| `rounded-2xl` | 16px | Modal, large cards |
| `rounded-full` | 9999px | Avatar, badge, pill |
