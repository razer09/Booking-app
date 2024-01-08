<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferTest extends TestCase
{
    use RefreshDatabase;
    // pa test --filter TransferTest --verbose

    public function test_transfer_screen_can_be_rendered_with_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/transfer');

        $response->assertStatus(200);
    }

    public function test_transfer_screen_cannot_be_rendered_without_user(): void
    {
        $response = $this->get('/transfer');

        $response->assertStatus(302);
    }

    public function test_transfer_action_with_negative_amount(): void
    {
        $user = User::factory()->create([ 'balance' => 100 ]);
        $this->actingAs($user);
        $user2 = User::factory()->create([ 'balance' => 100 ]);

        $response = $this->post('/transfer', [
            'amount' => -20,
            'email' => $user2->email
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_transfer_action_with_no_availble_balance(): void
    {
        $user = User::factory()->create([ 'balance' => 10 ]);
        $this->actingAs($user);
        $user2 = User::factory()->create([ 'balance' => 0 ]);

        $response = $this->post('/transfer', [
            'amount' => 20,
            'email' => $user2->email
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_transfer_action_with_an_email_that_doesnt_exist(): void
    {
        $user = User::factory()->create([ 'balance' => 100 ]);
        $this->actingAs($user);

        $response = $this->post('/transfer', [
            'amount' => -20,
            'email' => 'nonexistan@email.com'
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_transfer_action_to_the_same_user(): void
    {
        $user = User::factory()->create([ 'balance' => 100 ]);
        $this->actingAs($user);

        $response = $this->post('/transfer', [
            'amount' => -20,
            'email' => $user->email
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_transfer_action_succeed_with_valid_amount_and_valid_email(): void
    {
        $user = User::factory()->create([ 'balance' => 100 ]);
        $this->actingAs($user);
        $user2 = User::factory()->create([ 'balance' => 100 ]);

        $response = $this->post('/transfer', [
            'amount' => 20,
            'email' => $user2->email
        ]);

        $response->assertRedirect();
    }

}
