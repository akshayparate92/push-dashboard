## Push Notification  Dashboard in laravel-10
<p align="center"><a href="https://github.com/akshayparate92/push-dashboard" target="_blank"><img src="ready-made-admin-lte-10.png" width="800" alt="Laravel-10 AdminLTE"></a></p>

## Light-Dark Mode Using Bootstrap

<p align="center"><a href="https://github.com/akshayparate92/push-dashboard" target="_blank"><img src="light-dark-mode.png" width="800" alt="Bootstrap AdminLTE in LAravel"></a></p>


## About This Projects

This project is made in Laravel version 10. In this project, I used an Admin LTE with a breeze installation. Users do have not to worry about assets & folder paths for the admin side. Created for basic e-commerce project admin.Added the basic modules. Don't forget to give star to this repository ⭐.
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


# Update

- Added the Light/Dark mode in profile section at top nav.

- Added the Category module.

- Added the Subcategory module.

- Added the product module which has basic detail & takes multiple images.

- Added the Role Module.

- Added the permission Module.

- Added the collection Module for PDFs.

- Added the Country, State & City seeder with the relationship

- if you want to use the admin side but you have no idea about components & how here things work. so that you just have to create a file & put your code.

- I added the functionality to compress the image size & convert it into webp format in the ```ProductController```.

# Toast

- Added the toastr which has 4 classes success, info, warning & error. you can use it own it.

```php
<x-admin>
    {{ 'Put your blade code here' }}
</x-admin>
```

- For the page title use a section method Like this.

```php
    @section('title')
        {{'Your Titlte'}}
    @endsection
```

# Alerts

- I added the alerts. You just have to call like this.

```php
->with('success', 'Success message');
->with('danger', 'danger message');
->with('info', 'info message');
->with('dark', 'dark message');
->with('warning', 'warning message');
->with('light', 'light message');
```

## Additional Features

### Push Notifications
This project includes OneSignal integration for push notifications. To configure:

1. Set up your OneSignal account
2. Add these environment variables to `.env`:
```env
ONESIGNAL_APP_ID=your-app-id
ONESIGNAL_REST_API_KEY=your-rest-api-key
```

## Contact & Support

If you discover any issues or need support, please send an e-mail to [akshayparate92@gmail.com](mailto:akshayparate92@gmail.com). All queries will be promptly addressed.

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to Akshay Parate via [akshayparate92@gmail.com](mailto:akshayparate92@gmail.com). All security vulnerabilities will be promptly addressed.

