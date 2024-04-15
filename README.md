## App Setup

### Backend

```
cd backend
```

```
composer install 

cp .env.example .env 

php artisan cache:clear 

composer dump-autoload 

php artisan key:generate

php artisan serve
```

Create the DB
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=surat-app
DB_USERNAME=root
DB_PASSWORD=
```
Now migrate your DB
```
php artisan migrate
```
### Frontend
```
cd frontend
```
```
npm install

npm run dev
```
You should be good to go!
