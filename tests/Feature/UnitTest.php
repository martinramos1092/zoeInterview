<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function redirect_non_loggedin_users()
    {
        $response = $this->get('/main/successlogin')->assertRedirect('/main');
    }

    /** @test */
    public function redirect_loggedin_users()
    {
        $this->actingAs(factory(User::class)->create());
        $response = $this->get('/main/successlogin')->assertOk();
    }

}
