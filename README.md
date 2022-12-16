# Repository Pattern untuk Laravel

Repository pattern adalah sebuah pola desain software yang menyediakan lapisan abstraksi antara akses data dan logika bisnis dari sebuah aplikasi.

## Persyaratan

- Minimal PHP ^8.1

## Instalasi

Cara install via composer
```bash
composer require hakimasrori/repository
```

Publish vendor 
```bash
php artisan vendor:publish --provider="Hakimasrori\Repository\LaravelRepositoryServiceProvider"
```

## Cara Penggunaan
```bash
php artisan make:repository User
```

## Contoh Dalam Kode Program
- <b>Controller</b> <br>
Untuk penggunaan di Controller, buatkan sebuah variabel protected untuk menyimpan Contract dari repository. 
![image](https://user-images.githubusercontent.com/77718626/208060399-9a8c4380-1ef5-490f-8440-92ced8a93968.png)
