# Web Poliklinik dengan PHP Native


## Prasyarat

Sebelum memulai, pastikan Anda memiliki hal-hal berikut yang terpasang di mesin lokal Anda:

1. **PHP 8.2 atau lebih tinggi**  
2. **Composer** – Dependency Manager untuk PHP
3. **XAMPP** atau WAMP untuk menjalankan server lokal
   
## Langkah-Langkah Instalasi dan Run

### Langkah 1: Clone Repository

Unduh atau clone repository dari GitHub dengan perintah berikut:

```bash
git clone https://github.com/Jesjsssi/BK---Poliklinik.git
```

### Langkah 2: Konfigurasi Server

1. Pastikan XAMPP atau WAMP telah dijalankan.
2. Salin folder project ke direktori htdocs atau www (contoh: C:/xampp/htdocs/poliklinik)


### Langkah 3: Buat Database
1. Buka *phpMyAdmin* atau alat lain untuk mengelola MySQL.
2. Buat database baru bernama poliklinik:
```bash
CREATE DATABASE poliklinik;
```
3. Import file SQL yang tersedia di folder database dari project ke dalam database poliklinik

### Langkah 4: Jalankan Aplikasi
```bash
http://localhost/poliklinik/
```

## Cara Login sebagai Dokter
No Hp : 085711112222
Password: 123

## Cara Login sebagai Admin
URL:  
```bash
http://localhost/poliklinik/src/auth/admin/login.php
```
Nama/username: superadmin

Password: 123

## Cara Login sebagai Pasien
Nama/username: NIK 

Password: alamat pasien yang di daftarkan

