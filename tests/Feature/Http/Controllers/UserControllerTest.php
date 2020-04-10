<?php

namespace Tests\Feature\Http\Controllers;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_update_own_profile()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post(route('user.profile.update', $user), [
            'experience_years' => 5,
        ]);

        $response->assertSuccessful();
        $user->refresh();
        $this->assertEquals(5, $user->experience_years);
    }

    /** @test */
    public function user_cannot_update_foreign_profile()
    {
        $user = factory(User::class)->create();
        $foreign_user = factory(User::class)->create([
            'experience_years' => 2,
        ]);
        $response = $this->actingAs($user)->post(route('user.profile.update', $foreign_user), [
            'experience_years' => 5,
        ]);

        $response->assertForbidden();
        $foreign_user->refresh();
        $this->assertEquals(2, $foreign_user->experience_years);
    }
}
