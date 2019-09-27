<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Generator as Faker;
use App\User;

class UserCreate extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {

        $user = factory(User::class)->create();
        
        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);

    }
}
