<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker;

class AuthenticationTest extends DuskTestCase
{
    protected string $email;
    protected string $name;
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
        $this->email = 'admin@admin.com';
        $this->name = 'Someone Else';

    }

    public function test_user_register() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', $this->name)
                ->type('email', $this->email)
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->pause(2000)
                ->press('REGISTER')
                ->pause(2000)
                ->assertPathIs('/dashboard');
        });
    }
    public function test_user_logout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/dashboard')
                ->logout()
                ->assertGuest();
        });
    }

        public function test_user_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@admin.com')
                    ->type('password', 'password')
                    ->press('LOG IN')
                    ->pause(2000)
                    ->assertPathIs('/dashboard')
                    ->assertAuthenticated();
        });
    }

    public function test_user_enable_two_factor() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', $this->email)
                    ->type('password', 'password')
                    ->press('LOG IN')
                    ->assertPathIs('/dashboard')
                    ->visit('/user/profile')
                    ->press("ENABLE")
                    ->pause(2000)
                    ->type('confirmable_password', 'password')
                    ->press('CONFIRM')
                    ->pause(2000)
                    ->assertPathIs('/user/profile');
        });
    }
}
