# Розгортання проєкту

> Перш ніж почати, переконайтесь, що на вашій локальній машині встановлено:  
> PHP 8.0  
> composer
> 
> Node.js з v16 до v22  
> npm з v8.19.4 до v10.9.3

## 1. Клонування репозиторію
```bash
git clone <REPO_URL>
cd <STORAGE_FOLDER_NAME>
```
## 2. Підготовка середовища
Копіюємо зразок env-файлу
```bash
cp .env.example .env
```

Встановлюємо PHP-залежності
```bash
composer install
```

Генеруємо ключ додатку
```bash
php artisan key:generate
```

## 3. Налаштування бази даних
Варіант A — SQLite (швидко та просто, але без підтримки emoji)

у файлі .env
```bash
DB_CONNECTION=sqlite
DB_DATABASE=
#DB_HOST=
#DB_PORT=
#DB_USERNAME=
#DB_PASSWORD=
```
Варіант B — MySQL (підтримує emoji)

У файлі .env прописуємо:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<db_name>
DB_USERNAME=<db_user>
DB_PASSWORD=<db_password>
```

Вказуємо не root користувача MySQL.
Якщо такого нема, то створюємо такого (потрібно знати пароль root користувача до БД).
Виконуємо у терміналі
```bash
mysql -u root -p
```
вводимо пароль. 
```sql
CREATE USER '<db_user>'@'localhost' IDENTIFIED BY '<db_password>';
CREATE DATABASE <db_name>;
GRANT ALL PRIVILEGES ON <db_name>.* TO '<db_user>'@'localhost';
FLUSH PRIVILEGES;
```
Якщо створювали нового користувача, то йому буде доступна тільки його таблиця. Це безпечно.
## 4. Міграції та залежності фронтенду
Запускаємо міграції
```bash
php artisan migrate
```
Встановлюємо Node-залежності (або оберіть версию ```nvm use ...```), збираємо білд фронтенду
```bash
npm install && npm run build
```

## 5. Запуск локального сервера

Якщо ви не використовуєте Laravel Valet або Herd, можна використати вбудований сервер Laravel:
```bash
php artisan serve
```

Проєкт буде доступний за адресою:
http://localhost:8000
## 6. Документація API
Якщо темна версія Swagger не подобається, то встановіть змінну ```L5_SWAGGER_UI_DARK_MODE``` у файлі ```.env``` на false

Інтерактивна документація Swagger доступна за посиланням:
http://127.0.0.1:8000/api/documentation#/
## 7. Зворотний зв’язок

Буду радий отримати ваш фідбек будь-яким зручним способом:

через поле '''Contact the developer''' у Swagger-документації
 
або іншим чином який Вам відомо.
