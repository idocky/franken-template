<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SpinFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration_redirects_to_personal_spin_page(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Jane',
            'phone' => '+123456',
        ]);

        $user = User::query()->firstOrFail();

        $response->assertRedirect(route('spins.index', $user->spin_uuid));
        $this->assertSame('Jane', $user->name);
    }

    public function test_history_displays_only_last_three_spins(): void
    {
        $user = User::query()->create([
            'name' => 'History User',
            'phone' => '5550001',
            'spin_uuid' => '89be625e-b45d-467e-bf90-0e7ef58db999',
            'is_active' => true,
        ]);

        $user->spins()->createMany([
            ['result' => 'Lose', 'points' => 0, 'random_number' => 101],
            ['result' => 'Win', 'points' => 30, 'random_number' => 300],
            ['result' => 'Win', 'points' => 120, 'random_number' => 400],
            ['result' => 'Win', 'points' => 400, 'random_number' => 800],
        ]);

        $response = $this->get(route('spins.history', ['uuid' => $user->spin_uuid]));

        $response->assertOk();
        $response->assertSee('800');
        $response->assertSee('400');
        $response->assertSee('300');
        $response->assertDontSee('101');
        $response->assertSee('Назад');
    }

    public function test_spin_page_displays_only_unique_link_without_user_info(): void
    {
        $user = User::query()->create([
            'name' => 'Visible User',
            'phone' => '5550004',
            'spin_uuid' => '89be625e-b45d-467e-bf90-0e7ef58db996',
            'is_active' => true,
        ]);

        $response = $this->get(route('spins.index', $user->spin_uuid));

        $response->assertOk();
        $response->assertSee(route('spins.index', $user->spin_uuid));
        $response->assertDontSee('Visible User');
        $response->assertDontSee('5550004');
        $response->assertDontSee('Status');
    }

    public function test_regenerate_updates_spin_uuid(): void
    {
        $user = User::query()->create([
            'name' => 'Regenerate User',
            'phone' => '5550002',
            'spin_uuid' => '89be625e-b45d-467e-bf90-0e7ef58db998',
            'is_active' => true,
        ]);

        $oldUuid = $user->spin_uuid;
        $response = $this->post(route('spins.regenerate', $oldUuid));

        $user->refresh();

        $response->assertRedirect(route('spins.index', $user->spin_uuid));
        $this->assertNotSame($oldUuid, $user->spin_uuid);
    }

    public function test_deactivate_marks_user_as_inactive(): void
    {
        $user = User::query()->create([
            'name' => 'Inactive User',
            'phone' => '5550003',
            'spin_uuid' => '89be625e-b45d-467e-bf90-0e7ef58db997',
            'is_active' => true,
        ]);

        $response = $this->post(route('spins.deactivate', $user->spin_uuid));

        $response->assertRedirect(route('home'));
        $this->assertFalse($user->fresh()->is_active);
    }

    public function test_expired_spin_link_redirects_to_home(): void
    {
        $user = User::query()->create([
            'name' => 'Expired User',
            'phone' => '5550005',
            'spin_uuid' => '89be625e-b45d-467e-bf90-0e7ef58db995',
            'is_active' => true,
        ]);

        $user->forceFill([
            'created_at' => Carbon::now()->subDays(7),
            'updated_at' => Carbon::now()->subDays(7),
        ])->save();

        $response = $this->get(route('spins.index', $user->spin_uuid));

        $response->assertRedirect(route('home'));
    }

    public function test_inactive_user_spin_page_redirects_to_home(): void
    {
        $user = User::query()->create([
            'name' => 'Blocked User',
            'phone' => '5550006',
            'spin_uuid' => '89be625e-b45d-467e-bf90-0e7ef58db994',
            'is_active' => false,
        ]);

        $response = $this->get(route('spins.index', $user->spin_uuid));

        $response->assertRedirect(route('home'));
    }

    public function test_inactive_user_history_page_redirects_to_home(): void
    {
        $user = User::query()->create([
            'name' => 'Blocked History User',
            'phone' => '5550007',
            'spin_uuid' => '89be625e-b45d-467e-bf90-0e7ef58db993',
            'is_active' => false,
        ]);

        $response = $this->get(route('spins.history', $user->spin_uuid));

        $response->assertRedirect(route('home'));
    }
}
