<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\WasteCategory;
use App\Models\WasteGrade;
use App\Models\WasteTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WasteTransactionWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_peserta_can_submit_waste_transaction_and_points_do_not_increase_before_approval(): void
    {
        $peserta = User::where('role', 'peserta')->first();
        $initialPoints = $peserta->total_points;

        $botol = WasteCategory::where('name', 'Botol')->first();

        $response = $this->actingAs($peserta)->post(route('peserta.transactions.store'), [
            'category_id' => $botol->id,
            'quantity_or_weight' => 15,
        ]);

        $response->assertRedirect(route('peserta.transactions.index'));
        $response->assertSessionHas('success');

        $transaction = WasteTransaction::where('user_id', $peserta->id)->latest('id')->first();
        $this->assertNotNull($transaction);
        $this->assertEquals('pending', $transaction->status);
        $this->assertEquals(0, $transaction->earned_points);
        $this->assertNull($transaction->grade_id);

        // Saldo poin peserta (users.total_points) TIDAK BOLEH bertambah sebelum status transaksi diubah menjadi approved oleh Admin (Rules.md)
        $peserta->refresh();
        $this->assertEquals($initialPoints, $peserta->total_points);
    }

    public function test_admin_can_approve_transaction_with_grade_and_points_are_added(): void
    {
        $admin = User::where('role', 'admin')->first();
        $peserta = User::where('role', 'peserta')->first();
        $peserta->update(['total_points' => 0]);

        $kaleng = WasteCategory::where('name', 'Kaleng')->first();
        $gradeA = WasteGrade::where('grade_code', 'A')->first(); // +4 bonus point

        // Peserta sets up a transaction with 350 grams (Base points = 350/100 = 3)
        $transaction = WasteTransaction::create([
            'user_id' => $peserta->id,
            'category_id' => $kaleng->id,
            'quantity_or_weight' => 350,
            'status' => 'pending',
            'earned_points' => 0,
        ]);

        // Admin approves with Grade A
        $response = $this->actingAs($admin)->post(route('admin.transactions.approve', $transaction), [
            'grade_id' => $gradeA->id,
            'notes' => 'Kondisi kaleng bersih.',
        ]);

        $response->assertRedirect(route('admin.transactions.index'));
        $response->assertSessionHas('success');

        $transaction->refresh();
        $this->assertEquals('approved', $transaction->status);
        $this->assertEquals($admin->id, $transaction->verified_by);
        $this->assertEquals($gradeA->id, $transaction->grade_id);

        // Total Points = 3 (base) + 4 (Grade A) = 7
        $this->assertEquals(7, $transaction->earned_points);

        $peserta->refresh();
        $this->assertEquals(7, $peserta->total_points);
    }

    public function test_admin_can_reject_transaction(): void
    {
        $admin = User::where('role', 'admin')->first();
        $peserta = User::where('role', 'peserta')->first();
        $peserta->update(['total_points' => 10]);

        $botol = WasteCategory::where('name', 'Botol')->first();

        $transaction = WasteTransaction::create([
            'user_id' => $peserta->id,
            'category_id' => $botol->id,
            'quantity_or_weight' => 5,
            'status' => 'pending',
            'earned_points' => 0,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.transactions.reject', $transaction), [
            'notes' => 'Botol rusak parah dan terkontaminasi minyak.',
        ]);

        $response->assertRedirect(route('admin.transactions.index'));
        $response->assertSessionHas('success');

        $transaction->refresh();
        $this->assertEquals('rejected', $transaction->status);
        $this->assertEquals(0, $transaction->earned_points);

        // Peserta points remain unchanged
        $peserta->refresh();
        $this->assertEquals(10, $peserta->total_points);
    }
}
