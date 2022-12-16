# Repository Pattern untuk Laravel

Repository pattern adalah sebuah pola desain software yang menyediakan lapisan abstraksi antara akses data dan logika bisnis dari sebuah aplikasi. dengan adanya Repository pattern, antara logika bisnis aplikasi dengan pengolahan data ke database itu terpisah pengerjaannya. Sehingga masing-masing punya tempat untuk pemrosesannya. 

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

Untuk penggunaan di Controller, buatkan sebuah variable protected untuk menyimpan Contract dari repository. 
![image](https://user-images.githubusercontent.com/77718626/208067551-1f624502-ad08-4246-a8b0-eaa00c9d70dc.png)

Instansiasikan pada method constructor
![image](https://user-images.githubusercontent.com/77718626/208069061-7e12b9ae-a90a-4ae5-91d9-27a6dfd6f984.png)

- <b>Penggunaan untuk get seluruh data</b> <br>
![image](https://user-images.githubusercontent.com/77718626/208067604-c4c13f15-841a-4ed1-8308-b210356a9f90.png)

- <b>Penggunaan untuk get detail</b> <br>
![image](https://user-images.githubusercontent.com/77718626/208067733-08a82d1a-cb65-4160-a32b-14b535e2da3d.png)

- <b>Penggunaan untuk get satu data berdasarkan sesuatu selain id</b> <br>
![image](https://user-images.githubusercontent.com/77718626/208068644-2b271c85-0eae-4cd3-b4c2-aa74498cd35a.png)

- <b>Penggunaan untuk get banyak data berdasarkan sesuatu</b> <br>
![image](https://user-images.githubusercontent.com/77718626/208068720-1305fd2b-67a1-46af-8dcd-ad6b5976cd3c.png)


- <b>Penggunaan untuk create data</b> <br>
![image](https://user-images.githubusercontent.com/77718626/208067926-8f8b089d-0048-4f7c-9456-88019c0e081b.png)

- <b>Penggunaan untuk update data</b> <br>
![image](https://user-images.githubusercontent.com/77718626/208068249-747c2113-6853-4cff-b2c3-2a88ec0f4472.png)

- <b>Penggunaan untuk delete data</b> <br>
![image](https://user-images.githubusercontent.com/77718626/208068358-e4e15565-6284-40ec-a0be-665f5a8f4d30.png)
