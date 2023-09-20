<?php

namespace Tests\Unit;

use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
use App\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use DatabaseTransactions;


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_change_the_status()
    {
        $str = 'Demopass@1';
        $password = Hash::make($str);
        $user = new User([
            'first_name' => 'a',
            'last_name' => 'noor',
            'email' => 'naveen12@gmail.com',
            'user_name' => 'noor',
            'password' => $password,
            'active' => 1,
            'role' => 'user',
        ]);
        $user->save();
// Authenticate as the created user

        $this->actingAs($user);

        $ticket = new Tickets(
            [
                'ticket_number' => 'AAAA-0000-0001',
                'user_id' => $user->id,
                'priority_id' => 2,
                'sla' => 2,
                'help_topic_id' => 1,
                'status' => 1,
                'source' => 1
            ]
        );
        $ticket->save();
        $ticket->dept_id = 1;
        $ticket->save();

        $ticket_thread = new Ticket_Thread(
            [
                'ticket_id' => $ticket->id,
                'user_id' => $user->id,
                'poster' => 'client',
                'title' => 'TestCase',
                'body' => 'Testing',
            ]
        );
        $ticket_thread->save();


        $mytickets = $this->get(route('ticket2'));
        $mytickets->assertStatus(200);

        $response = $this->post(route('select_all'), [
            'select_all' => [$ticket->id],
            'submit' => 'Open',

        ]);

        // Assert that the response status code indicates success
        $response->assertStatus(302); // Adjust this as needed

        // Assert that the ticket's status has been updated to open

        $response->assertSessionHas('success', Lang::get('lang.tickets_have_been_opened'));
        $response = $this->post(route('select_all'), [
            'select_all' => [$ticket->id],
            'submit' => 'Close',
        ]);
        $response->assertStatus(302); // Adjust this as needed
        $this->assertEquals(3, $ticket->fresh()->status); // Adjust this as needed
        $response->assertSessionHas('success', Lang::get('lang.tickets_have_been_closed'));

    }
}
