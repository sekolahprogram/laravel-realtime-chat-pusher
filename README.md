# Laravel Realtime Chat Pusher
Hai semuanya 👏, Semoga dalam keadaan sehat dan masih samangat kodingnya.
Open source kali ini saya membuat realtime chat pusher yang sangat sederhana proses pembuatannya. Maka jangan ragu untuk menggunakannya.

## Installasi
Cara install cukup mudah, jalankan perintah composer dibawah ini.
```
composer create-project  --prefer-dist febrihidayan/laravel-realtime-chat-pusher
```

Kemudian konfirgurasi file `.env`

untuk database
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

untuk pusher

```
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=ap1
```

Jangan lupa lakukan printah artisan berikut

- `php artisan migrate`

Kemudian lakukan penginstalan packages

- `npm install` atau `yarn`

## Pemakaian

**Developer**
- `php artisan serve`
- `npm run watch` or `yarn watch`

**Produksi**
- `php artisan serve`
- `npm run prod` or `yarn prod`

## Owner
- [Febri Hidayan](https://github.com/febrihidayan)

## Donasi
Berikan saya donasi untuk terus memberikan aplikasi open source yang bermanfaat.
- [Paypal](https://paypal.me/febrihidayan)
- [Dana](https://link.dana.id/qr/2d6by546)