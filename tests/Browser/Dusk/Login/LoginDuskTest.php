<?php

namespace Tests\Browser\Dusk\Login;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

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
                    ->assertPathIs('/faveo/faveo-helpdesk-community/public/dashboard');
        });
    }
}
