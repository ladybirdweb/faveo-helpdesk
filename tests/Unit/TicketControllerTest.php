<?php

namespace Tests\Unit;

use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
use App\User;
use DateTimeZone;
use Faker\Factory as FakerFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    //Testing Reply Alert and Last Activity filed
    public function test_reply()
    {
        $faker = FakerFactory::create();

        // Get previously created user to authenticate

        $user = User::latest()->first();

        $this->actingAs($user);

        $this->assertAuthenticated();

        //Get previously created Ticket

        $tickets = Tickets::latest()->first();

        // Define the route URL with the Ticket ID

        $url = route('ticket.thread', ['id' => $tickets->id]);

        $response2 = $this->get($url);

        // Assert that the response status is 200 (OK).
        $response2->assertStatus(200);

        // Create fake data for the reply

        $replyData = [
            'ticket_ID'     => $tickets->id,
            'reply_content' => $faker->paragraph,
            'created_at'    => date_default_timezone_set('UTC'),
            'updated_at'    => date_default_timezone_set('UTC'),
        ];

        // Make a POST request to the route with the reply data
        $response3 = $this->post(route('ticket.reply', ['id' => $tickets->id]), $replyData);
        $response3->assertStatus(200);
        $response3->assertSee(Lang::get('lang.you_have_successfully_replied_to_your_ticket'));

    }
}
