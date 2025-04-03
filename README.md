<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


Un backend Laravel per la gestione dell'autenticazione JWT, con supporto per utenti e clienti, gestione degli avatar e middleware personalizzati.

---

## 🚀 Funzionalità

- **Autenticazione JWT**: Supporto per login, registrazione e logout con token JWT.
- **Gestione Utenti**: Creazione e gestione di utenti con ruoli specifici.
- **Gestione Clienti**: Creazione e gestione di clienti con avatar personalizzati.
- **Middleware Personalizzati**: Controllo del tipo di utente e prevenzione di accessi multipli.
- **API RESTful**: Endpoint per l'autenticazione, la gestione dei profili e degli avatar.

---

## 🛠️ Tecnologie Utilizzate

- **Framework**: Laravel 10
- **Autenticazione**: JWT (JSON Web Token)
- **Database**: MySQL
- **Middleware**: Personalizzati per il controllo degli accessi
- **Storage**: File system locale per gli avatar

---

## 📦 Installazione

1. Clona il repository:
   ```bash
   git clone https://github.com/tuo-username/nome-repo.git
   ```
2. Installa le dipendenze:
   ```bash
   composer install
   ```
3. Configura il file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nome_database
   DB_USERNAME=root
   DB_PASSWORD=password
   ```
4. Esegui le migrazioni e i seeders:
   ```bash
   php artisan migrate --seed
   ```
5. Avvia il server di sviluppo:
   ```bash
   php artisan serve
   ```

---

## 🖥️ Configurazione

Crea un file `.env` nella root del progetto con le seguenti variabili d'ambiente:
JWT_SECRET=tuo_segreto_jwt
JWT_TTL=60


## 🧑‍💻 Utilizzo

### Autenticazione

- **Login**: `POST /api/auth/login`
- **Registrazione**: `POST /api/auth/register`
- **Logout**: `POST /api/auth/logout`
- **Refresh Token**: `POST /api/auth/refresh`

### Gestione Clienti

- **Login Cliente**: `POST /api/customer/login`
- **Registrazione Cliente**: `POST /api/customer/register`
- **Upload Avatar**: `POST /api/customer/avatar/upload`
- **Elimina Avatar**: `DELETE /api/customer/avatar/delete`

## 🤝 Contributi

Se vuoi contribuire al progetto, segui questi passaggi:

1. Fork del repository.
2. Crea un nuovo branch (`git checkout -b feature/nuova-funzionalità`).
3. Fai commit delle tue modifiche (`git commit -m 'Aggiunta nuova funzionalità'`).
4. Push del branch (`git push origin feature/nuova-funzionalità`).
5. Apri una Pull Request.

---

## 📄 Licenza

Questo progetto è sotto licenza MIT. Vedi il file [LICENSE](LICENSE) per maggiori dettagli.
