# Fix 403 Forbidden Error pada TalentHub

## Masalah
Error 403 Forbidden muncul pada beberapa halaman:
1. **Admin Students Search**: `/admin/students?search=&skill=&min_poin=&sort=poin`
2. **Mahasiswa Skills Delete**: `/mahasiswa/skills/72` (saat menolak/menghapus skill)

## Penyebab
LiteSpeed Web Server menggunakan ModSecurity/WAF (Web Application Firewall) yang memblokir:
- Query parameters yang dianggap sebagai potensi SQL injection
- HTTP methods seperti DELETE, PATCH yang dianggap berbahaya
- Request body dengan pattern tertentu

## Solusi yang Sudah Diterapkan

### 1. Update `.htaccess` File
File `public/.htaccess` sudah diupdate untuk menonaktifkan ModSecurity **secara global** untuk seluruh aplikasi Laravel (bukan hanya route `/admin`).

**Perubahan yang dilakukan:**

```apache
# LiteSpeed & ModSecurity - Disable for entire Laravel application
<IfModule mod_security.c>
    # Disable ModSecurity completely for this Laravel app
    SecRuleEngine Off
</IfModule>

<IfModule LiteSpeed>
    # Allow all HTTP methods (GET, POST, PUT, DELETE, PATCH)
    RewriteRule .* - [E=noabort:1,E=noconntimeout:1]
</IfModule>
```

**Mengapa disable global?**
- Aplikasi Laravel sudah memiliki security layer sendiri (CSRF, middleware, validation)
- ModSecurity sering memblokir legitimate requests (query parameters, DELETE method, JSON payload)
- Semua request Laravel melalui `index.php` yang sudah ter-filter

## Langkah Deploy

### 1. Upload File ke Server
Upload file berikut ke server:
- `public/.htaccess` (sudah diupdate)
- `resources/views/admin/students/index.blade.php` (tidak ada perubahan signifikan)

### 2. Clear Cache di Server
Jalankan command berikut di server:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 3. Restart LiteSpeed (jika memungkinkan)
Jika Anda memiliki akses, restart LiteSpeed web server untuk memastikan rules baru diterapkan.

## Solusi Alternatif (Jika Masalah Masih Ada)

### Opsi A: Whitelist di Control Panel
Jika menggunakan cPanel atau hosting panel lainnya:

1. Login ke cPanel
2. Cari **ModSecurity** atau **WAF** settings
3. Tambahkan whitelist rule untuk domain Anda:
   ```
   SecRule REQUEST_URI "@beginsWith /admin" "id:1000,phase:1,pass,nolog,ctl:ruleEngine=Off"
   ```

### Opsi B: Disable ModSecurity di cPanel
1. Login ke cPanel
2. Buka **ModSecurity**
3. Pilih domain: `talenthub.rkhyg.my.id`
4. **Disable** ModSecurity untuk domain ini

### Opsi C: Kontak Hosting Provider
Jika solusi di atas tidak bekerja, hubungi hosting provider dan minta mereka untuk:
- Whitelist path `/admin/students` dari ModSecurity rules
- Atau disable ModSecurity rule ID yang memblokir request ini
- Berikan informasi: Request ke `/admin/students?search=test` mendapat 403 Forbidden

### Opsi D: Update via .htaccess (Lebih Spesifik)
Jika memungkinkan, tambahkan rule ini di file `.htaccess` di **root directory** (bukan di public):

```apache
<IfModule mod_security.c>
    <LocationMatch "^/admin">
        SecRuleEngine Off
    </LocationMatch>
</IfModule>
```

### Opsi E: Disable Specific ModSecurity Rules
Jika Anda tahu rule ID mana yang memblokir (bisa dicek di error log), tambahkan di `.htaccess`:

```apache
<IfModule mod_security.c>
    # Disable specific rules that block query parameters
    SecRuleRemoveById 950001
    SecRuleRemoveById 950901
    SecRuleRemoveById 973300
    SecRuleRemoveById 973301
    SecRuleRemoveById 981173
    SecRuleRemoveById 981243
</IfModule>
```

## Testing
Setelah melakukan perubahan, test dengan:
1. Akses: `https://talenthub.rkhyg.my.id/admin/students`
2. Gunakan form search dengan keyword apapun
3. Jika masih 403, coba solusi alternatif di atas

## Catatan Penting
- Perubahan `.htaccess` kadang memerlukan waktu beberapa menit untuk diterapkan
- Beberapa hosting shared mungkin tidak mengizinkan override ModSecurity via `.htaccess`
- Jika semua solusi gagal, kemungkinan besar perlu bantuan dari hosting provider untuk whitelist secara manual
