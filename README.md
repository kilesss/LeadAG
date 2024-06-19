
# Installation

composer install \
copy .env.example to .env \
php artisan migrate  \
php artisan db:seed  \
npm install  \
npm run dev  \
php artisan serve  


# About Project

## Backend

For validation is used request validation (for me is more elegant) \
About Database queries i try to use both DB builder and Eloquent ORM \
Web routes is configured to work with vue js and all other requests is REST


## Authentication

Its added default user which by default is logged (this user need to be added via seed) , this user have 2000 default \
amount. Its used middleware to logged automatic the user 

## Frontend

It used Vue js with bootstrap .
The project have 2 pages and one modal\
One page for creating new credit one for listing of all credits and one modal for make payments for every credit


