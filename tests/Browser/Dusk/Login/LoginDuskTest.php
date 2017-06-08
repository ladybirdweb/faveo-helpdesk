<?php

namespace Tests\Browser\Dusk\Login;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginDuskTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            
            $browser->visit('/auth/login')
                    ->type('input[name=email]', 'demo_admin')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/faveo/faveo-helpdesk-community/public/dashboard')
                    ;
        });
    }
}
