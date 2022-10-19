# Vigia AG Dusk QA 2FA Login Test Challenge

Hey there, dear developer candidate! 

We have created a small but tricky challenge for you. Please fork this repository and add a Laravel Dusk test that tests the login for a user with two factor authentication enabled. 

## Required Steps the Test has to perform
1. Create a user with 2FA enabled
2. Open the login page
3. Enter login credentials
4. Submit
5. Enter two factor authentication code
6. Submit
7. See "Dashboard"


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
