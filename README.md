# Vigia AG Dusk QA 2FA Login Test Challenge

Hey there, dear developer candidate! 

We have created a small but tricky challenge for you. Please fork this repository and add a Laravel Dusk test that tests the login for a user with two factor authentication enabled. 

## Required Steps the test has to perform
1. Open the login page
2. Enter login credentials
3. Submit
4. Enter two factor authentication code
5. Submit
6. See "Dashboard"


## Installation

Clone the repository and setup a basic Laravel environment

```
git clone git@github.com:Cannavigia/cannavigia-dusk-challenge.git
```

The project comes with Laravel Jetstream installed. To setup everything, run

```
npm install
npm run build
php artisan migrate
```

Then install Dusk and write the test as described above.
