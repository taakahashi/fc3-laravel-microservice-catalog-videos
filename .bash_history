composer
composer create-project --prefer-dist laravel/laravel here
mv -v /here/* .
composer install
composer require --dev mockery/mockery
php artisan test
php artisan test --stop-on-failure
php artisan make:model Category -m
php artisan migrate
php artisan make:test App\\Repositories\\Eloquent\\CategoryRepositoryEloquent
php artisan make:factory CategoryFactory
php artisan test
clear

