1. Клонирование репозитория 
git clone https://github.com/Nijief/IceBooking.git
cd IceBooking

2. Установка PHP-зависимостей через Composer 
composer install

3. Установка Node.js зависимостей
npm install

4. Создание файла окружения
copy .env.example .env

5. Генерация ключа приложения
php artisan key:generate

6. Настройка файла .env 
# Основные настройки приложения
APP_NAME=IceBooking
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Настройки базы данных
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ice_rink
DB_USERNAME=root
DB_PASSWORD=

# Настройки ЮKassa (тестовые)
YOOKASSA_SHOP_ID=1224152
YOOKASSA_SECRET_KEY=test_TQmJq6_24Ty0Z46F7Y6kejxPCZ7VnhHrJ8l8i0VO508
YOOKASSA_RETURN_URL=http://localhost/payment/success

7.  Запуск миграций
php artisan migrate

8. Наполнение тестовыми данными
php artisan db:seed

9.  Установка Moonshine
composer require moonshine/moonshine

10. Публикация ресурсов Moonshine
php artisan vendor:publish --provider="MoonShine\Providers\MoonShineServiceProvider"
php artisan moonshine:install

11. Создание администратора
php artisan moonshine:user --username=admin@example.com --name=Admin --password=password123

12. Запуск проекта
npm run dev
php artisan serve