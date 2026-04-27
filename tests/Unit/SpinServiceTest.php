<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\SpinService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpinServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_lose_with_zero_points_for_odd_numbers(): void
    {
        $user = User::query()->create([
            'name' => 'Odd User',
            'phone' => '10001',
            'spin_uuid' => '89be625e-b45d-467e-bf90-0e7ef58db001',
            'is_active' => true,
        ]);

        $service = new SpinService;
        $spin = $service->spinWithNumber($user, 301);

        $this->assertSame('Lose', $spin->result);
        $this->assertSame('0.00', $spin->points);
    }

    public function test_it_uses_ten_percent_strategy_for_even_numbers_up_to_three_hundred(): void
    {
        $spin = $this->makeSpinForNumber(300);

        $this->assertSame('Win', $spin->result);
        $this->assertSame('30.00', $spin->points);
    }

    public function test_it_uses_thirty_percent_strategy_for_even_numbers_above_three_hundred(): void
    {
        $spin = $this->makeSpinForNumber(400);

        $this->assertSame('120.00', $spin->points);
    }

    public function test_it_uses_fifty_percent_strategy_for_even_numbers_above_six_hundred(): void
    {
        $spin = $this->makeSpinForNumber(800);

        $this->assertSame('400.00', $spin->points);
    }

    public function test_it_uses_seventy_percent_strategy_for_even_numbers_above_nine_hundred(): void
    {
        $spin = $this->makeSpinForNumber(902);

        $this->assertSame('631.40', $spin->points);
    }

    private function makeSpinForNumber(int $number)
    {
        $user = User::query()->create([
            'name' => 'Test User '.$number,
            'phone' => (string) (10000 + $number),
            'spin_uuid' => sprintf('89be625e-b45d-467e-bf90-%012d', $number),
            'is_active' => true,
        ]);

        return (new SpinService)->spinWithNumber($user, $number);
    }
}
