This system is about simple apartment rental - using Laravel 12 + vue 3 + innertia

[http://127.0.0.1:8000/login - where you can login
[http://127.0.0.1:8000/register - where you can register

User will create a reservation in the frontend and the submission 
you can view the booking in the Backend under bookings menu

You can also create booking in the Backend by supplying tenants and rooms

Export expenses under expenses menu item, in the dashboard it will compute number of tenants, revenue , total earnings

You can do the following to install it locally:

- create database
- configure .env

# to install vendor
- composer install

# the tables will be created
- php artisan migrate

# install modules
- npm install

# to serve 
- npm run dev

# serve to port 9001
- php artisan serve --port=9001

