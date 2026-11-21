<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\PointRedemption;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PointRedemptionWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_peserta_cannot_redeem_points_exceeding_total_points(): void
    {
        $peserta = User::where('role', 'peserta')->first();
        $peserta->update(['total_points' => 20]);

        // Attempt to redeem 25 points
        $response = $this->actingAs($peserta)->post(route('peserta.redemptions.store'), [
            'points_used' => 25,
        ]);

        $response->assertSessionHasErrors('points_used');

        $peserta->refresh();
        $this->assertEquals(20, $peserta->total_points);
        $this->assertDatabaseMissing('point_redemptions', [
            'user_id' => $peserta->id,
        ]);
    }

    public function test_peserta_can_redeem_valid_points_and_admin_can_complete(): void
    {
        $admin = User::where('role', 'admin')->first();
        $peserta = User::where('role', 'peserta')->first();
        $peserta->update(['total_points' => 35]);

        // Redeem 35 points: 1x20 (1000) + 1x10 (500) + 5x1 (500) = Rp 2.000
        $response = $this->actingAs($peserta)->post(route('peserta.redemptions.store'), [
            'points_used' => 35,
        ]);

        $response->assertRedirect(route('peserta.redemptions.index'));
        $response->assertSessionHas('success');

        // Points deducted immediately
        $peserta->refresh();
        $this->assertEquals(0, $peserta->total_points);

        $redemption = PointRedemption::where('user_id', $peserta->id)->first();
        $this->assertNotNull($redemption);
        $this->assertEquals(35, $redemption->points_used);
        $this->assertEquals(2000, $redemption->rupiah_amount);
        $this->assertEquals('pending', $redemption->status);

        // Admin marks as completed
        $completeResponse = $this->actingAs($admin)->post(route('admin.redemptions.complete', $redemption));
        $completeResponse->assertSessionHas('success');

        $redemption->refresh();
        $this->assertEquals('completed', $redemption->status);
    }
}
