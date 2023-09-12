<?php

namespace Tests\Unit;

use Tests\TestCase;

class ArtisanCommandTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRouteListCommand()
    {
        $this->artisan('route:list')
            ->assertExitCode(0);
    }
}
