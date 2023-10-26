<?php

namespace Tests\Unit;

use App\Http\Requests\kb\PageRequest;
use App\Model\kb\Page;
use App\User;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    protected $user; // Declare a user property

    // Set up the authenticated user before each test
    public function setUp(): void
    {
        parent::setUp();

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
    }

    /** @test */
    public function it_can_display_the_page_index_page()
    {
        $this->setUp();
        $response = $this->get(route('page.index'));

        $response->assertStatus(200);
    }

    public function testCreateMethod()
    {
        $this->setUp();
        $response = $this->get('/page/create');

        $response->assertStatus(200);
    }

    public function testValidationPasses()
    {
        $this->setUp();
        $data = [
            'name'        => 'New Page',
            'description' => 'Page Description',
        ];

        $validator = Validator::make($data, (new PageRequest())->rules());

        $this->assertTrue($validator->passes());

        $response = $this->post(route('page.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('kb_pages', $data);
    }

    public function testValidationFailsWhenNameMissing()
    {
        $this->setUp();
        $data = [
            'description' => 'Page Description',
        ];

        $validator = Validator::make($data, (new PageRequest())->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('name'));
    }

    public function testValidationFailsWhenNameNotUnique()
    {
        $this->setUp();
        $data = [
            'name'        => 'New Page',
            'description' => 'Page Description',
        ];

        $validator = Validator::make($data, (new PageRequest())->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('name'));
    }

    public function testValidationFailsWhenDescriptionMissing()
    {
        $this->setUp();
        $data = [
            'name' => 'New',
        ];

        $validator = Validator::make($data, (new PageRequest())->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('description'));
    }

    public function testEditPage()
    {
        $this->setUp();
        $page = Page::latest()->first();

        $response = $this->get('/page/'.$page->id.'/edit');

        $response->assertStatus(200);
    }

    public function testUpdatePage()
    {
        $this->setUp();
        $page = Page::latest()->first();

        $data = [
            'name'        => 'Updated Page Name',
            'description' => 'Updated Description',
        ];

        $validator = Validator::make($data, (new PageRequest())->rules());

        $this->assertTrue($validator->passes());
        $response = $this->put('/page/'.$page->id, $data);

        $response->assertStatus(302); // Assuming a successful update redirects
        $this->assertDatabaseHas('kb_pages', $data);
        // You can add more assertions as needed.
    }

    public function testCannotUpdatePage()
    {
        $this->setUp();
        $page = Page::latest()->first();

        $data = [
            'name'        => 'Updated Page Name',
            'description' => 'Updated Description',
        ];

        $validator = Validator::make($data, (new PageRequest())->rules());

        $this->assertFalse($validator->passes());
        $response = $this->put('/page/'.$page->id, $data);
        $response->assertStatus(302);
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('name'));
    }

    public function testDestroyMethod()
    {
        $this->setUp();
        $page = Page::latest()->first();

        $response = $this->delete('/page/'.$page->id);

        $response->assertStatus(302); // Assuming a successful deletion redirects
        $this->assertDatabaseMissing('kb_pages', ['id' => $page->id]);
        // You can add more assertions as needed.
    }
}
