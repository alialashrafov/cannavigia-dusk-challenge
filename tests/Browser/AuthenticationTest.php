<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use PragmaRX\Google2FA\Google2FA;

class AuthenticationTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();

        // Necessary otherwise user will stay logged in between tests...
        foreach (static::$browsers as $browser) {
            $browser->driver->manage()->deleteAllCookies();
        }

    }

        public function test_user_login(){

            $this->browse(function (Browser $browser) {
                // Create User with 2FA enabling feature (two_factor_confirmed_at is very important)
                $user = User::factory()->create(['password' => bcrypt('password'), 'two_factor_confirmed_at' => now()]);

                // generate secret key using Fortify 2FAProvider
                $tfap = \App::make('Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider');
                $enable = new EnableTwoFactorAuthentication($tfap);
                $enablingUser2FA = $enable($user);

                // for getting current OTP, I am using Google2FA package
                $google2FA = new Google2FA();
                $currentOtp = $google2FA->getCurrentOtp(decrypt($user->two_factor_secret));

                //That`s all
                $browser->visit('/login')
                        ->type('email', $user->email)
                        ->type('password', 'password')
                        ->press('LOG IN')
                        ->type('code', $currentOtp)
                        ->press('LOG IN')
                        ->assertPathIs('/dashboard')
                        ->assertAuthenticated();
            });
        }
}
