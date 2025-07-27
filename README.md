## About This Projects

This project is built on top of AdminLTE, a popular open-source admin dashboard template, integrated with Laravel 10. It provides a robust foundation for building admin panels with features like:

- AdminLTE 3.x dashboard template
- Laravel Breeze authentication
- Light/Dark mode support
- Responsive layout
- Push notification system using OneSignal
- Role-based access control
- Multiple authentication methods

The project structure is optimized so users don't have to worry about assets & folder paths for the admin side. It's perfect for building administrative interfaces with push notification capabilities. Don't forget to give star to this repository ⭐.
## Additional Features

### Push Notifications
This project includes OneSignal integration for push notifications. To configure:

1. Set up your OneSignal account
2. Add these environment variables to `.env`:
```env
ONESIGNAL_APP_ID=your-app-id
ONESIGNAL_REST_API_KEY=your-rest-api-key
```
## Installation & usage
- For Install you have to clone this repo or you can fire this command as well.

```php
git clone https://github.com/akshayparate92/push-dashboard.git
```

- Go into folder

```php
cd push-dashboard
```

- After the installation you have to update the vendor folder you can update the vendor folder using this command.

```php
composer update
```

- After the updation you have to create the ```.env``` file via this command.

```php
cp .env.example .env
```

- Now you have to generate the product key.

```php
php artisan key:generate
```

- Now migrate the tables & seed the database.

```php
php artisan migrate --seed
```

- We are done here. Now you have to just serve your project.

```php
php artisan serve
```

- This is the updated code of admin.

To get the access of admin side there is credentials bellow

- Admin

email: ```testadmin@gmail.com```
password: ```p$ssw#rd```

- User

email: ```testuser@gmail.com```
password: ```p$ssw#rd```

- Vendor

email: ```testvendor@gmail.com```
password: ```p$ssw#rd```

## Contact & Support

Please contact an e-mail to [akshayparate92@gmail.com](mailto:akshayparate92@gmail.com).