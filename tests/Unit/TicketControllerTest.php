<?php

namespace Tests\Unit;

use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
use App\User;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_tooltip()
    {
        $faker = FakerFactory::create();

        //Create User -> Agent

        //$str = Str::random(10);
        $str = 'demopass';
        $password = Hash::make($str);
        $email = $faker->unique()->email();
        $user = new User([
            'first_name'   => $faker->firstName(),
            'last_name'    => $faker->lastName(),
            'email'        => $email,
            'user_name'    => $faker->unique()->userName(),
            'password'     => $password,
            'active'       => 1,
            'role'         => 'agent',
            'agent_tzone'  => 81,
        ]);
        $user->save();

        // Check if data is inserted
        $this->assertDatabaseHas('users', ['email'=>$email]);

        // Authenticate as the created user
        $this->actingAs($user);

        $this->assertAuthenticated();

        // Define the dashboard route name
        $dashboardRouteName = 'dashboard';

        // Generate the dashboard route URL
        $dashboardUrl = route($dashboardRouteName);

        // Simulate a GET request to the dashboard route
        $dashboardResponse = $this->get($dashboardUrl);

        // Assert that the response status code is 200 (OK)
        $dashboardResponse->assertStatus(200);

        // Create a ticket for testing.

        $ticket = new Tickets(
            [
                'ticket_number' => 'TEST-0000-000'.$faker->randomDigit(),
                'user_id'       => $user->id,
                'priority_id'   => 2,
                'sla'           => 2,
                'help_topic_id' => 1,
                'status'        => 1,
                'source'        => 1,
            ]
        );

        $ticket->save();
        $ticket->dept_id = 1;
        $ticket->save();

        //Create Ticket_thread for Testing

        $ticket_thread = new Ticket_Thread(
            [
                'ticket_id' => $ticket->id,
                'user_id'   => $user->id,
                'poster'    => 'client',
                'title'     => 'TestCase2',
                'body'      => 'Testing2',
            ]
        );

        $ticket_thread->save();

        // Make a GET request to the getTooltip
        $response = $this->get(route('ticket.tooltip', ['ticket_id' => $ticket->id]));

        // Assert that the response status is 200 (OK).
        $response->assertStatus(200);
    }

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
