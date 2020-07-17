package to create crud  (create-read-update-delete) 
create models / controllers / migration 
to use 
composer require mcrud/crud 
open config/app.php in provider put         mcrud\crud\Providers\WebsiteServiceProvider::class ,
php artisan create:db  enter dbname / username and password 
php artisan make:crud 
php artisan migrate
