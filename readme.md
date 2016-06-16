# OAuth service as an extension of the Sentinel 2 package for Laravel 5.2

Allow new users to register and sign in to your application via third party websites like Google, Facebook, Github or LinkedIn. 

## Installation

Make sure you have a running web server on your computer (for example xampp). Open your favorite CLI and move to the folder that will hold the project (typically C:\xampp\htdocs for xampp users). Then type the following commands: 

First clone the repo
```
git clone https://github.com/jeanquark/sentinelOauth.git
```

Install all dependencies
```
composer install
```

Generate application key 
```
php artisan key:generate
```

Create a database that will hold sentinel tables. You can do so with phpmyadmin.
Open the .env.example file, edit it to match your database name, username and password and save it as .env file. Then build tables with command

```
php artisan migrate
```

Now fill the tables
```
php artisan db:seed
```

Nice. You should be good to go. Open your web browser and go to the login page of the application project (if you followed above-mentioned directives with xampp, path is: http://localhost/sentinelOauth/public/login). You can enter provided admin credentials to start managing users from the admin area. To make use of the OAuth service, you need to register your app to the service provider. I explain how to do it as well as all the steps needed to go from Sentinel to Sentinel OAuth in [this](http://www.jmkleger.com/add-oauth-to-sentinel-2) blog post.

## Features

1. Static blog homepage (frontend theme is [bootstrap blog](http://startbootstrap.com/template-overviews/blog-home/))
2. Register page
3. Sign in page
4. Admin area with user management (backend theme is [SB Admin](http://startbootstrap.com/template-overviews/sb-admin/))

## Screenshots
Homepage:
![homepage](https://github.com/jeanquark/sentinelOauth/raw/master/public/homepage.png "Homepage")

Login:
![login](https://github.com/jeanquark/sentinelOauth/raw/master/public/login.png "Login")

Welcome message after signing up with OAuth:
![welcome_sign_up](https://github.com/jeanquark/sentinelOauth/raw/master/public/welcome_sign_up.png "Welcome sign up")

Welcome message after signing in with OAuth:
![welcome_sign_in](https://github.com/jeanquark/sentinelOauth/raw/master/public/welcome_sign_in.png "Welcome sign in")

Admin area:
![alt text](https://github.com/jeanquark/sentinelOauth/raw/master/public/admin.png "Admin")

### License
Please refer to [Sentinel 2 The BSD 3-Clause License](https://github.com/cartalyst/sentinel/blob/2.0/LICENSE).
