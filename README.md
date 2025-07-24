# Inventory Barang - PHP Native

Aplikasi manajemen inventaris menggunakan **PHP Native** dengan sistem **routing manual** dan **Phinx** untuk mengatur **database migration**.

## Fitur

- CRUD Barang
- CRUD Bahan Baku
- Routing dinamis tanpa query string
- Tampilan sederhana menggunakan TailwindCSS (CDN)
- Database migration menggunakan [Phinx](https://book.cakephp.org/phinx/0/en/)

---

## Struktur Folder

```
inventory-app/
├── action/
├── config/
│   └── connection.php
├── db/
│   ├── migrations/
│   └── Seeds/
├── layouts/
│   ├── barang.php
│   └── bahan_baku.php
├── composer.json
├── phinx.php      ← konfigurasi untuk Phinx
```

---

## Persiapan Sebelum Menjalankan

### 1. Clone Repository

```bash
git clone https://github.com/namauser/inventory-app.git
cd inventory-app
```

### 2. Install Dependency Composer

Pastikan sudah terinstall Composer, lalu jalankan:

```bash
composer install
```

### 3. Konfigurasi Database

`copy config/test.connetion.php config/connetion.php`

Sesuaikan dengan database:

```php
return [
    'host'     => 'localhost',
    'name'     => 'nama_database',
    'user'     => 'root',
    'pass'     => '',
    'charset'  => 'utf8mb4',
];
```

### 4. Setup Phinx Migration

#### a. Konfigurasi `phinx.php`

Contoh konfigurasi:

```php
return [
    'paths' => [
        'migrations' => 'migrations',
        'seeds' => 'seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'nama_database',
            'user' => 'root',
            'pass' => '',
            'charset' => 'utf8mb4',
        ],
    ],
];
```

#### b. Jalankan Migration

```bash
vendor/bin/phinx migrate -e development
```

#### c. Jalankan Seed

```bash
vendor/bin/phinx seed:run -v
```

---

## Menjalankan Aplikasi

### Dengan PHP built-in server

```bash
php -S localhost:800
```

Lalu akses di browser: [http://localhost:8000](http://localhost:8000)

---

## Routing

Routing didefinisikan secara manual pada file:

```
config/route.php
```

---

## Styling

Menggunakan **TailwindCSS** CDN di dalam layout:

```html
<script src="https://cdn.tailwindcss.com"></script>
```
