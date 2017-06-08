<?php

namespace Tests\Browser\Dusk\Install;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class InstallDuskTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testInstall()
    {
        $this->browse(function (Browser $browser) {
            
            $browser->visit('/step1')
                    ->check('#Acceptme')
                    ->press('Continue')
                    ->assertPathIs('/faveo/faveo-helpdesk-community/public/step2')
                    ->assertSee('OK, this system can run Faveo')
                    ->press('Continue')
                    ->assertPathIs('/faveo/faveo-helpdesk-community/public/step3')
                    ->select('default','MySQL')
                    ->type('host','localhost')
                    ->type('port','')
                    ->type('databasename','community')
                    ->type('username','root')
                    ->type('password','mysql')
                    ->press('Continue')
                    ->assertPathIs('/faveo/faveo-helpdesk-community/public/step4')
                    ->assertSee('Database connection successful. This system can run Faveo')
                    ->waitUntilMissing('#loader',45)
                    ->press('Continue')
                    ->assertPathIs('/faveo/faveo-helpdesk-community/public/step5')
                    ->assertSee('Personal Information')
                    ->type('firstname','vijay')
                    ->type('Lastname','vijay')
                    ->type('email','vijaysebastian111@gmail.com')
                    ->type('username','vijay')
                    ->type('password','password')
                    ->type('confirmpassword','password')
//                    ->select('datetime','DD/MM/YYYY H:i:s')
//                    ->select('timezone','Asia/Kolkata')
//                    ->select('language','English')
                    ->press('#submitme')
                    ->assertPathIs('/faveo/faveo-helpdesk-community/public/final')
                    ;
        });
    }
    
    
    
    
}
