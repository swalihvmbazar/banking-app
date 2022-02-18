# Laravel Simple Banking Application


This project is a small banking application developed  using PHP Laravel framework 
(https://laravel.com/). The application will perform the below 
operations:
1. Registration – Creating a new account with email id and 
password
2. Login
3. Inbox/Home – Display account information
4. Cash Deposit – To deposit some amount in the logged in 
account
5. Cash Withdrawal – To withdraw some amount from the logged in 
account
6. Cash Transfer – To transfer some amount from logged in account 
to another using email id
7. Account Statement
8. Logout

----------


## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/9.x/installation#installation)


Clone the repository

    git clone https://github.com/swalihvmbazar/banking-app.git

Switch to the repo folder

    cd banking-app

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000


**Make sure you set the correct database connection information before running the migrations** 

    php artisan migrate
    php artisan serve


## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
